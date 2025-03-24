<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Services\Functions;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $sender = random_int(1, 62 + 84);
        $recipient;

        do {
            $recipient = random_int(1, 62 + 84);

        } while (!($sender == $recipient));

        return [
            'sender' => $sender,
            'recipient' => $recipient,
            'subject' => Functions::removeSpecialChars(fake()->realTextBetween($minNbChars = 3, $maxNbChars = 100, $indexSize = 3)),
            'message' => fake()->realTextBetween($minNbChars = 40, $maxNbChars = 5000, $indexSize = 4)
        ];
    }
}
