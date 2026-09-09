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

class ApiTokenSortingTest extends TestCase
{
    use RefreshDatabase;

    protected User $operator;
    protected Store $store;
    protected array $products;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->seedTestdatabase();

        $this->operator = $this->createTestOperator();
        $this->store = $this->createTestStore($this->operator);
        $this->products = $this->createTestProducts();
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

    protected function createTestProducts()
    {
        $products = [];

        $p1 = Product::factory()->create([
            'name' => 'Zebra Phone',
            'brand' => 'Samsung',
            'type_id' => 1,
            'price' => 900,
            'stock' => 10,
            'available_stock' => 10,
        ]);

        $products[] = $p1;

        $p2 = Product::factory()->create([
            'name' => 'Apple Watch',
            'brand' => 'Apple',
            'type_id' => 3,
            'price' => 300,
            'stock' => 50,
            'available_stock' => 50,
        ]);

        $products[] = $p2;

        $p3 = Product::factory()->create([
            'name' => 'Galaxy Phone',
            'brand' => 'Samsung',
            'type_id' => 2,
            'price' => 700,
            'stock' => 25,
            'available_stock' => 25,
        ]);

        $products[] = $p3;

        $p4 = Product::factory()->create([
            'name' => 'MacBook',
            'brand' => 'Apple',
            'type_id' => 4,
            'price' => 1200,
            'stock' => 5,
            'available_stock' => 5,
        ]);

        $products[] = $p4;

        $p5 = Product::factory()->create([
            'name' => 'AirPods',
            'brand' => 'Apple',
            'type_id' => 3,
            'price' => 200,
            'stock' => 100,
            'available_stock' => 100,
        ]);

        $products[] = $p5;

        return $products;
    }


    public function testNameAscendingSort()
    {
        $token = $this->createTestToken($this->operator, $this->store);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?sort_type=name-asc');

        $response->assertSuccessful();
        $response->assertJsonPath('data.0.name', 'AirPods');
        $response->assertJsonPath('data.1.name', 'Apple Watch');
        $response->assertJsonPath('data.2.name', 'Galaxy Phone');
        $response->assertJsonPath('data.3.name', 'MacBook');
        $response->assertJsonPath('data.4.name', 'Zebra Phone');
    }

    public function testNameDescendingSort()
    {
        $token = $this->createTestToken($this->operator, $this->store);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?sort_type=name-desc');

        $response->assertSuccessful();
        $response->assertJsonPath('data.0.name', 'Zebra Phone');
        $response->assertJsonPath('data.1.name', 'MacBook');
        $response->assertJsonPath('data.2.name', 'Galaxy Phone');
        $response->assertJsonPath('data.3.name', 'Apple Watch');
        $response->assertJsonPath('data.4.name', 'AirPods');
    }

    public function testPriceAscendingSort()
    {
        $token = $this->createTestToken($this->operator, $this->store);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?sort_type=price-asc');

        $response->assertSuccessful();
        $response->assertJsonPath('data.0.name', 'AirPods');
        $response->assertJsonPath('data.1.name', 'Apple Watch');
        $response->assertJsonPath('data.2.name', 'Galaxy Phone');
        $response->assertJsonPath('data.3.name', 'Zebra Phone');
        $response->assertJsonPath('data.4.name', 'MacBook');
    }

    public function testPriceDescendingSort()
    {
        $token = $this->createTestToken($this->operator, $this->store);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?sort_type=price-desc');

        $response->assertSuccessful();

        $response->assertJsonPath('data.0.name', 'MacBook');
        $response->assertJsonPath('data.1.name', 'Zebra Phone');
        $response->assertJsonPath('data.2.name', 'Galaxy Phone');
        $response->assertJsonPath('data.3.name', 'Apple Watch');
        $response->assertJsonPath('data.4.name', 'AirPods');
    }

    public function testStockeAscendingSort()
    {
        $token = $this->createTestToken($this->operator, $this->store);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?sort_type=stock-asc');

        $response->assertSuccessful();

        $response->assertJsonPath('data.0.name', 'MacBook');
        $response->assertJsonPath('data.1.name', 'Zebra Phone');
        $response->assertJsonPath('data.2.name', 'Galaxy Phone');
        $response->assertJsonPath('data.3.name', 'Apple Watch');
        $response->assertJsonPath('data.4.name', 'AirPods');
    }

    public function testStockeDescendingSort()
    {
        $token = $this->createTestToken($this->operator, $this->store);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?sort_type=stock-desc');

        $response->assertSuccessful();

        $response->assertJsonPath('data.0.name', 'AirPods');
        $response->assertJsonPath('data.1.name', 'Apple Watch');
        $response->assertJsonPath('data.2.name', 'Galaxy Phone');
        $response->assertJsonPath('data.3.name', 'Zebra Phone');
        $response->assertJsonPath('data.4.name', 'MacBook');
    }

    public function testDateAscendingSort()
    {
        $token = $this->createTestToken($this->operator, $this->store);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?sort_type=date-asc');

        $response->assertSuccessful();

        $response->assertJsonPath('data.0.name', 'Zebra Phone');
        $response->assertJsonPath('data.1.name', 'Apple Watch');
        $response->assertJsonPath('data.2.name', 'Galaxy Phone');
        $response->assertJsonPath('data.3.name', 'MacBook');
        $response->assertJsonPath('data.4.name', 'AirPods');
    }

    public function testDateDescendingSort()
    {
        $token = $this->createTestToken($this->operator, $this->store);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?sort_type=date-desc');

        $response->assertSuccessful();

        $response->assertJsonPath('data.0.name', 'AirPods');
        $response->assertJsonPath('data.1.name', 'MacBook');
        $response->assertJsonPath('data.2.name', 'Galaxy Phone');
        $response->assertJsonPath('data.3.name', 'Apple Watch');
        $response->assertJsonPath('data.4.name', 'Zebra Phone');
    }

    public function testinvalidSort()
    {
        $token = $this->createTestToken($this->operator, $this->store);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?sort_type=nowqof');

        $response->assertStatus(422);
    }
}
