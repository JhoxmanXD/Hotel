<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'documentNumber' => $this->faker->numerify('##########'),
            'address' => $this->faker->optional()->address(),
            'phone' => $this->faker->optional()->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail()
        ];
    }
}