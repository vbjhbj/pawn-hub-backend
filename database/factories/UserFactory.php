<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Provider\hu_HU\Person;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'password' => Hash::make('password'),
            'iban' =>  implode('', array_map(fn() => chr(mt_rand(65, 90)), range(1, 2))) . str_pad(mt_rand(0, 999999999999), 12, '0', STR_PAD_LEFT)  . str_pad(mt_rand(0, 999999999999), 12, '0', STR_PAD_LEFT),
            'isCustomer' => true,
        ];
    }

    public function asCustomer()
    {
        return $this->state([
            'isCustomer' => true,
        ]);
    }
    public function asShop()
    {
        return $this->state([
            'isCustomer' => false,
        ]);
    }

    public function username($username)
    {
        return $this->state(function (array $attributes) use ($username) {
            return [
                'username' => $username,
            ];
        });
    }
    public function email($email)
    {
        return $this->state(function (array $attributes) use ($email) {
            return [
                'email' => $email,
            ];
        });
    }
    public function img($img)
    {
        return $this->state(function (array $attributes) use ($img) {

            return [
                'img' => $img,
            ];
        });
    } 

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
