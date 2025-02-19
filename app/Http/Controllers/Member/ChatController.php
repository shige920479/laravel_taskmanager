<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:users');
    }

    public function chatView($id)
    {
        $user = Auth::user();
        $task = Task::findOrFail($id);
        // 未読メッセージの既読化処理
        if($task->mg_to_mem === 1) $task->mg_to_mem = 0;
        $task->save();

        $chats = Message::where('task_id', $id)->get();  

        return view('members.chatView', compact('user', 'task', 'chats'));
    }

    public function sendMessage(Request $request, $id)
    {
        $validated = $request->validate(['comment' => ['required', 'max:255']]);

        try {
            DB::transaction(function() use($validated, $id) {
                //メッセージの新規登録
                Message::create([
                    'task_id' => $id,
                    'comment' => $validated['comment'],
                    'sender' => 1,
                ]);
                //tasksテーブルのアイコン表示表ステータスの変更
                $task = Task::findOrFail($id);
                $task->mem_to_mg = 1;
                $task->save();
            });
        } catch(Throwable $e) {
            Log::error($e);
            throw $e;
        }
        
        return redirect()->back()->with('success', 'メッセージを送信しました');
    }
}
