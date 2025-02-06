<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Sevices\MyUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request);

        $search = $request->all();
        $sort = $request->sort_order;
        $user = Auth::user();
        
        // 下記はリレーションが成立していない
        // $task = Task::find(1);
        // $task_user = $task->users;
        // dd($task_user, $task);

        // 下記はリレーションが成立している
        // $task_user = User::first();
        // $task = $task_user->tasks;
        // dd($task_user, $task);

        // if(is_null($sort)) $tasks = Task::search($search)->users()->orderBy('updated_at')->paginate(10);
        // if($sort === 'sort_name') $tasks = Task::search($search)->orderBy('user_id')->paginate(10);
        // if($sort === 'sort_category') $tasks = Task::search($search)->orderBy('category')->paginate(10);
        // if($sort === 'sort_deadline') $tasks = Task::search($search)->orderBy('deadline')->paginate(10);
        // if($sort === 'sort_priority') $tasks = Task::search($search)->orderBy('priority', 'desc')->paginate(10);

        // $categories = DB::table('tasks')->pluck('category')->unique();
        // $members = DB::table('users')->get();

        // return view('manager.dashboard', compact('sort', 'user', 'tasks', 'members', 'categories', 'search'));
        

        // ここから下はとりあえずの内容
        $sort = $request->sort_order;
        $user = Auth::user();
        $query = DB::table('tasks');

        if(is_null($sort)) $tasks = $query->orderBy('updated_at', 'desc')->paginate(10);
        if($sort === 'sort_name') $tasks = $query->orderBy('user_id')->paginate(10);
        if($sort === 'sort_category') $tasks = $query->orderBy('category')->paginate(10);
        if($sort === 'sort_deadline') $tasks = $query->orderBy('deadline')->paginate(10);
        if($sort === 'sort_priority') $tasks = $query->orderBy('priority', 'desc')->paginate(10);

        $categories = $query->pluck('category')->unique();
        $members = DB::table('users')->get();

        return view('manager.dashboard', compact('sort', 'user', 'tasks', 'members', 'categories'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = Auth::user();
        $query = DB::table('tasks');
        $tasks = $query->get();
        $categories = $query->pluck('category')->unique();

        Carbon::setLocale('ja');
        $current_week = $request->week ?? Carbon::today()->format('Y-m-d'); 
        $start_date = Carbon::parse($current_week)->startOfWeek(Carbon::MONDAY);
        $end_date = Carbon::parse($current_week)->endOfWeek(Carbon::FRIDAY);
        $prev_week = $start_date->copy()->subWeek()->format('Y-m-d');
        $next_week = $end_date->copy()->addWeek()->format('Y-m-d');

        return view('manager.callender', compact(
            'user', 'tasks', 'categories', 'start_date', 'end_date', 'prev_week', 'next_week'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
