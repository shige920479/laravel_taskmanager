<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'member1',
                'email' => 'member1@mail.com',
                'password' => Hash::make('member123'),
            ],
            [
                'name' => 'member2',
                'email' => 'member2@mail.com',
                'password' => Hash::make('member123'),
            ],
            [
                'name' => 'member3',
                'email' => 'member3@mail.com',
                'password' => Hash::make('member123'),
            ],
            [
                'name' => 'member4',
                'email' => 'member4@mail.com',
                'password' => Hash::make('member123'),
            ],
            [
                'name' => 'member5',
                'email' => 'member5@mail.com',
                'password' => Hash::make('member123'),
            ],
        ]);
    }
}
