<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $start = 610001; // Shuru hobe 610001 theke

        foreach (range(0, 49999) as $i) {

            $ticketNo = 'NYO 0'. ($start + $i);

            DB::table('tickets')->insert([
                'ticket_series_id' => 10,
                'ticket_no' => $ticketNo,
                'sold_status' => 0, // Unsold
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
