<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->userName(),
            'email' => fake()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'backer',
            'is_banned' => false
        ];
    }

    public function backer()
    {
        return $this->state(fn () => [
            'role' => 'backer',
        ]);
    }
    public function creator()
    {
        return $this->state(fn () => [
            'role' => 'creator',
            'phone' => fake()->phoneNumber(),
            'company_name' => fake()->company(),
        ]);
    }
    public function admin()
    {
        return $this->state(fn () => [
            'role' => 'admin',
            'phone' => fake()->phoneNumber(),
        ]);
    }
    public function active()
    {
        return $this->state(fn () => [
            'is_banned' => false,
        ]);
    }
    public function banned()
    {
        return $this->state(fn () => [
            'is_banned' => true,
        ]);
    }

    public function configure()
    {
        return $this->afterCreating(function ($user) {
            $user->notify('welcome');
        });
    }
}
