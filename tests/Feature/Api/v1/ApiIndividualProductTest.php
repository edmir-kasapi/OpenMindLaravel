<?php

namespace Tests\Feature\Api\v1;

use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Database\Seeders\ProductTypeSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Override;
use Tests\TestCase;

class ApiIndividualProductTest extends TestCase
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

    /**
     * Helper Functions
     */
    protected function seedTestDatabase()
    {
        $this->seed(RoleSeeder::class);
        $this->seed(ProductTypeSeeder::class);
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
            'operator_id' => $this->operator->id,
            'is_approved' => true
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

    protected function createTestProduct()
    {
        return Product::factory()->create();
    }

    /**
     * Test Functions
     */
    public function testValidProduct(): void
    {
        $token = $this->createTestToken($this->operator, $this->store);
        $product = $this->createTestProduct();

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products/'.$product->id)
            ->assertSuccessful();
    }

    public function testInvalidProduct(): void
    {
        $token = $this->createTestToken($this->operator, $this->store);
        $product = $this->createTestProduct();

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products/99999')
            ->assertStatus(404);
    }
}
