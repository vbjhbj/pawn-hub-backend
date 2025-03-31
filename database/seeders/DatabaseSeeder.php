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
use Illuminate\Support\Facades\File;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // Other seeders:

        $this->call([
            HoldingSeeder::class,
            SettlementSeeder::class,
            TypeGroupSeeder::class,
            TypeSeeder::class,
        ]);

        // Permanent user profiles for Testing:

        DB::table('users')->insert([
            'username' => "shopTest",
            'email' => 'shop@test.org',
            'password' => Hash::make('shopPassword'),
            'iban' => "SO90000000000000",
            'isCustomer' => 0,
            'img' => File::get(storage_path('app/images/shop/00.txt'))
        ]);
        DB::table('shops')->insert([
            'name' => 'Shop Test',
            'taxId' => '12345678-9-12',
            'website' => 'https://www.shoptest.hu',
            'estYear' => 1999,
            'user_id' => 1,
            'address' => 'Zálogház u. 7.',
            'mobile' => "+36 12 345 6789",
            'settlement_id' => 2,
            'intro' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        ]);

        DB::table('users')->insert([
            'username' => "custTest",
            'email' => 'cust@test.org',
            'password' => Hash::make('custPassword'),
            'iban' => "CU90000000000000",
            'isCustomer' => 1,
            'img' => File::get(storage_path('app/images/customer/00.txt'))
        ]);
        DB::table('customers')->insert([
            'name' => 'Cust Test',
            'idCardNum' => '012345AB',
            'idCardExp' => '2030-10-10',
            'birthday' => '1969-07-20',
            'user_id' => '2',
            'shippingAddress' => '2750 Nagykőrös, Hajó u. 1.',
            'billingAddress' => '2750 Nagykőrös, Számla u. 1.',
            'mobile' => "+36 98 765 4321"
        ]);

        // Factory:

        if (filter_var(env('RUN_FACTORY', false), FILTER_VALIDATE_BOOLEAN)) {

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







    }
}
