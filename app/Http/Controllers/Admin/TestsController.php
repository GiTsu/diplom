<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FormatHelper;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Question;
use App\Models\Result;
use App\Models\Subject;
use App\Models\Test;
use App\Services\TestService;
use Illuminate\Http\Request;

class TestsController extends Controller
{
    private $testService;

    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
    }

    public function showEvaluate(Result $result)
    {
        $markArr = Result::getMarkArr();
        $questionsCount = $result->test->questions->count();
        $questionsCorrectCount = 0;
        return view('admin.tests.evaluate', compact('result', 'markArr', 'questionsCount', 'questionsCorrectCount'));
    }

    public function putEvaluate(Request $request, Result $result)
    {
        $markedQuestions = $request->input('marked_questions');
        $answersCount = $result->answers->count();
        if ($answersCount != $markedQuestions) {
            return redirect()->back()->withErrors('Не все вопросы оценены');
        }

        $result->percent = str_replace('%', '', $request->input('percent'));
        $result->mark = $request->input('mark');
        if (empty($result->mark)) {
            return redirect()->back()->withErrors('Оценка не указана');
        }

        $result->save();
        return redirect()->route('admin:results:index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tests = Test::paginate(20);
        return view('admin.tests.index', compact('tests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$test = $this->testService->createNewTest($request->all())) {
            return redirect()->back()->withErrors($this->testService->getServiceErrors());
        }
        return redirect()->route('tests.show', [$test->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $test = Test::with('creator')->findOrFail($id);
        $questionTypes = Question::getTypes();
        $selectQuestions = FormatHelper::getObjectsCollectionFormSelectData(Question::all(), 'id', 'title');
        $subjects = FormatHelper::getObjectsCollectionFormSelectData(Subject::all(), 'id', 'title');
        $groups = FormatHelper::getObjectsCollectionFormSelectData(Group::all(), 'id', 'title');
        return view('admin.tests.show', compact('test', 'questionTypes', 'selectQuestions', 'subjects', 'groups'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $test = Test::with('creator')->findOrFail($id);
        $questionTypes = Question::getTypes();
        return view('admin.tests.edit', compact('test', 'questionTypes'));
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
        $test = Test::with('creator')->findOrFail($id);
        if (!$this->testService->updateTest($test, $request->all())) {
            return redirect()->back()->withErrors($this->testService->getServiceErrors());
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $test = Test::with('creator')->findOrFail($id);
        if (!$this->testService->dropTest($test)) {
            return redirect()->back()->withErrors($this->testService->getServiceErrors());
        }
        return redirect()->route('tests.index');
    }
}
