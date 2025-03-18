<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('typegroups')->insert([

            ['name' => 'Antik tárgyak'],
            ['name' => 'Bútorok'],
            ['name' => 'Elektronikus eszközök'],
            ['name' => 'Ékszerek és kiegészítők'],
            ['name' => 'Gyermekjátékok'],
            ['name' => 'Háztartási eszközök'],
            ['name' => 'Hobbi és gyűjtemény'],
            ['name' => 'Járművek'],
            ['name' => 'Katonai és taktikai eszközök'],
            ['name' => 'Média'],
            ['name' => 'Művészet'],
            ['name' => 'Nemesfém'],
            ['name' => 'Ruhadarabok'],
            ['name' => 'Sporteszközök'],
            ['name' => 'Szerszámok'],
            ['name' => 'Egyéb']

        ]);

    }
}
