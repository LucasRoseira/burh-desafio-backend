<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->sentence(),
            'type' => 'CLT',
            'salary' => 1500,
            'hours' => 8,
            'company_id' => Company::factory(),
        ];
    }
}
