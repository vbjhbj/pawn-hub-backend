<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            HoldingSeeder::class,
            SettlementSeeder::class,
            TypeGroupSeeder::class,
            TypeSeeder::class,
        ]);


        DB::table('users')->insert([
            'username' => "shopTest",
            'email' => 'shop@test.org',
            'password' => Hash::make('shopPassword'),
            'isCustomer' => 0,
        ]);
        DB::table('users')->insert([
            'username' => "custTest",
            'email' => 'cust@test.org',
            'password' => Hash::make('custPassword'),
            'isCustomer' => 1,
        ]);

        //\App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
