<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $days = mt_rand(1, 20 * 365);
        $randomFutureDate = date('Y-m-d', strtotime("+$days days"));
        $randomPastDate = date('Y-m-d', strtotime("-$days days"));

        $days = mt_rand(1, $days-1);
        $randomPastDate2 = date('Y-m-d', strtotime("-$days days"));

        return [
            'customer_id' => (mt_rand(0, 9) == 1) ? 1 : random_int(1, 84),
            'shop_id' => (mt_rand(0, 9) == 1) ? 1 : random_int(1, 62),
            'expDate' => (mt_rand(0, 1) == 1) ? $randomFutureDate : $randomPastDate2,
            'givenAmount' => round(random_int(30000, 69999999), -3),
            'interest' => random_int(1, 20),
            'description' => (mt_rand(0, 9) == 1) ? null : fake()->realTextBetween($minNbChars = 10, $maxNbChars = 2000, $indexSize = 5),
            'created_at' => $randomPastDate,
        ];
    }
}
