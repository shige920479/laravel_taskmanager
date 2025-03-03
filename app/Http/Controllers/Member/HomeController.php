<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:users');

        $this->middleware(function ($request, $next) {
            $task_id = $request->route()->parameter('id');
            if(!is_null($task_id)) {
                $user_id = Task::findOrFail($task_id)->user_id;
                if($user_id !== (int)Auth::id()) {
                    abort(404);
                }        
            }
            return $next($request);            
        });
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Task::where([
            ['user_id', '=', $user->id],
            ['del_flag', '!=', 1],
        ]);
        $sort = $request->sort_order;
        if(is_null($sort)) $tasks = $query->orderBy('updated_at', 'desc')->paginate(10);
        if($sort === 'sort_deadline') $tasks = $query->orderBy('deadline')->paginate(10);
        if($sort === 'sort_category') $tasks = $query->orderBy('category')->paginate(10);
        if($sort === 'sort_priority') $tasks = $query->orderBy('priority', 'desc')->paginate(10);
        $categories = $query->get()->pluck('category')->unique();

        return view('members.dashboard', compact('user', 'tasks', 'categories', 'sort'));
    }

    public function store(TaskRequest $request)
    {
        $validated = $request->validated();
        // dd($validated);
        Task::create($validated);

        return to_route('members.dashboard')->with('success', '新規タスクを登録しました');
    }

    public function show(Request $request)
    {
        $user = Auth::user();
        $query = Task::where('user_id', $user->id);
        $tasks = $query->get();
        $categories = $query->pluck('category')->unique();

        
        Carbon::setLocale('ja');
        $current_week = $request->week ?? Carbon::today()->format('Y-m-d'); 
        $start_date = Carbon::parse($current_week)->startOfWeek(Carbon::MONDAY);
        $end_date = Carbon::parse($current_week)->endOfWeek(Carbon::FRIDAY);
        $prev_week = $start_date->copy()->subWeek()->format('Y-m-d');
        $next_week = $end_date->copy()->addWeek()->format('Y-m-d');

        return view('members.callender', compact(
            'user', 'tasks', 'categories', 'start_date', 'end_date', 'prev_week', 'next_week'
        ));
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $user = Auth::user();
        $query = Task::where('user_id', '=' , $user->id);
        $categories = $query->get()->pluck('category')->unique();
        return view('members.edit', compact('task', 'categories', 'user'));
    }

    public function update(UpdateTaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $validated = $request->validated();
        $task->update($validated);

        return to_route('members.dashboard');

    }

    public function complete($id)
    {
        $task = Task::findOrFail($id);
        $task->update(['del_flag' => 1,]);

        return to_route('members.dashboard')->with('success', 'タスクを1件完了にしました');
    }
}
