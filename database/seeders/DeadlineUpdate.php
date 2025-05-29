<?php

namespace Database\Seeders;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeadlineUpdate extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $baseDate = Task::orderBy('deadline', 'asc')->first();
        $gapDate = Carbon::createFromDate($baseDate->deadline)->diffInDays(Carbon::today());
        $addDaysFloor = floor($gapDate / 7) * 7;
        $addDays = (int)$addDaysFloor;

        DB::update("UPDATE tasks SET deadline = DATE_ADD(deadline, INTERVAL {$addDays} DAY)");
    }
}
