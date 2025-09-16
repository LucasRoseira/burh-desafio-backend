<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\Company;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();
        if ($companies->isEmpty()) {
            $this->command->info('No companies found. Please seed companies first.');
            return;
        }

        $jobs = [
            [
                'title' => 'Backend Developer',
                'description' => 'Develop and maintain APIs in Laravel',
                'type' => 'CLT',
                'salary' => 2500,
                'hours' => 8,
                'company_id' => $companies->random()->id,
            ],
            [
                'title' => 'Frontend Developer',
                'description' => 'Build responsive web interfaces',
                'type' => 'PJ',
                'salary' => 3000,
                'hours' => 8,
                'company_id' => $companies->random()->id,
            ],
            [
                'title' => 'Intern Software Developer',
                'description' => 'Assist in software development tasks',
                'type' => 'Internship',
                'salary' => 1000,
                'hours' => 6,
                'company_id' => $companies->random()->id,
            ],
            [
                'title' => 'DevOps Engineer',
                'description' => 'Manage CI/CD pipelines and servers',
                'type' => 'CLT',
                'salary' => 4000,
                'hours' => 8,
                'company_id' => $companies->random()->id,
            ],
            [
                'title' => 'UI/UX Designer',
                'description' => 'Design user interfaces and experiences',
                'type' => 'PJ',
                'salary' => 2800,
                'hours' => 8,
                'company_id' => $companies->random()->id,
            ],
        ];

        foreach ($jobs as $job) {
            Job::create($job);
        }
    }
}
