<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Repositories\Eloquent\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $productRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productRepository = new ProductRepository(new Product);
    }

    public function testCreateProduct()
    {
        $category = Category::factory()->create();

        $productData = [
            'product_name' => 'Test Product',
            'description' => 'Test Description',
            'category_id' => $category->id,
            'attributes' => [
                ['attribute_id' => 'color', 'value' => 'red'],
                ['attribute_id' => 'size', 'value' => 'M']
            ]
        ];

        ProductAttribute::factory()->create(['id' => 'color', 'name' => 'Color', 'type' => 'string']);
        ProductAttribute::factory()->create(['id' => 'size', 'name' => 'Size', 'type' => 'string']);

        $product = $this->productRepository->create($productData);

        $this->assertDatabaseHas('products', ['id' => $product->id, 'product_name' => 'Test Product']);
        $this->assertDatabaseHas('product_attribute_values', ['product_id' => $product->id, 'product_attribute_id' => 'color', 'value' => 'red']);
        $this->assertDatabaseHas('product_attribute_values', ['product_id' => $product->id, 'product_attribute_id' => 'size', 'value' => 'M']);
    }

    public function testUpdateProduct()
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

        $updatedProduct = $this->productRepository->update($product->id, $updateData);

        $this->assertDatabaseHas('products', ['id' => $product->id, 'product_name' => 'Updated Product']);
        $this->assertDatabaseHas('product_attribute_values', ['product_id' => $product->id, 'product_attribute_id' => 'color', 'value' => 'blue']);
        $this->assertDatabaseHas('product_attribute_values', ['product_id' => $product->id, 'product_attribute_id' => 'size', 'value' => 'L']);
    }

    public function testDeleteProduct()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $attributeColor = ProductAttribute::factory()->create(['id' => 'color', 'name' => 'Color', 'type' => 'string']);
        $attributeSize = ProductAttribute::factory()->create(['id' => 'size', 'name' => 'Size', 'type' => 'string']);

        ProductAttributeValue::factory()->create(['product_id' => $product->id, 'product_attribute_id' => 'color', 'value' => 'red']);
        ProductAttributeValue::factory()->create(['product_id' => $product->id, 'product_attribute_id' => 'size', 'value' => 'M']);

        $this->productRepository->delete($product->id);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
        $this->assertDatabaseMissing('product_attribute_values', ['product_id' => $product->id]);
    }
}
