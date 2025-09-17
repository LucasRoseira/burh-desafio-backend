<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'cnpj' => $this->faker->unique()->numerify('##.###.###/####-##'),
            'plan' => 'Free',
            'description' => $this->faker->sentence(),
        ];
    }
}
