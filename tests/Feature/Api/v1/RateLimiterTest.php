<?php

namespace Tests\Feature\Api\v1;

use app\Models\PersonalAccessToken;
use App\Models\Store;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Override;
use Tests\TestCase;

class RateLimiterTest extends TestCase
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
    }

    protected function createTestOperator()
    {
        return User::factory()->create([
            'role_id' => 3
        ]);

    }

    public function createTestStore(User $operator)
    {
        return Store::factory()->create([
            'operator_id' => $operator->id,
            'is_approved' => true
        ]);
    }

    public function createTestToken(User $operator, Store $store)
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

    public function testRateLimiter()
    {
        $token = $this->createTestToken($this->operator, $this->store);

        for ($i = 0; $i < 60; $i++) {
            $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $token->plainTextToken,
                'Accept' => 'application/json',
            ])
                ->getJson('/api/v1/products');

            $response->assertSuccessful();
        }

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])
            ->getJson('/api/v1/products')
            ->assertStatus(429);
    }

    public function testEachApiTokenHasIndependentRateLimit()
    {
        $tokenA = $this->createTestToken($this->operator, $this->store);
        $tokenB = $this->createTestToken($this->operator, $this->store);

        for ($i = 0; $i < 60; $i++) {
            $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $tokenA->plainTextToken,
                'Accept' => 'application/json',
            ])
                ->getJson('/api/v1/products');

            $response->assertSuccessful();
        }

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $tokenA->plainTextToken,
            'Accept' => 'application/json',
        ])
            ->getJson('/api/v1/products')
            ->assertStatus(429);

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $tokenB->plainTextToken,
            'Accept' => 'application/json',
        ])
            ->getJson('/api/v1/products')
            ->assertStatus(429);
    }
}
