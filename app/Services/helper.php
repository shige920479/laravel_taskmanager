<?php
namespace App\Sevices;

use Carbon\Carbon;

function diffDate(string $deadline) {
  $deadline_date = Carbon::parse($deadline);
  $diff_date = Carbon::today()->diffInDays($deadline_date);
  return $diff_date;
}