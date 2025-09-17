<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function company_can_create_job_with_limits_based_on_plan()
    {
        $company = Company::factory()->create(['plan' => 'Free']);
        Job::factory()->count(5)->create(['company_id' => $company->id]);

        $payload = [
            'title' => 'New Job',
            'description' => 'Job desc',
            'type' => 'CLT',
            'salary' => 1500,
            'hours' => 8,
            'company_id' => $company->id
        ];

        $this->postJson('/api/jobs', $payload)
            ->assertStatus(422);
    }

    /** @test */
    public function user_can_apply_to_job_once()
    {
        $user = User::factory()->create();
        $job = Job::factory()->create();

        $this->postJson("/api/jobs/{$job->id}/apply", ['user_id' => $user->id])
            ->assertStatus(201);

        $this->postJson("/api/jobs/{$job->id}/apply", ['user_id' => $user->id])
            ->assertStatus(422);
    }

    /** @test */
    public function clt_job_must_have_min_salary()
    {
        $company = Company::factory()->create(['plan' => 'Premium']);
        $payload = [
            'title' => 'CLT Job',
            'description' => 'desc',
            'type' => 'CLT',
            'salary' => 1000,
            'hours' => 8,
            'company_id' => $company->id
        ];

        $this->postJson('/api/jobs', $payload)
            ->assertStatus(422);
    }

    /** @test */
    public function internship_job_must_have_max_hours_6()
    {
        $company = Company::factory()->create(['plan' => 'Premium']);
        $payload = [
            'title' => 'Internship Job',
            'description' => 'desc',
            'type' => 'Internship',
            'salary' => 0,
            'hours' => 8,
            'company_id' => $company->id
        ];

        $this->postJson('/api/jobs', $payload)
            ->assertStatus(422);
    }

    /** @test */
    public function it_can_list_jobs()
    {
        Job::factory()->count(3)->create();
        $this->getJson('/api/jobs')
            ->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function it_can_show_a_job()
    {
        $job = Job::factory()->create();
        $this->getJson("/api/jobs/{$job->id}")
            ->assertStatus(200)
            ->assertJson([
                'id' => $job->id,
                'title' => $job->title,
            ]);
    }

    /** @test */
    public function it_can_update_a_job()
    {
        $job = Job::factory()->create(['title' => 'Old Title']);
        $payload = ['title' => 'Updated Title'];

        $this->putJson("/api/jobs/{$job->id}", $payload)
            ->assertStatus(200)
            ->assertJson(['title' => 'Updated Title']);
    }

    /** @test */
    public function it_can_delete_a_job()
    {
        $job = Job::factory()->create();
        $this->deleteJson("/api/jobs/{$job->id}")
            ->assertStatus(204);

        $this->assertDatabaseMissing('jobs', ['id' => $job->id]);
    }

    /** @test */
    public function it_validates_required_fields_when_creating_job()
    {
        $this->postJson('/api/jobs', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'type', 'company_id']);
    }

    /** @test */
    public function it_fails_to_apply_with_invalid_user()
    {
        $job = Job::factory()->create();
        $this->postJson("/api/jobs/{$job->id}/apply", ['user_id' => 999])
            ->assertStatus(404);
    }
}
