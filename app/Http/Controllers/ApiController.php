<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRequest;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * @var ProductService
     */
    public $productService;

    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        $this->productService = new ProductService();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = $this->productService->listProducts(10);

        if ($products->getStatusCode() != 200) return view('products.index', ['products' => []]);

        return view('products.index', ['products' => $products->getData()]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function detail($id)
    {
        $product = $this->productService->getProduct($id);

        if ($product->getStatusCode() != 200) return view('products.details', ['product' => null]);

        return view('products.details', ['product' => $product->getData()]);
    }

}
