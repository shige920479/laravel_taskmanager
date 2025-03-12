<?php
namespace App\Services;

use Carbon\Carbon;

class MyLib
{
  // Manager画面のタスク一覧に表示する残日数計算
  public static function diffDate(string $deadline) {
    $deadline_date = Carbon::parse($deadline);
    $today = Carbon::today();
    $remain_date = Carbon::today()->diffInDays($deadline_date);
    if($deadline_date < $today) {
      $remain_date = $remain_date * -1;
    }
    return $remain_date;
  }

}
