<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KlubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('klubs')->insert([
            [
                'nama' => 'Persib',
                'kota' => 'Bandung',
                'created_at' => Carbon::now()
            ],
            [
                'nama' => 'Persija',
                'kota' => 'Jakarta',
                'created_at' => Carbon::now()
            ],
        ]);
    }
}
