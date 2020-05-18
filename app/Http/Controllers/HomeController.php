<?php

namespace App\Http\Controllers;

use App\Models\AnswerItem;
use App\Models\Question;
use App\Models\Result;
use App\Models\Test;
use App\Services\TestService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $testService;

    public function __construct(TestService $testService)
    {
        $this->middleware('auth');
        $this->testService = $testService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = \Auth::user();
        return view('home', compact('user'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        return view('home');
    }


    public function examTest(Request $request, Test $test)
    {
        app('debugbar')->disable();
        $goPrevious = $request->input('goPrevious');
        $goNext = $request->input('goNext');
        $finish = $request->input('finish');
        $user = \Auth::user();
        if ($this->testService->canDoTest($user, $test)) {
            // посчитать количество отвеченных вопросов
            // если ноль - начать тест
            // если в середине - выдать вопрос
            // если кончились вопросы или время - завешить тест
            // TODO: попилить в сервис


            // считываем запись результата или создаем
            $result = $this->testService->getUserTestResultRecord($user, $test);


            $testQuestionCount = $test->questions()->count();
            $userAnsweredCount = $result->answers()->count();

            // проверить автоматическое завершение теста
            if ($test->opt_timelimit) { // TODO: флеш мессадж о завершении теста
                $diff = Carbon::now()->diffInMinutes($result->start_at);
                if ($diff >= $test->opt_timelimit) {
                    $this->testService->endTest($result);
                }
            }

            // проверить кнопку завершения
            if ($finish) { // TODO: дописать проверку на все ответы
                $this->testService->endTest($result);
            }
            // если все вопросы отвечены и нельзя перематывать назад - автоматически завершить тест
            if (($testQuestionCount == $userAnsweredCount) && empty($test->opt_previous)) {
                $this->testService->endTest($result);
            }

            if (!empty($result->end_at)) {
                return redirect()->route('site:index');
            }

            // навигация по вопросам
            $question = null;
            //dd($goPrevious,$goNext);
            if ($goPrevious || $goNext) {
                // если есть перемотка от конкретного ID, попытаться выбрать по нему
                if ($goPrevious) {
                    $question = $this->testService->getPreviousQuestion($user, $test, $goPrevious);
                }
                if ($goNext) {
                    $question = $this->testService->getNextQuestion($user, $test, $goNext);
                }
            }
            if ($question == null) {
                $userAnsweredQuestionMaxId = $result->answers()->max('question_id');
                $question = $this->testService->getNextQuestion($user, $test, $userAnsweredQuestionMaxId);
            }

            if ($question !== null) {
                $answerItem = $this->testService->getQuestionAnswerItem($result, $question);
                return view('test.answerQuestion', compact('user', 'test', 'question', 'answerItem', 'result'));
            }


        }
        return view('test.errors', ['testErrors' => $this->testService->getServiceErrors()]);
    }

    public function examTestAnswer(Request $request, Result $result)
    {
        // TODO: выбрать старый ответ!
        $user = \Auth::user();
        //dd($request->all());

        $question = Question::query()->findOrFail($request->input('question_id'));
        $value = null;
        // обработка типа вопроса
        switch ($question->type_id) {
            case Question::SINGLE_QUESTION:
                $value = $request->input('value');
                break;
            case Question::MULTI_QUESTION:

                $value = json_encode($request->input('value'));

                break;
            case Question::ENTER_QUESTION:
                $value = $request->input('value');
                break;
            case Question::COMPLY_QUESTION:
                $value = json_encode($request->input('linked'));
                break;
        }
        // выбираем или создаем новый ответ
        $answer = $this->testService->getQuestionAnswerItem($result, $question);
        if (!$answer) {
            $answer = new AnswerItem();
        }
        $answer->fill([
            'result_id' => $result->id,
            //'question_item_id' => $request->input('question_items_id'),
            'question_id' => $request->input('question_id'),
            'value' => $value,
        ]);
        $answer->save();
        return redirect()->route('test:next', ['test' => $result->test_id, 'goNext' => $question->id]);
    }
}
