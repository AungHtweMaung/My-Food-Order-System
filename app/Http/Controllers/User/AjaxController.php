<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    // product list sorting
    public function productList(Request $request)
    {
        // logger($request->all());
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

    // add to cart
    public function addToCart(Request $request)
    {
        // logger($request->all());
        $data = $this->getOrderData($request);


        Cart::create($data);
        return response()->json(['status' => 'success']);
    }

    // increase view count
    public function increaseViewCount(Request $request, $productId)
    {

        $product = Product::where('id', $productId)->first();
        $viewCount = $product->view_count + 1;

        Product::where('id', $productId)->update([
            'view_count' => $viewCount,
        ]);



    }


    // order
    public function order(Request $request)
    {
        // logger($request->all());
        $total = 0;
        // orderList table ထဲကို cartlist ထဲက record အားလုံးကို loop ပတ်ပြီး ထည့်တာ
        foreach ($request->all() as $item) {
            $data = OrderList::create([
                'user_id' => $item['userId'],
                'product_id' => $item['productId'],
                'qty' => $item['qty'],
                'total' => $item['total'],
                'order_code' => $item['orderCode']
            ]);
            $total += $data->total;
        };

        // for delivery fee
        $total = $total + 3000;

        // order code ကို click လိုက်မှ order list ကိုပြပေးမှာ
        DB::table('orders')->insert([
            'user_id' => Auth::user()->id,
            'order_code' => $data->order_code,
            'total_price' => $total,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        // after inserting into order list, cart should be cleared
        // DB::table('carts')->where('user_id', Auth::user()->id)->delete();
        Cart::where('user_id', Auth::user()->id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Order Completed'], 200);
    }

    public function updateProductQty(Request $request)
    {
        // table ထဲက column name ကို မှန်အောင်ပေး
        Cart::where('product_id', $request->productId)->update([
            'qty'=>$request->quantity
        ]);
    }


    // remove cart item
    public function removeCartItem(Request $request)
    {
        // product id နဲ့ပဲ စစ်ရင် product id တူတဲ့ item အားလုံး ပျက်သွားမှာ
        // cart id နဲ့ရော ယူမှ သူဖျက်တဲ့ တစ်ခုပဲ delete ဖြစ်သွားမှာ
        Cart::where('user_id', Auth::user()->id)
            ->where('product_id', $request->productId)
            ->where('id', $request->cartId) 
            ->delete();
    }

    // clear cart
    public function clearCart()
    {
        Cart::where("user_id", Auth::user()->id)->delete();
    }

    private function getOrderData($request)
    {
        return [
            'user_id' => $request->userId,
            'product_id' => $request->productId,
            'qty' => $request->qty,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
