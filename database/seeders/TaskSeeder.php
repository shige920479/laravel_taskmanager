<?php

namespace Database\Seeders;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(file_get_contents(database_path('task_data.sql')));

        DB::table('tasks')
            ->whereNull('created_at')
            ->update([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
    }
}
