<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 28.01.19
 * Time: 11:03
 */

namespace App\Services;

use App\Models\AnswerItem;
use App\Models\Question;
use App\Models\QuestionItem;
use App\Models\Result;
use App\Models\Test;
use App\Services\Traits\ServiceCountersTrait;
use App\Services\Traits\ServiceErrorsTrait;
use App\Services\Traits\ServiceSuccessTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Validation\Rule;


class TestService
{
    use ServiceErrorsTrait;
    use ServiceCountersTrait;
    use ServiceSuccessTrait;

    public function __construct()
    {

    }

    public static function checkCorrect(AnswerItem $answer)
    {
        $question = $answer->question;
        $questionItems = $question->questionItems;

        if (empty($answer->value) && ($question->type_id != Question::ENTER_QUESTION)) {
            return false;
        }

        $correct = null;

        switch ($question->type_id) {
            case Question::SINGLE_QUESTION:
                $correct = false;
                if ($questionItems) {
                    foreach ($questionItems as $qi) {
                        if (($qi->id == $answer->value) && (!empty($qi->is_correct))) {
                            $correct = true;
                        }
                    }
                }
                break;
            case Question::MULTI_QUESTION:
                $correctAnswers = json_decode($answer->value);
                $correct = true;
                if (is_array($correctAnswers)) {
                    if ($questionItems) {
                        foreach ($questionItems as $qi) {
                            if (!empty($qi->is_correct) && !in_array($qi->id, $correctAnswers)) {
                                $correct = false;
                            }
                        }
                    }
                } else {
                    $correct = false;
                }
                break;

            case Question::COMPLY_QUESTION:
                $correctAnswers = json_decode($answer->value, true);
                //dd($correctAnswers);
                //dd($answer->getAttributes(), $questionItems);
                $correct = true;
                if ($questionItems) {
                    foreach ($questionItems as $qi) {
                        if (!empty($qi->linked_id)) {
                            if (empty($correctAnswers[$qi->id])) {
                                $correct = false;
                            } elseif ($correctAnswers[$qi->id] != $qi->linked_id) {
                                $correct = false;
                            }
                            //if (empty($correctAnswers[$qi->id]) )
                            //dd($correctAnswers, $qi->id, $qi->linked_id);
                            //$correct = false;
                        }
                    }
                }
                break;
            case Question::ENTER_QUESTION:
                $correct = null;
                break;
        }
        return $correct;
    }

    public function canDoTest(User $user, Result $result)
    {
        return true;
    }

    public function startTestResult(Result $result)
    {
        if (empty($result->start_at)) {
            $result->start_at = Carbon::now();
            return $result->save();
        }
        return true;
    }

    public function endTest(Result $result)
    {
        $result->end_at = Carbon::now();
        return $result->save();
    }

    public function getNextQuestion(User $user, Test $test, $lastId = 0)
    {
        if (empty($lastId)) { // fix null TODO: вынести в тип параметра int
            $lastId = 0;
        }
        // выбрать следующий за последним
        $question = $test->questions()->where('question_id', '>', $lastId)->orderBy('id', 'asc')->first();

        if ($question) {
            return $question;
        }
        $this->addServiceError('Не найдено вопросов после заданного');
        return null;
    }

    public function getPreviousQuestion(User $user, Test $test, $lastId = 0)
    {
        if (empty($lastId)) { // fix null
            $lastId = 0;
        }
        // выбрать следующий за последним
        $question = $test->questions()->where('question_id', '<', $lastId)->orderBy('id', 'desc')->first();

        if ($question) {
            return $question;
        }
        $this->addServiceError('Не найдено вопросов перед заданным');
        return null;
    }

    public function getUserTestResultRecord(User $user, Test $test)
    {
        // получим или создадим запись со статусом прохождения теста
        $userResult = $user->results()->where('test_id', '=', $test->id)->first();
        if (!$userResult) {
            $userResult = new Result();
            $userResult->fill([
                'test_id' => $test->id,
                'user_id' => $user->id,
            ]);
            $userResult->save();
        }
        return $userResult;
    }

    public function assignTestResultToUser(User $user, Test $test)
    {
        $userResult = new Result();
        $userResult->fill([
            'test_id' => $test->id,
            'user_id' => $user->id,
        ]);
        $userResult->save();
        return $userResult;
    }

    public function getQuestionAnswerItem(Result $result, Question $question)
    {
        return AnswerItem::where([
            ['result_id', '=', $result->id],
            ['question_id', '=', $question->id]
        ])->first();
    }

    public function createNewQuestion(array $fields)
    {
        $validationOK = $this->validateByService($fields, [
            'title' => 'required|unique:tests|max:255',
            'subject_id' => 'required',
            'type_id' => 'required',
            'text' => 'required'
        ]);

        if ($validationOK) {
            $model = new Question();
            $model->fill($fields);

            if ($model->save()) {
                // если указан спрятанный id теста
                $testId = !empty($fields['test_id']) ? $fields['test_id'] : null;
                if ($testId && $test = Test::find($testId)) {
                    $test->questions()->attach($model);
                }
                return $model;
            }

        }
        return null;
    }

    public function updateQuestion(Question $model, array $fields)
    {
        $validationOK = $this->validateByService($fields, [
            'title' => ['required', 'max:255', Rule::unique('questions')->ignore($model->id)],
            'subject_id' => 'required',
            //'type_id' => 'required',
            'text' => 'required'
        ]);
        if ($validationOK) {
            $model->fill($fields);
            return $model->save();
        }
        return false;
    }

    public function createNewTest(array $fields)
    {

        $validationOK = $this->validateByService($fields, [
            'title' => 'required|unique:tests|max:255',
        ]);
        if ($validationOK) {
            $model = new Test();
            $model->fill($fields);
            $model->user_id = \Auth::user()->id;
            // новый код проверки
            if (!empty($fields['opt_timelimit']) && !empty($fields['opt_notime'])) {
                $this->addServiceError('Выберите либо длительность теста либо отсутствие ограничения');
                return null;
            }
            if (!empty($model->opt_fullonly)) {
                $model->opt_return = 1;
                $model->opt_skip = 1;
            }
            // новый код проверки
            if ($model->save()) {
                return $model;
            }
        }
        return null;
    }

    public function updateTest(Test $model, array $fields)
    {
        $validationOK = $this->validateByService($fields, [
            'title' => ['required', 'max:255', Rule::unique('tests')->ignore($model->id)],
        ]);
        if ($validationOK) {
            // обнулить для проставления
            $model->opt_return = $model->opt_skip = $model->opt_fullonly = $model->opt_notime = 0;
            //
            $model->fill($fields);
            $model->user_id = \Auth::user()->id;
            // новый код проверки
            if (!empty($fields['opt_timelimit']) && !empty($fields['opt_notime'])) {
                $this->addServiceError('Выберите либо длительность теста либо отсутствие ограничения');
                return false;
            }
            // новый код проверки
            if (!empty($model->opt_fullonly)) {
                $model->opt_return = 1;
                $model->opt_skip = 1;
            }
            return $model->save();
        }
        return false;
    }

    public function dropTest(Test $model)
    {
        try {
            return $model->delete();
        } catch (\Throwable $e) {
            $this->addServiceError('Не удалось удалить тест', []);
        }
        return false;
    }

    public function toggleQuestionItemCorrect(QuestionItem $model)
    {
        if (in_array($model->question[0]->type_id, [Question::SINGLE_QUESTION, Question::MULTI_QUESTION])) {
            // TODO: ошибка проектирования
            if ($model->question[0]->type_id == Question::SINGLE_QUESTION) {
                // сбросить остальные в неправильных
                $model->question[0]->questionItems()->update(['is_correct' => null]);
            }
            $model->is_correct = (!empty($model->is_correct)) ? null : 1;
            return $model->save();
        }
        $this->addServiceError('Этот тип не поддерживает флаг правильности');
        return false;
    }
}
