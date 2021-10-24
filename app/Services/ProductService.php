<?php


namespace App\Services;


use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductService
{
    /**
     * @param $take
     * @return \Illuminate\Http\JsonResponse
     */
    public function listProducts($take)
    {
        try {
            $products = Product::query()
                ->take($take)
                ->get();

            return response()->json(
                ProductResource::collection($products), 200
            );

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return response()->json($exception->getMessage(), 500);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProduct($id)
    {
        try {
            $product = Product::find($id);

            if ($product == null) return response()->json('Product not found', 404);

            return response()->json(
                new ProductResource($product), 200
            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return response()->json($exception->getMessage(), 500);
        }
    }

}
