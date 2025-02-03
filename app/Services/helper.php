<?php
namespace App\Services;

/**
 * メンバー：送信アイコン判定用フラグ操作（メンバー➡マネージャーへのメッセージ返信（送信）時）
 * 
 * @param int $msg_flag 0|1 メッセージが送信されたら1、以降は変更なし（履歴を表示する為）
 * @param int $mem_to_mg 0|1|2 初期:0、メンバー->マネージャーに返信:1、マネージャー確認:2、以降は1|2
 * @param int $task_id タスクid
 * @return string 画面遷移用パラメーター&&アイコン画像タグのhtml
 */
function setSendIcon(int $msg_flag, int $mem_to_mg): string
{
    if($msg_flag === 0) {
      return "";
    } elseif($mem_to_mg === 1) {
      return "<img src='{{ asset('images/hikoki.png') }}'>";
    } elseif($mem_to_mg === 2) {
      return "<img src='{{ asset('images/checkbox.png') }}'>";
    }
    return "";
}
