<?php

namespace Database\Factories;
use App\Models\User;
use Illuminate\Support\Str;
use App\Services\Functions;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $first_name = fake()->unique()->firstName();
        $last_name = fake()->unique()->lastName();
        $username = Functions::removeAccents($last_name . $first_name);
        $email = strtolower(Functions::removeAccents($last_name . "." . $first_name . "@cust.org"));

        $user = User::factory()
                        ->asCustomer()
                        ->username($username)
                        ->email($email)
                        ->create();

        $days = mt_rand(1, 25 * 365);
        $randomFutureDate = date('Y-m-d', strtotime("+$days days"));

        $days = mt_rand(1, 55 * 365) + 18 * 365;
        $randomPastDate = date('Y-m-d', strtotime("-$days days"));



        return [
            'name' => $last_name . " " .  $first_name,
            'idCardNum' => str_pad(mt_rand(0, 9999999), 6, '0', STR_PAD_LEFT) . implode('', array_map(fn() => chr(mt_rand(65, 90)), range(1, 2))),
            'idCardExp' => $randomFutureDate,
            'birthday' => $randomPastDate,
            'user_id' => $user->id,
            'shippingAddress' => fake()->address(),
            'billingAddress' => fake()->address(),
            'mobile' => "+36 " . str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT) . " " . str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT) . " " . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT),

        ];
    }
}
