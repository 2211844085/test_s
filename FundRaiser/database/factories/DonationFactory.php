<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donation>
 */
class DonationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'backer_id' => User::inRandomOrder()
                                ->where('role', 'backer')
                                ->first()->id ?? User::factory()->backer(),
            'tier_id' => Tier::inRandomOrder()->first()->id ?? Tier::factory(),
            'amount' => function (array $attributes) {
                return Tier::find($attributes['tier_id'])->amount;
            }
        ];
    }
}
