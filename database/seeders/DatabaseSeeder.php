<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Customer;
use App\Models\Shop;
use App\Models\Loan;
use App\Models\Item;
use App\Models\Message;

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

        if (filter_var(env('FACTORY', false), FILTER_VALIDATE_BOOLEAN)) {

            $this->command->line('Running Factories:');

            $this->command->line('  Customer Factory...');
            Customer::factory()->count(84)->create();
    
            $this->command->line('  Shop Factory...');
            Shop::factory()->count(62)->create();

            $this->command->line('  Loan Factory...');
            Loan::factory()->count(102)->create();

            $this->command->line('  Item Factory...');
            Item::factory()->count(202)->create();

            $this->command->line('  Message Factory...');
            Message::factory()->count(302)->create();

            $this->command->line('  Connection Factory...');

            for ($shopId = 1; $shopId < 62; $shopId++) {

                $added = [];
                $stop = random_int(0, 11);

                for ($j = 0; $j <= $stop; $j++) {

                    $custId = random_int(1, 84);

                    if (!in_array($custId, $added)){

                        DB::table('connections')->insert([
                            'customer_id' => $custId,
                            'shop_id' => $shopId,
    
                        ]);

                        $list[] = $custId;
                    }

                }
            }



            $this->command->line('');

        }




        DB::table('users')->insert([
            'username' => "shopTest",
            'email' => 'shop@test.org',
            'password' => Hash::make('shopPassword'),
            'isCustomer' => 0,
            'img' => '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'
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
