<?php
namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function create(array $data)
    {
        $attributes = $data['attributes'] ?? [];
        unset($data['attributes']);

        $product = $this->model->create($data);

        foreach ($attributes as $attribute) {
            ProductAttributeValue::create([
                'product_id' => $product->id,
                'product_attribute_id' => $attribute['attribute_id'],
                'value' => $attribute['value'],
            ]);
        }

        return $product;
    }

    public function update($id, array $data)
    {
        $attributes = $data['attributes'] ?? [];
        unset($data['attributes']);

        $product = $this->model->find($id);
        if ($product) {
            $product->update($data);

            foreach ($attributes as $attribute) {
                $attributeValue = ProductAttributeValue::where('product_id', $product->id)
                    ->where('product_attribute_id', $attribute['attribute_id'])
                    ->first();

                if ($attributeValue) {
                    $attributeValue->update(['value' => $attribute['value']]);
                } else {
                    ProductAttributeValue::create([
                        'product_id' => $product->id,
                        'product_attribute_id' => $attribute['attribute_id'],
                        'value' => $attribute['value'],
                    ]);
                }
            }
        }

        return $product;
    }
}
