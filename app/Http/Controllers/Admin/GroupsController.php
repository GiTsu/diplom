<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\User;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::paginate(20);
        return view('admin.groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'title' => 'required|unique:subjects|max:255',
        ]);

        $model = new Group();
        $model->fill($request->all());
        if (!$model->save()) {
            return redirect()->back()->withErrors('не удалось сохранить модель');
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return view('admin.groups.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->route('groups.index');
    }

    public function dismiss(Request $request, User $user)
    {
        $user->group_id = null;
        $user->save();
        return redirect()->back();
    }
}
