<?php

namespace Tests\Feature\Api\v1;

use App\Models\Store;
use App\Models\User;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ProductTypeSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Override;
use Tests\TestCase;

class ApiTokenPaginationTest extends TestCase
{
    use RefreshDatabase;

    protected User $operator;
    protected Store $store;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->seedTestDatabase();

        $this->operator = $this->createTestOperator();
        $this->store = $this->createTestStore($this->operator);
    }

    protected function seedTestDatabase()
    {
        $this->seed(RoleSeeder::class);
        $this->seed(ProductTypeSeeder::class);
        $this->seed(ProductSeeder::class);
    }

    protected function createTestOperator()
    {
        return User::factory()->create([
            'role_id' => 3
        ]);
    }

    protected function createTestStore(User $operator)
    {
        return Store::factory()->create([
            'operator_id' => $operator->id,
            'is_approved' => true
        ]);
    }

    protected function createTestToken(User $operator, Store $store)
    {
        $token = $operator->createToken(
            'Test Token',
            [
                'products:read'
            ]
        );

        $token->accessToken->store_id = $store->id;
        $token->accessToken->save();

        return $token;
    }

    public function testValidRequestPagination()
    {
        $token = $this->createTestToken($this->operator, $this->store);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?per_page=2');

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data',
            'links' => [
                'first',
                'last',
                'prev',
                'next'
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'per_page',
                'to',
                'total'
            ]
        ]);
    }

    public function testInvalidRequestPagination()
    {
        $token = $this->createTestToken($this->operator, $this->store);

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])
            ->getJson('/api/v1/products?per_page=500')
            ->assertStatus(422);
    }
}
