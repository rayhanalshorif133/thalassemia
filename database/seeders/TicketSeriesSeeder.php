<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketSeriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['series' => 'KA',  'ticket_number_range' => '0610001- 0660000', 'total_ticket' => 50000],
            ['series' => 'KHA', 'ticket_number_range' => '0610001- 0660000', 'total_ticket' => 50000],
            ['series' => 'GA',  'ticket_number_range' => '0610001- 0660000', 'total_ticket' => 50000],
            ['series' => 'GHA', 'ticket_number_range' => '0610001- 0660000', 'total_ticket' => 50000],
            ['series' => 'UMA', 'ticket_number_range' => '0610001- 0660000', 'total_ticket' => 50000],
            ['series' => 'CHA', 'ticket_number_range' => '0610001- 0660000', 'total_ticket' => 50000],
            ['series' => 'CSA', 'ticket_number_range' => '0610001- 0660000', 'total_ticket' => 50000],
            ['series' => 'JA',  'ticket_number_range' => '0610001- 0660000', 'total_ticket' => 50000],
            ['series' => 'JHA', 'ticket_number_range' => '0610001- 0660000', 'total_ticket' => 50000],
            ['series' => 'NYO', 'ticket_number_range' => '0610001- 0660000', 'total_ticket' => 50000],
        ];

        DB::table('ticket_series')->insert($data);
    }
}
