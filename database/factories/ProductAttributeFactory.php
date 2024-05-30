<?php
namespace Database\Factories;

use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductAttributeFactory extends Factory
{
    protected $model = ProductAttribute::class;

    public function definition()
    {
        return [
            'id' => $this->faker->uuid, // Hoặc một chuỗi tùy ý
            'name' => $this->faker->word,
            'type' => $this->faker->randomElement(['string', 'number', 'date']),
        ];
    }
}
