<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HoldingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('holdings')->insert([
            ['name' => "Budapest"],
            ['name' => "Fejér"],
            ['name' => "Jász-Nagykun-Szolnok"],
            ['name' => "Baranya"],
            ['name' => "Heves"],
            ['name' => "Borsod-Abaúj-Zemplén"],
            ['name' => "Győr-Moson-Sopron"],
            ['name' => "Pest"],
            ['name' => "Vas"],
            ['name' => "Veszprém"],
            ['name' => "Szabolcs-Szatmár-Bereg"],
            ['name' => "Komárom-Esztergom"],
            ['name' => "Bács-Kiskun"],
            ['name' => "Csongrád"],
            ['name' => "Zala"],
            ['name' => "Békés"],
            ['name' => "Somogy"],
            ['name' => "Tolna"],
            ['name' => "Nógrád"],
            ['name' => "Hajdú-Bihar"]
        ]);

    }
}
