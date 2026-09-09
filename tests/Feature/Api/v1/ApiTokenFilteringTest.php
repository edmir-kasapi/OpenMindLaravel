<?php

namespace Tests\Feature\Api\v1;

use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Database\Factories\ProductFactory;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ProductTypeSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Override;
use Tests\TestCase;

class ApiTokenFilteringTest extends TestCase
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

    public function testNameFiltering()
    {
        Product::factory()->create([
            'name' => 'Shiny phone'
        ]);
        Product::factory()->create([
            'name' => 'New phone'
        ]);
        Product::factory()->create([
            'name' => 'Macbook Pro'
        ]);

        $token = $this->createTestToken($this->operator, $this->store);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?name=phone');

        $response->assertSuccessful();
        $response->assertJsonCount(2, 'data');
    }

    public function testBrandFiltering()
    {
        Product::factory()->create([
            'brand' => 'totallynew'
        ]);
        Product::factory()->create([
            'name' => 'totalcrazy'
        ]);
        Product::factory()->create([
            'name' => 'totalizer'
        ]);

        $token = $this->createTestToken($this->operator, $this->store);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?brand=totally');

        $response->assertSuccessful();
        $response->assertJsonCount(1, 'data');
    }

    public function testTypeFiltering()
    {
        $type_id = 1;

        Product::factory()->count(4)->create([
            'type_id' => $type_id
        ]);

        $token = $this->createTestToken($this->operator, $this->store);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?product_type=' . $type_id);

        $response->assertSuccessful();
        $response->assertJsonCount(4, 'data');
    }

    public function testInvalidTypeFiltering()
    {
        $type_id = 1;

        Product::factory()->count(4)->create([
            'type_id' => $type_id
        ]);

        $token = $this->createTestToken($this->operator, $this->store);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?product_type=john');

        $response->assertStatus(422);
    }

    public function testMinPriceFiltering()
    {
        Product::factory()->create([
            'price' => 79.99
        ]);
        Product::factory()->create([
            'price' => 85.99
        ]);
        Product::factory()->create([
            'price' => 99.99
        ]);

        $token = $this->createTestToken($this->operator, $this->store);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?min_price=80');

        $response->assertSuccessful();
        $response->assertJsonCount(2, 'data');
    }

    public function testMaxPriceFiltering()
    {
        Product::factory()->create([
            'price' => 59.99
        ]);
        Product::factory()->create([
            'price' => 35.99
        ]);
        Product::factory()->create([
            'price' => 10.99
        ]);

        $token = $this->createTestToken($this->operator, $this->store);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?max_price=40');

        $response->assertSuccessful();
        $response->assertJsonCount(2, 'data');
    }

    public function testPriceRangeFiltering()
    {
        Product::factory()->create([
            'price' => 10.99
        ]);
        Product::factory()->create([
            'price' => 35.99
        ]);
        Product::factory()->create([
            'price' => 59.99
        ]);
        Product::factory()->create([
            'price' => 79.99
        ]);
        Product::factory()->create([
            'price' => 85.99
        ]);
        Product::factory()->create([
            'price' => 99.99
        ]);

        $token = $this->createTestToken($this->operator, $this->store);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?min_price=20&max_price=80');

        $response->assertSuccessful();
        $response->assertJsonCount(3, 'data');
    }

    public function testInvalidPriceRangeFiltering()
    {
        Product::factory()->create([
            'price' => 10.99
        ]);
        Product::factory()->create([
            'price' => 35.99
        ]);
        Product::factory()->create([
            'price' => 59.99
        ]);
        Product::factory()->create([
            'price' => 79.99
        ]);
        Product::factory()->create([
            'price' => 85.99
        ]);
        Product::factory()->create([
            'price' => 99.99
        ]);

        $token = $this->createTestToken($this->operator, $this->store);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?min_price=70&max_price=50');

        $response->assertStatus(422);
    }

    public function testStockLevelFiltering()
    {
        Product::factory()->create([
            'stock' => 10,
            'available_stock' => 10,
        ]);
        Product::factory()->create([
            'stock' => 30,
            'available_stock' => 30,
        ]);
        Product::factory()->create([
            'stock' => 40,
            'available_stock' => 40,
        ]);
        Product::factory()->create([
            'stock' => 50,
            'available_stock' => 50,
        ]);
        Product::factory()->create([
            'stock' => 70,
            'available_stock' => 70,
        ]);
        Product::factory()->create([
            'stock' => 80,
            'available_stock' => 80,
        ]);
        Product::factory()->create([
            'stock' => 90,
            'available_stock' => 90,
        ]);

        $token = $this->createTestToken($this->operator, $this->store);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?stock_level=medium-stock');

        $response->assertSuccessful();
        $response->assertJsonCount(3, 'data');
    }

    public function testInvalidStockLevelFiltering()
    {
        Product::factory()->create([
            'stock' => 10,
            'available_stock' => 10,
        ]);
        Product::factory()->create([
            'stock' => 30,
            'available_stock' => 30,
        ]);
        Product::factory()->create([
            'stock' => 40,
            'available_stock' => 40,
        ]);
        Product::factory()->create([
            'stock' => 50,
            'available_stock' => 50,
        ]);
        Product::factory()->create([
            'stock' => 70,
            'available_stock' => 70,
        ]);
        Product::factory()->create([
            'stock' => 80,
            'available_stock' => 80,
        ]);
        Product::factory()->create([
            'stock' => 90,
            'available_stock' => 90,
        ]);

        $token = $this->createTestToken($this->operator, $this->store);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?stock_level=cazyasyas-stock');

        $response->assertStatus(422);
    }

    public function testCombinedFiltering()
    {
        Product::factory()->create([
            'name' => 'iPhone 15',
            'brand' => 'Apple',
            'type_id' => 1,
            'price' => 799,
            'stock' => 25,
        ]);

        Product::factory()->create([
            'name' => 'iPhone 14',
            'brand' => 'Apple',
            'type_id' => 1,
            'price' => 599,
            'stock' => 30,
        ]);

        Product::factory()->create([
            'name' => 'Galaxy S24',
            'brand' => 'Samsung',
            'type_id' => 3,
            'price' => 899,
            'stock' => 20,
        ]);

        Product::factory()->create([
            'name' => 'MacBook Air',
            'brand' => 'Apple',
            'type_id' => 3,
            'price' => 1199,
            'stock' => 10,
        ]);

        Product::factory()->create([
            'name' => 'Air Max 90',
            'brand' => 'Nike',
            'type_id' => 2,
            'price' => 150,
            'stock' => 50,
        ]);

        Product::factory()->create([
            'name' => 'iPhone Case',
            'brand' => 'Apple',
            'type_id' => 1,
            'price' => 30,
            'stock' => 100,
        ]);

        Product::factory()->create([
            'name' => 'iPhone 15 Pro',
            'brand' => 'Apple',
            'type_id' => 2,
            'price' => 999,
            'stock' => 0,
        ]);

        $token = $this->createTestToken($this->operator, $this->store);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?name=iPhone&brand=Apple&product_type=1&min_price=500&max_price=700');

        $response->assertSuccessful();
        $response->assertJsonCount(1, 'data');
    }
}
