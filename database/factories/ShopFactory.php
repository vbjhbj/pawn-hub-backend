<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Services\Functions;
use App\Models\User;



/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\shop>
 */
class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $name = Functions::removeSpecialChars(fake()->unique()->realTextBetween($minNbChars = 8, $maxNbChars = 40, $indexSize = 3) . " " . fake()->companySuffix());
        $username = str_replace(" ","",Functions::removeAccents($name));
        $email = strtolower($username) . "@shop.com";
        $website = strtolower($username) . ".hu";
        $estYear = strval(random_int(1800, 2025));

        $user = User::factory()
                        ->asShop()
                        ->username($username)
                        ->email($email)
                        ->img((mt_rand(0, 4) == 1) ? null : null /*Functions::randomImg("shop")*/ )
                        ->create();





        return [
            'name' => $name,
            'taxId' => str_pad(mt_rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . '-' . mt_rand(0, 9) . '-' . str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT),
            'website' => (mt_rand(0, 1) == 1) ? $website : null,
            'estYear' => (mt_rand(0, 1) == 1) ? $estYear : null,
            'user_id' => $user->id,
            'address' => fake()->streetAddress(),
            'mobile' => "+36 " . str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT) . " " . str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT) . " " . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT),
            'settlement_id' => random_int(1,3570),
            'intro' => fake()->realTextBetween($minNbChars = 800, $maxNbChars = 5000, $indexSize = 5)
        ];
    }
}
