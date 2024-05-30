<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Traits\API;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use API;

    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $products = $this->productRepository->all();

        $responseData = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'product_name' => $product->product_name,
                'description' => $product->description,
                'category_id' => $product->category_id,
                'attributes' => $product->attributes->map(function ($attributeValue) {
                    return [
                        'attribute_id' => $attributeValue->product_attribute_id,
                        'name' => $attributeValue->attribute->name,
                        'value' => $attributeValue->value,
                    ];
                }),
                'created_at' => $product->created_at->format('d/m/Y'),
                'updated_at' => $product->updated_at->format('d/m/Y')
            ];
        });

        return $this->success($responseData);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|integer|exists:categories,id',
            'attributes.*.attribute_id' => 'required|string|exists:product_attributes,id',
            'attributes.*.value' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->failure($validator->errors(), 'Validation Error', 422);
        }

        $product = $this->productRepository->create($request->all());

        $responseData = [
            'id' => $product->id,
            'product_name' => $product->product_name,
            'description' => $product->description,
            'category_id' => $product->category_id,
            'attributes' => $product->attributes->map(function ($attributeValue) {
                return [
                    'attribute_id' => $attributeValue->product_attribute_id,
                    'name' => $attributeValue->attribute->name,
                    'value' => $attributeValue->value,
                ];
            }),
            'created_at' => $product->created_at->format('d/m/Y'),
            'updated_at' => $product->updated_at->format('d/m/Y')
        ];

        return $this->success($responseData, 'Product created successfully', 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|integer|exists:categories,id',
            'attributes.*.attribute_id' => 'required|string|exists:product_attributes,id',
            'attributes.*.value' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->failure($validator->errors(), 'Validation Error', 422);
        }

        $product = $this->productRepository->update($id, $request->all());

        if (!$product) {
            return $this->failure([], 'Product not found', 404);
        }

        $responseData = [
            'id' => $product->id,
            'product_name' => $product->product_name,
            'description' => $product->description,
            'category_id' => $product->category_id,
            'attributes' => $product->attributes->map(function ($attributeValue) {
                return [
                    'attribute_id' => $attributeValue->product_attribute_id,
                    'name' => $attributeValue->attribute->name,
                    'value' => $attributeValue->value,
                ];
            }),
            'created_at' => $product->created_at->format('d/m/Y'),
            'updated_at' => $product->updated_at->format('d/m/Y')
        ];

        return $this->success($responseData, 'Product updated successfully', 200);
    }

    public function destroy($id)
    {
        $deleted = $this->productRepository->delete($id);

        if (!$deleted) {
            return $this->failure([], 'Product not found', 404);
        }

        return $this->success([], 'Product deleted successfully', 200);
    }
}
