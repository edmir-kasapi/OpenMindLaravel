<?php

namespace Tests\Feature\Api\v1;

use App\Models\Store;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Override;
use Tests\TestCase;

class ApiTokenBasicTest extends TestCase
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

    protected function createTestStore(User $operator)
    {
        return Store::factory()->create([
            'operator_id' => $operator->id,
            'is_approved' => true
        ]);
    }

    protected function createUnapprovedTestStore(User $operator)
    {
        return Store::factory()->create([
            'operator_id' => $this->operator->id,
            'is_approved' => false
        ]);
    }

    protected function createTestToken(User $operator, Store $store)
    {
        $token = $this->operator->createToken(
            'Test Token',
            [
                'products:read'
            ]
        );

        $token->accessToken->store_id = $store->id;
        $token->accessToken->save();

        return $token;
    }

    protected function createTestTokenWithoutPermission(User $operator, Store $store)
    {
        $token = $this->operator->createToken(
            'Test Token',
            []
        );

        $token->accessToken->store_id = $store->id;
        $token->accessToken->save();

        return $token;
    }

    protected function createRevokedTestToken(User $operator, Store $store)
    {
        $token = $this->operator->createToken(
            'Test Token',
            []
        );

        $token->accessToken->store_id = $store->id;
        $token->accessToken->revoked_at = now();
        $token->accessToken->save();

        return $token;
    }

    protected function createExpiredTestToken(User $operator, Store $store)
    {
        $token = $this->operator->createToken(
            'Test Token',
            [],
            now()
        );

        $token->accessToken->store_id = $store->id;
        $token->accessToken->save();

        return $token;
    }

    public function testRequestWithoutKey()
    {
        $this->withHeaders([
            'Authorization' => 'Bearer ' . '',
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products')
            ->assertStatus(401);
    }

    public function testRequestWithKey()
    {
        $token = $this->createTestToken($this->operator, $this->store);

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products')
            ->assertSuccessful();
    }

    public function testRequestWithKeyWithoutPermission()
    {
        $token = $this->createTestTokenWithoutPermission($this->operator, $this->store);

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products')
            ->assertStatus(403);
    }

    public function testRevokedToken()
    {
        $token = $this->createRevokedTestToken($this->operator, $this->store);

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products')
            ->assertStatus(401);
    }

    public function testUnapprovedStoreToken()
    {
        $unapprovedStore = $this->createUnapprovedTestStore($this->operator);

        $token = $this->createTestToken($this->operator, $unapprovedStore);

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products')
            ->assertStatus(401);
    }

    public function testExpiredToken()
    {
        $token = $this->createExpiredTestToken($this->operator, $this->store);

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products')
            ->assertStatus(401);
    }
}
