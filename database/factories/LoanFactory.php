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

        return [
            'customer_id' => random_int(1, 84),
            'shop_id' => random_int(1, 62),
            'expDate' => $randomFutureDate,
            'givenAmount' => round(random_int(30000, 99999999), -3),
            'interest' => random_int(1, 20),
        ];
    }
}
