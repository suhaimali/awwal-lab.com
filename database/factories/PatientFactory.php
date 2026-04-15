<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'age' => $this->faker->numberBetween(1, 100),
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'visit_date' => $this->faker->date(),
            'notes' => $this->faker->sentence(),
        ];
    }
}
