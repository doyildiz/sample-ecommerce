<?php


namespace App\Services;


use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CartService
{

    /**
     * @param $token
     * @return JsonResponse
     */
    public function getCart($token)
    {
        try {
            $cart_details = Cart::query()
                ->where('token', $token)
                ->with('details')
                ->with('details.product')
                ->with('details.option')
                ->first();

            return response()->json(
                new CartResource($cart_details), 200
            );

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json($exception->getMessage(), 500);
        }
    }

    /**
     * @param Cart $cart
     * @param array $product
     * @return JsonResponse
     */
    public function productTotalQuantity(Cart $cart, $product)
    {
        try {
            $details = CartDetail::where('cart_id', $cart->id)
                ->where('product_id', $product['product_id'])->get();
            $pro = Product::find($product['product_id']);

            if ((int)$product['quantity'] > $pro->stock)
                return response()->json(false, 200);

            if ($details->count() == 0) return response()->json($product['quantity'], 200);

            if ($details->sum('quantity') + (int)$product['quantity'] > 5) return response()->json(false, 200);

            return response()->json($details->sum('quantity') + $product['quantity'], 200);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json($exception->getMessage(), 500);
        }


    }

    /**
     * @param array $product
     * @return void
     */
    public function decreaseInventory($product)
    {
        Product::find($product['product_id'])->decrement('stock', (int)$product['quantity']);
    }

    /**
     * @param Cart $cart
     * return float
     * @return void
     */
    public function calculateTotal(Cart $cart)
    {
        try {
            $total = 0;
            foreach ($cart->details as $detail) {
                $total += $detail->quantity * $detail->product->price;
            }

            $cart->total_price = $total;
            $cart->discounted_price = $total;
            $cart->save();

            return response()->json('Success', 200);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json($exception->getMessage(), 500);
        }
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function clearCart($data)
    {
        try {
            $cart = Cart::where('token', $data['token'])->first();
            if ($this->reAddInventories($cart)->getStatusCode() == 200) {
                $cart->details()->delete();
                $cart->total_price = 0;
                $cart->discounted_price = 0;
                $cart();
            }

            return response()->json('Success', 200);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json($exception->getMessage(), 500);
        }
    }

    /**
     * Adds inventories back after clearing the cart
     * @param Cart $cart
     * @return \Illuminate\Contracts\Routing\ResponseFactory|JsonResponse|\Illuminate\Http\Response
     */
    public function reAddInventories(Cart $cart)
    {
        try {
            if ($cart->details->count() > 0) {
                foreach ($cart->details as $detail) {
                    Product::find($detail->product_id)->increment('stock', (int)$detail->quantity);
                }
            }

            return response(true, 200);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json($exception->getMessage(), 500);
        }
    }
}
