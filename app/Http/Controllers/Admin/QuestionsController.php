<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FormatHelper;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function unlinkTest(Request $request, $questionItem)
    {
        $question = Question::query()->findOrFail($questionItem);
        $test = Test::query()->findOrFail($request->input('testId'));
        $test->questions()->detach($question);
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
    public function index()
    {
        $questions = Question::paginate(20);
        return view('admin.questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $questionTypes = Question::getTypes();
        return view('admin.questions.create', compact('questionTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:tests|max:255',
            'type_id' => 'required',
            'text' => 'required'
        ]);

        //dd($validatedData);
        $model = new Question();
        $model->fill($request->all());
        $model->save();

        // если указан спрятанный id теста
        $testId = $request->input('test_id');
        if ($testId && $test = Test::find($testId)) {
            $test->questions()->attach($model);
        }

        return redirect()->back();
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
        $filteredList = $question->questionItems->filter(function ($value, $key) {
            return empty($value->linked_id);
        });

        $linkAvailable = FormatHelper::getObjectsCollectionFormSelectData($filteredList, 'id', 'text');
        return view('admin.questions.show', compact('question', 'qTypes', 'linkAvailable'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
