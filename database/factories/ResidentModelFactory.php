<?php

namespace Database\Factories;

use App\Models\BaranggayModel;
use App\Models\ResidentModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResidentModelFactories>
 */
class ResidentModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ResidentModel::class;

    public function definition(): array
    {
        return [
            'brgy_id' => BaranggayModel::all()->random()->id,
            'mother_first_name' => $this->faker->firstName,
            'mother_middle_name' => $this->faker->lastName,
            'mother_last_name' => $this->faker->lastName,
            'father_first_name' => $this->faker->firstName,
            'father_middle_name' => $this->faker->lastName,
            'father_last_name' => $this->faker->lastName,
            'father_suffix' => $this->faker->suffix,
            'father_birthday' => $this->faker->date(),
            'mother_birthday' => $this->faker->date(),
            'mother_citizenship' => $this->faker->country,
            'father_citizenship' => $this->faker->country,
            'mother_place_birth' => $this->faker->city,
            'father_place_birth' => $this->faker->city,
        ];
    }
}
