<?php
namespace App\Services;

use Carbon\Carbon;

class MyLib
{
  public static function diffDate(string $deadline) {
    $deadline_date = Carbon::parse($deadline);
    $remain_date = Carbon::today()->diffInDays($deadline_date);
    return $remain_date;
  }
}
