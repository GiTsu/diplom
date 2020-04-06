<?php

namespace App\Http\Controllers;

use App\Models\AnswerItem;
use App\Models\Result;
use App\Models\Test;
use App\Services\TestService;
use App\User;
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
        $user = \Auth::user();
        if ($this->testService->canDoTest($user, $test)) {
            // посчитать количество отвеченных вопросов
            // если ноль - начать тест
            // если в середине - выдать вопрос
            // если кончились вопросы или время - завешить тест
            // TODO: попилить в сервис


            // считываем запись результата или создаем
            $userResultRecord = $this->testService->getUserTestResultRecord($user, $test);


            $testQuestionCount = $test->questions()->count();
            $userAnsweredCount = $user->answers()->where('test_id', '=', $test->id)->count();

            if ($testQuestionCount == $userAnsweredCount) {
                // TODO: завершить тест, все отвечено
                $userResultRecord->end_at = Carbon::now();
                $userResultRecord->save();
                return redirect()->route('site:index');
            }
            $userAnsweredQuestionMaxId = 0;

            if ($userAnsweredCount) {
                $userAnsweredQuestionMaxId = $user->answers()->where('test_id', '=', $test->id)->max('question_id');
            }


            $question = $this->testService->getNextQuestion($user, $test, $userAnsweredQuestionMaxId);

            if ($question !== null) {
                return view('test.answerQuestion', compact('user', 'test', 'question'));
            }


        }
        return view('test.errors', ['testErrors' => $this->testService->getServiceErrors()]);
    }

    public function examTestAnswer(Request $request, Test $test)
    {
        // TODO: выбрать старый ответ!
        $user = \Auth::user();
        $answer = new AnswerItem();
        $answer->fill([
            'user_id' => $user->id,
            'test_id' => $test->id,
            'question_id' => $request->input('question_id'),
            'value' => $request->input('question_items_id'),
        ]);
        $answer->save();
        return redirect()->route('test:next', [$test->id]);
    }
}
