<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionItem;
use App\Services\TestService;
use Illuminate\Http\Request;

class QuestionItemsController extends Controller
{
    private $testService;

    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
    }

    public function linkQuestions(Request $request, QuestionItem $questionItem)
    {
        $linkId = $request->input('linked_id', null);
        //if ($linkId){
        $questionItem->linked_id = $linkId;
        $questionItem->save();
        //}

        return redirect()->back();
    }

    public function toggleCorrect(Request $request, QuestionItem $questionItem)
    {
        if (!$this->testService->toggleQuestionItemCorrect($questionItem)) {
            return redirect()->back()->withErrors($this->testService->getServiceErrors());
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.questionItems.create');
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
            'text' => 'required'
        ]);

        $model = new QuestionItem();
        $model->fill($request->all());
        $model->save();

        // если указан спрятанный id вопроса
        $questionId = $request->input('question_id');
        if ($questionId && $question = Question::find($questionId)) {
            $question->questionItems()->attach($model);
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
        //
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
        $qi = QuestionItem::query()->findOrFail($id);
        try {
            $qi->delete();
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors('Не удалось удалить ответ, отвяжите его от другого ответа');
        }
        return redirect()->back();
    }
}
