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
use App\Models\Result;
use App\Models\Test;
use App\Services\Traits\ServiceCountersTrait;
use App\Services\Traits\ServiceErrorsTrait;
use App\Services\Traits\ServiceSuccessTrait;
use App\User;
use Carbon\Carbon;


class TestService
{
    use ServiceErrorsTrait;
    use ServiceCountersTrait;
    use ServiceSuccessTrait;

    public function __construct()
    {

    }

    public function canDoTest(User $user, Test $test)
    {
        return true;
    }

    public function endTest(Result $result)
    {
        $result->end_at = Carbon::now();
        return $result->save();
    }

    public function getNextQuestion(User $user, Test $test, $lastId = 0)
    {
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

    public function getQuestionAnswerItem(Result $result, Question $question)
    {
        return AnswerItem::where([
            ['result_id', '=', $result->id],
            ['question_id', '=', $question->id]
        ])->first();
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
            // новый код проверки
            if ($model->save()) {
                return $model;
            }
        }
        return null;
    }
}
