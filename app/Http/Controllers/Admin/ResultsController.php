<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FormatHelper;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Result;
use App\Models\Test;
use App\Services\TestService;
use App\User;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
    private $testService;

    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
    }

    public function index(Request $request)
    {
        $results = Result::filter($request->all())->orderBy('id', 'desc')->paginate(50);
        $tests = FormatHelper::getObjectsCollectionFormSelectData(Test::all(), 'id', 'title');
        $groups = FormatHelper::getObjectsCollectionFormSelectData(Group::all(), 'id', 'title');
        $marks = Result::getMarkArr();
        return view('admin.results.index', compact('results', 'tests', 'groups', 'marks'));
    }

    public function assignToGroup(Request $request, Test $test)
    {
        $group = Group::query()->findOrFail($request->input('group_id'));
        $users = User::query()->where('group_id', '=', $group->id)->get();
        if ($users->isNotEmpty()) {
            foreach ($users as $user) {
                $this->testService->assignTestResultToUser($user, $test);
            }
        }
        return redirect()->back();
    }

    public function assignToUser(Request $request, User $user, Test $test)
    {
        $this->testService->assignTestResultToUser($user, $test);
        return redirect()->back();
    }
}
