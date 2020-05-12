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


            if ($testQuestionCount == $userAnsweredCount) {
                // TODO: завершить тест, все отвечено ->endTest()
                $result->end_at = Carbon::now();
                $result->save();
                return redirect()->route('site:index');
            }
            $userAnsweredQuestionMaxId = 0;

            if ($userAnsweredCount) {
                $userAnsweredQuestionMaxId = $result->answers()->max('question_id');
            }


            $question = $this->testService->getNextQuestion($user, $test, $userAnsweredQuestionMaxId);
            // dd($testQuestionCount,$userAnsweredCount,$userAnsweredQuestionMaxId,$question);

            if ($question !== null) {
                return view('test.answerQuestion', compact('user', 'test', 'question', 'result'));
            }


        }
        return view('test.errors', ['testErrors' => $this->testService->getServiceErrors()]);
    }

    public function examTestAnswer(Request $request, Result $result)
    {
        // TODO: выбрать старый ответ!
        $user = \Auth::user();
        //dd($request->all());
        $answer = new AnswerItem();

        $question = Question::query()->findOrFail($request->input('question_id'));
        $value = null;
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

        $answer->fill([
            'result_id' => $result->id,
            //'question_item_id' => $request->input('question_items_id'),
            'question_id' => $request->input('question_id'),
            'value' => $value, // TODO: при кастомном типе здесь обработка типа вопроса
        ]);
        $answer->save();
        return redirect()->route('test:next', [$result->test_id]);
    }
}
