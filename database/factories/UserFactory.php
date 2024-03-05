<?php

namespace Database\Factories;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {
         // Generate a random phone number in the Syrian format
        $syrianPhoneNumber = '09' . rand(10000000, 99999999);

        // Create the user attributes
        $userAttributes = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => $this->randomlySetVerified(),
            'verification_code' => rand(1000, 9999),
            'password' => Hash::make('Sd00000000'),
            'phone' => $syrianPhoneNumber,
        ];
        
        return $userAttributes;
    }

    /**
     * Randomly sets the email_verified_at attribute.
     *
     * @return string|null
     */
    private function randomlySetVerified(): ?string
    {
        return rand(0, 1) ? now() : null; // 50% chance of having a timestamp
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole(RolesEnum::USER->value);
        });
    }

    
    public function verified(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => now(),
            ];
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    // public function unverified(): static
    // {
    //     return $this->state(fn (array $attributes) => [
    //         'email_verified_at' => null,
    //     ]);
    // }
}
