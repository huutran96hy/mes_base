<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $attribute = ProductAttribute::factory()->create(['id' => 'color', 'name' => 'Color', 'type' => 'string']);
        ProductAttributeValue::factory()->create(['product_id' => $product->id, 'product_attribute_id' => 'color', 'value' => 'red']);

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         '*' => ['id', 'product_name', 'description', 'category_id', 'attributes', 'created_at', 'updated_at']
                     ],
                     'message'
                 ]);
    }

    public function testStore()
    {
        $category = Category::factory()->create();
        $attributeColor = ProductAttribute::factory()->create(['id' => 'color', 'name' => 'Color', 'type' => 'string']);
        $attributeSize = ProductAttribute::factory()->create(['id' => 'size', 'name' => 'Size', 'type' => 'string']);

        $productData = [
            'product_name' => 'New Product',
            'description' => 'New Description',
            'category_id' => $category->id,
            'attributes' => [
                ['attribute_id' => 'color', 'value' => 'red'],
                ['attribute_id' => 'size', 'value' => 'M']
            ]
        ];

        $response = $this->postJson('/api/products', $productData);

        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Product created successfully'
                 ]);

        $this->assertDatabaseHas('products', ['product_name' => 'New Product']);
        $this->assertDatabaseHas('product_attribute_values', ['value' => 'red']);
        $this->assertDatabaseHas('product_attribute_values', ['value' => 'M']);
    }

    public function testUpdate()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $attributeColor = ProductAttribute::factory()->create(['id' => 'color', 'name' => 'Color', 'type' => 'string']);
        $attributeSize = ProductAttribute::factory()->create(['id' => 'size', 'name' => 'Size', 'type' => 'string']);

        ProductAttributeValue::factory()->create(['product_id' => $product->id, 'product_attribute_id' => 'color', 'value' => 'red']);
        ProductAttributeValue::factory()->create(['product_id' => $product->id, 'product_attribute_id' => 'size', 'value' => 'M']);

        $updateData = [
            'product_name' => 'Updated Product',
            'description' => 'Updated Description',
            'category_id' => $category->id,
            'attributes' => [
                ['attribute_id' => 'color', 'value' => 'blue'],
                ['attribute_id' => 'size', 'value' => 'L']
            ]
        ];

        $response = $this->putJson("/api/products/$product->id", $updateData);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Product updated successfully'
                 ]);

        $this->assertDatabaseHas('products', ['id' => $product->id, 'product_name' => 'Updated Product']);
        $this->assertDatabaseHas('product_attribute_values', ['product_id' => $product->id, 'value' => 'blue']);
        $this->assertDatabaseHas('product_attribute_values', ['product_id' => $product->id, 'value' => 'L']);
    }

    public function testDestroy()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $attributeColor = ProductAttribute::factory()->create(['id' => 'color', 'name' => 'Color', 'type' => 'string']);
        $attributeSize = ProductAttribute::factory()->create(['id' => 'size', 'name' => 'Size', 'type' => 'string']);

        ProductAttributeValue::factory()->create(['product_id' => $product->id, 'product_attribute_id' => 'color', 'value' => 'red']);
        ProductAttributeValue::factory()->create(['product_id' => $product->id, 'product_attribute_id' => 'size', 'value' => 'M']);

        $response = $this->deleteJson("/api/products/$product->id");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Product deleted successfully'
                 ]);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
        $this->assertDatabaseMissing('product_attribute_values', ['product_id' => $product->id]);
    }
}
