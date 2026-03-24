<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        return [
            'price' => $this->faker->numberBetween(100000, 1000000),
            'location' => $this->faker->city(),
            'status' => $this->faker->randomElement(['active', 'sold', 'pending']),
            'agent_id' => User::factory(),
        ];
    }
}
