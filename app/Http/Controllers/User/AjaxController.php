<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    // product list sorting
    public function productList(Request $request)
    {
        logger($request->all());
        if ($request->status == 'asc') {
            $products = Product::orderby('created_at', 'asc')->get();
        } elseif ($request->status == 'desc') {
            $products = Product::orderby('created_at', 'desc')->get();
        }
        return [
            'products' => $products,
            'status' => $request->status,
        ];
    }

    public function addToCart(Request $request)
    {
        $data = $this->getOrderData($request);

        Cart::create($data);
        $response = [
            'message' => 'Add To Cart Complete',
            'status' => 'success',
        ];
        return response()->json($response);

    }

    private function getOrderData($request)
    {
        return [
            'user_id'=>$request->userId,
            'product_id'=>$request->productId,
            'qty'=>$request->count,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ];
    }
}
