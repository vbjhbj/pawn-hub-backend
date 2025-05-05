<?php

namespace Database\Factories;
use App\Services\Functions;


use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $payed = round(random_int(400, 9999999), -2);
        $estimated = round($payed * (mt_rand(11, 15) / 10), -3);
        
        $shop_id = null;
        $loan_id = null;

        if (mt_rand(0, 1) == 1) {
            $loan_id = (mt_rand(0, 13) == 1) ? 1 : random_int(1, 102);
        }

        $shop_id = (mt_rand(0, 15) == 1) ? 1 : random_int(1, 62);



        ini_set('memory_limit', '256M');

        return [
            'name'=> Functions::removeSpecialChars(fake()->sentence()),
            'description' => (mt_rand(0, 9) == 1) ? null : fake()->realTextBetween($minNbChars = 10, $maxNbChars = 2000, $indexSize = 5),
            'location' => (mt_rand(0, 9) == 1) ? null : fake()->realTextBetween($minNbChars = 10, $maxNbChars = 200, $indexSize = 5),
            'loan_id' => $loan_id,
            'shop_id' => $shop_id,
            'type_id' => random_int(1, 107),
            'payedValue' => $payed,
            'estimatedValue' => $estimated,
            'img' => (mt_rand(0, 9) == 1) ? null : Functions::randomImg("item"),
            'condition' => mt_rand(1, 5)
        ];
    }
}
