<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * @var CartService
     */
    public $cartService;

    /**
     * CartController constructor.
     */
    public function __construct()
    {
        $this->cartService = new CartService();
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $token = $_COOKIE['cartID'];

        if ($token !== null) {
            $cart = $this->cartService->getCart($token);

            if ($cart->getStatusCode() != 200) return view('cart.index', ['products' => []]);

            return view('cart.index', ['cart' => $cart->getData()]);
        }
    }

    /**
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function addToCart(CreateRequest $request)
    {
        $cart = Cart::updateOrCreate(['token' => $request->get('cart')['token']],
            $request->get('cart'));

        if ($cart) {
            $products = $request->get('product');
            $input = ['cart_id' => $cart->id] + $products;
            $total = $this->cartService->productTotalQuantity($cart, $products)->getData();

            if (!$total) return response()->json(['message' => 'Not enough items'], 200);

            $input['quantity'] = $total;
            $input = ['total_price' => $products['unit_price'] * $total] + $input;

            $detail = CartDetail::updateOrCreate(
                [
                    'cart_id' => $cart->id,
                    'product_id' => (int)$products['product_id'],
                ],
                $input);

            if ($detail) $this->cartService->decreaseInventory($products);

            $this->cartService->calculateTotal($cart);

            return response()->json(true, 201);
        }

        return response()->json(['message' => 'An error occurred'], 200);
    }

    /**
     * @param UpdateRequest $request
     * @return JsonResponse
     */
    public function clear(UpdateRequest $request)
    {
        $deleted = $this->cartService->clearCart($request->validated());

        return response()->json(['status' => $deleted->getStatusCode()], $deleted->getStatusCode());
    }

}
