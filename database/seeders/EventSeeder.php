<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $events = [
            [
                'event' => 'Cita #1',
                'start_date' => '2022-12-16 08:00:00',
                'end_date' => '2022-12-16 11:00:00'
            ]
        ];

        DB::table('events')->insert($events);
    }
}