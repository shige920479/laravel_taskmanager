<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function chatView($id)
    {
        $user = Auth::user();
        $task = Task::findOrFail($id);

        // 未読メッセージの既読化処理
        if($task->mem_to_mg === 1) $task->mem_to_mg = 2;
        $task->save();

        $chats = Message::where('task_id', $id)->get();

        return view('manager.chatView', compact('user', 'task', 'chats'));

    }

    public function sendMessage(Request $request, $id)
    {
        $validated = $request->validate(['comment' => ['required', 'max:255']]);

        DB::transaction(function() use($validated, $id) {
            // メッセージの新規登録
            Message::create([
                'task_id' => $id,
                'comment' => $validated['comment'],
            ]);
            //tasksテーブルのアイコン表示表ステータスの変更
            $task = Task::findOrFail($id);
            $task->update([
                'msg_flag' => 1,
                'mg_to_mem' => 1
            ]);
        });
        return redirect()->back()->with('success', 'メッセージを送信しました');
    }

    public function sendBack(Request $request, $id)
    {
        $validated = $request->validate(['comment' => ['required', 'max:255'],]);

        DB::transaction(function() use($id, $validated) {
            // メッセージの新規登録
            Message::create([
                'task_id' => $id,
                'comment' => $validated['comment'],
            ]);
            //tasksテーブルのアイコン表示表ステータスの変更、完了フラグの変更
            $task = Task::findOrFail($id);
            $task->update([
                'msg_flag' => 1,
                'mg_to_mem' => 1,
                'del_flag' => 2
            ]);
        });
        return redirect()->back()->with('success', 'このタスクの完了処理を差し戻しました。');
    }
}