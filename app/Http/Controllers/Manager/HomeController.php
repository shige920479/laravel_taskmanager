<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:manager');
    }

    public function index(Request $request)
    {
        $search = $request->all();
        $sort = $request->sort_order;
        $user = Auth::user();

        if(is_null($sort)) $tasks = Task::with('user')->search($search)->orderBy('updated_at', 'desc')->paginate(10);
        if($sort === 'sort_name') $tasks = Task::with('user')->search($search)->orderBy('user_id')->paginate(10);
        if($sort === 'sort_category') $tasks = Task::with('user')->search($search)->orderBy('category')->paginate(10);
        if($sort === 'sort_deadline') $tasks = Task::with('user')->search($search)->orderBy('deadline')->paginate(10);
        if($sort === 'sort_priority') $tasks = Task::with('user')->search($search)->orderBy('priority', 'desc')->paginate(10);

        $categories = DB::table('tasks')->pluck('category')->unique();
        $users = DB::table('users')->get();

        return view('manager.dashboard', compact('sort', 'user', 'tasks', 'users', 'categories', 'search'));
    }

    public function show(Request $request)
    {
        $user = Auth::user();
        $tasks = Task::with('user')->get();
        $categories = $tasks->pluck('category')->unique();

        Carbon::setLocale('ja');
        $current_week = $request->week ?? Carbon::today()->format('Y-m-d'); 
        $start_date = Carbon::parse($current_week)->startOfWeek(Carbon::MONDAY);
        $end_date = $start_date->copy()->endOfWeek(Carbon::FRIDAY);
        $prev_week = $start_date->copy()->subWeek()->format('Y-m-d');
        $next_week = $end_date->copy()->addWeek()->format('Y-m-d');

        return view('manager.callender', compact(
            'user', 'tasks', 'categories', 'start_date', 'end_date', 'prev_week', 'next_week'
        ));
    }

    public function destroy($id)
    {
        Task::findOrFail($id)->delete();

        return to_route('manager.dashboard')->with('success', 'タスクを削除しました');
    }
}
