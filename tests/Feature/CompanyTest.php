<?php

namespace Tests\Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_company()
    {
        $payload = [
            'name' => 'Test Company',
            'description' => 'Leading company in tech',
            'cnpj' => '12.345.678/0001-95',
            'plan' => 'Free'
        ];

        $this->postJson('/api/companies', $payload)
            ->assertStatus(201)
            ->assertJsonFragment(['name' => 'Test Company'])
            ->assertJsonFragment(['plan' => 'Free']);

        $this->assertDatabaseHas('companies', ['cnpj' => '12.345.678/0001-95']);
    }

    /** @test */
    public function it_cannot_create_company_with_duplicate_cnpj()
    {
        Company::factory()->create(['cnpj' => '12.345.678/0001-95']);

        $payload = [
            'name' => 'Duplicate Company',
            'cnpj' => '12.345.678/0001-95',
            'plan' => 'Free'
        ];

        $this->postJson('/api/companies', $payload)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['cnpj']);
    }

    /** @test */
    public function it_can_update_a_company_plan_and_description()
    {
        $company = Company::factory()->create([
            'plan' => 'Free',
            'description' => 'Old description'
        ]);

        $payload = [
            'plan' => 'Free',
            'description' => 'Updated description'
        ];

        $this->putJson("/api/companies/{$company->id}", $payload)
            ->assertStatus(200)
            ->assertJsonFragment(['plan' => 'Free'])
            ->assertJsonFragment(['description' => 'Updated description']);

        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'plan' => 'Free',
            'description' => 'Updated description'
        ]);
    }

    /** @test */
    public function it_can_delete_a_company()
    {
        $company = Company::factory()->create();

        $this->deleteJson("/api/companies/{$company->id}")
            ->assertStatus(204);

        $this->assertDatabaseMissing('companies', ['id' => $company->id]);
    }

    /** @test */
    public function it_validates_plan_field_when_creating()
    {
        $payload = [
            'name' => 'Invalid Plan Company',
            'cnpj' => '45.678.901/0001-23',
            'plan' => 'Ultra'
        ];

        $this->postJson('/api/companies', $payload)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['plan']);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $this->postJson('/api/companies', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'cnpj', 'plan']);
    }

    /** @test */
    public function it_can_list_companies_with_pagination()
    {
        Company::factory()->count(15)->create();

        $response = $this->getJson('/api/companies?per_page=10&page=2');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [['id', 'name', 'description', 'cnpj', 'plan', 'created_at', 'updated_at']],
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

        $this->assertCount(5, $response->json('data'));
    }
}
