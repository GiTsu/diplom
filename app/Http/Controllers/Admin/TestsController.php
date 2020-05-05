<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Result;
use App\Models\Test;
use Illuminate\Http\Request;

class TestsController extends Controller
{
    public function showEvaluate(Result $result)
    {
        $markArr = Result::getMarkArr();
        return view('admin.tests.evaluate', compact('result', 'markArr'));
    }

    public function putEvaluate(Request $request, Result $result)
    {
        $result->percent = $request->input('percent');
        $result->mark = $request->input('mark');
        $result->save();
        return redirect()->back();
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
        $validatedData = $request->validate([
            'title' => 'required|unique:tests|max:255',
        ]);

        //dd($validatedData);
        $model = new Test();
        $model->fill($request->all());
        $model->user_id = \Auth::user()->id;
        $model->save();

        return redirect()->route('tests.index');
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
        return view('admin.tests.show', compact('test', 'questionTypes'));
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
