<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FormatHelper;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Test;
use App\Services\TestService;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    private $testService;

    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
    }

    public function unlinkTest(Request $request, $questionItem)
    {
        $question = Question::query()->findOrFail($questionItem);
        $test = Test::query()->findOrFail($request->input('testId')); // TODO: именование параметров к одному виду
        $test->questions()->detach($question);
        return redirect()->back();
    }

    public function assignTest(Request $request, $question)
    {
        $question = Question::query()->findOrFail($question);
        $test = Test::query()->findOrFail($request->input('test_id')); // TODO: именование параметров к одному виду
        // TODO: проверка на повторную привязку
        $test->questions()->attach($question);
        return redirect()->back();
    }

    public function linkTest(Request $request)
    {
        // если указан спрятанный id теста
        $testId = $request->input('test_id');
        $questionId = $request->input('question_id');

        if ($testId && ($test = Test::find($testId)) && ($model = Question::find($questionId))) {
            // TODO: проверка на повторную привязку
            $test->questions()->attach($model);
        }

        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $questions = Question::filter($request->all())->paginate(20);
        $questionTypes = Question::getTypes();
        $subjects = FormatHelper::getObjectsCollectionFormSelectData(Subject::all(), 'id', 'title');
        return view('admin.questions.index', compact('questions', 'questionTypes', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $questionTypes = Question::getTypes();
        $subjects = FormatHelper::getObjectsCollectionFormSelectData(Subject::all(), 'id', 'title');
        return view('admin.questions.create', compact('questionTypes', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TODO: ссаный гутенберг шлет какой-то левый запрос в стиле вордпресса и ломает перенаправление назад ->back()
        $newQuestion = $this->testService->createNewQuestion($request->all());
        if (!$newQuestion) {
            return redirect()->route('questions.create')->withInput($request->all())->withErrors($this->testService->getServiceErrors());
        }

        return redirect()->route('questions.show', [$newQuestion->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::findOrFail($id);
        $qTypes = Question::getTypes();
        $testsAvailable = FormatHelper::getObjectsCollectionFormSelectData(Test::all(), 'id', 'title');
        $filteredList = $question->questionItems->filter(function ($value, $key) {
            return empty($value->linked_id);
        });

        $linkAvailable = FormatHelper::getObjectsCollectionFormSelectData($filteredList, 'id', 'text');
        return view('admin.questions.show', compact('question', 'qTypes', 'linkAvailable', 'testsAvailable'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::query()->findOrFail($id);
        $questionTypes = Question::getTypes();
        $subjects = FormatHelper::getObjectsCollectionFormSelectData(Subject::all(), 'id', 'title');
        return view('admin.questions.edit', compact('question', 'questionTypes', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $question = Question::query()->findOrFail($id);
        if (!$this->testService->updateQuestion($question, $request->all())) {
            return redirect()
                ->route('questions.update', [$question->id])
                ->withInput($request->all())->withErrors($this->testService->getServiceErrors());
        }
        return redirect()->route('questions.show', [$question->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::query()->findOrFail($id);
        try {
            $question->delete();
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors('Не удалось удалить вопрос - отвяжите его от тестов');
        }
        return redirect()->route('questions.index');
    }
}
