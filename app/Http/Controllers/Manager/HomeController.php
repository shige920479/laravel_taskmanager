<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Task;
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
        $sort = $request->sort_order;
        $user = Auth::user();
        $query = DB::table('tasks');

        if(is_null($sort)) $tasks = $query->orderBy('updated_at')->paginate(10);
        if($sort === 'sort_name') $tasks = $query->orderBy('user_id')->paginate(10);
        if($sort === 'sort_category') $tasks = $query->orderBy('category')->paginate(10);
        if($sort === 'sort_deadline') $tasks = $query->orderBy('deadline')->paginate(10);
        if($sort === 'sort_priority') $tasks = $query->orderBy('priority', 'desc')->paginate(10);

        $categories = $query->pluck('category')->unique();
        $members = DB::table('users')->get();
        // dd($user, $tasks, $members, $categories);
        // dd($tasks);


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
