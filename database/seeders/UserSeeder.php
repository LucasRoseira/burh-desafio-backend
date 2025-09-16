<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'cpf' => '123.456.789-00',
                'age' => 28,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'cpf' => '987.654.321-00',
                'age' => 32,
            ],
            [
                'name' => 'Lucas Gomes',
                'email' => 'lucas@example.com',
                'cpf' => '111.222.333-44',
                'age' => 25,
            ],
            [
                'name' => 'Maria Oliveira',
                'email' => 'maria@example.com',
                'cpf' => '555.666.777-88',
                'age' => 30,
            ],
            [
                'name' => 'Carlos Pereira',
                'email' => 'carlos@example.com',
                'cpf' => '999.888.777-66',
                'age' => 35,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
