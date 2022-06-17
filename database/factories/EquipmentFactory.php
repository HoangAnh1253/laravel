<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\Helpers\FactoryHelper;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment>
 */
class EquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'serial_number' => $this->faker->numerify('###TMA####'),
            'name' => $this->faker->name,
            'desc' => $this->faker->text,
            'status' =>  $this->faker->randomElement(['available', 'used']),
            'categories_id' => FactoryHelper::getRandomModelId(Category::class),
            'users_id' => FactoryHelper::getRandomModelId(User::class),
        ];
    }
}