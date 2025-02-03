<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function App\Services\setSendIcon;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Task::where('user_id', '=' , $user->id);
        $sort = $request->sort_order;
        if(is_null($sort)) $tasks = $query->paginate(10)->withQueryString();
        if($sort === 'sort_deadline') $tasks = $query->orderBy('deadline')->paginate(10)->withQueryString();
        if($sort === 'sort_category') $tasks = $query->orderBy('category')->paginate(10)->withQueryString();
        if($sort === 'sort_priority') $tasks = $query->orderBy('priority', 'desc')->paginate(10)->withQueryString();
        $categories = $query->get()->pluck('category')->unique();

        return view('members.dashboard', compact('user', 'tasks', 'categories', 'sort'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $validated = $request->validated();
        // dd($validated);
        Task::create($validated);

        return to_route('members.dashboard')->with('success', '新規タスクを登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $user = Auth::user();
        $query = Task::where('user_id', '=' , $user->id);
        $categories = $query->get()->pluck('category')->unique();
        return view('members.edit', compact('task', 'categories', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $validated = $request->validated();
        $task->update($validated);

        return to_route('members.dashboard');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
