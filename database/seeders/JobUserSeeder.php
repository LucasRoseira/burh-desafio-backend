<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Job;

class JobUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $jobs = Job::all();

        if ($users->isEmpty() || $jobs->isEmpty()) {
            $this->command->info('No users or jobs found. Seed users and jobs first.');
            return;
        }

        foreach ($users as $user) {
            $randomJobs = $jobs->random(rand(1, min(3, $jobs->count())));

            foreach ($randomJobs as $job) {
                if (!$user->jobs()->where('job_id', $job->id)->exists()) {
                    $user->jobs()->attach($job->id);
                }
            }
        }

        $this->command->info('Job_user associations seeded successfully.');
    }
}
