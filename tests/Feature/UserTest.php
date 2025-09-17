<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_user()
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'cpf' => '123.456.789-00',
            'age' => '1990-05-05'
        ];

        $this->postJson('/api/users', $payload)
            ->assertStatus(201)
            ->assertJsonFragment(['email' => 'john@example.com']);

        $this->assertDatabaseHas('users', ['cpf' => '123.456.789-00']);
    }

    /** @test */
    public function it_cannot_create_user_with_duplicate_email_or_cpf()
    {
        User::factory()->create(['email' => 'john@example.com', 'cpf' => '123.456.789-00']);

        $payload = [
            'name' => 'Jane Doe',
            'email' => 'john@example.com',
            'cpf' => '123.456.789-00'
        ];

        $this->postJson('/api/users', $payload)
            ->assertStatus(422);
    }

    /** @test */
    public function it_can_search_users_and_include_jobs()
    {
        $user = User::factory()->create(['name' => 'Lucas Gomes']);
        $job = Job::factory()->create();
        $user->jobs()->attach($job->id);

        $this->getJson('/api/users/search?name=Lucas')
            ->assertStatus(200)
            ->assertJsonFragment(['name' => 'Lucas Gomes'])
            ->assertJsonStructure(['data' => [['jobs']]]);
    }

    /** @test */
    public function it_can_update_a_user()
    {
        $user = User::factory()->create(['name' => 'Old Name']);
        $payload = ['name' => 'Updated Name'];

        $this->putJson("/api/users/{$user->id}", $payload)
            ->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Name']);
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $user = User::factory()->create();
        $this->deleteJson("/api/users/{$user->id}")
            ->assertStatus(204);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function it_validates_required_fields_when_creating_user()
    {
        $this->postJson('/api/users', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'cpf']);
    }

    /** @test */
    public function it_fails_to_apply_to_job_with_invalid_user()
    {
        $job = Job::factory()->create();
        $this->postJson("/api/jobs/{$job->id}/apply", ['user_id' => 999])
            ->assertStatus(404);
    }

    /** @test */
    public function it_can_list_users_with_pagination()
    {
        User::factory()->count(15)->create();
        $this->getJson('/api/users?per_page=10&page=2')
            ->assertStatus(200)
            ->assertJsonStructure([
             
                'current_page',
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total'
            ]);
    }
}
