<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelIgnition\Support\LaravelVersion;

class OrderController extends Controller
{
    // order list inclding orderCode
    public function list()
    {
        $order = Order::leftjoin('users', 'users.id', 'user_id')
            ->select('orders.*', 'users.name as username')
            ->orderby('created_at', 'desc')
            ->get();
        // dd($order->toArray());
        return view('admin.order.list', compact('order'));
    }

    // show order list (details)
    public function productList($orderCode)
    {
        $orderTotalPrice = Order::select('orders.total_price')
                        ->where('order_code', $orderCode)->first();

        $order = OrderList::leftjoin('users', 'users.id', 'order_lists.user_id')
                    ->leftjoin('products', 'products.id', 'order_lists.product_id')
                    ->select('order_lists.*', 'users.name as user_name',
                            'products.image as product_image', 'products.name as product_name')
                    ->where('order_code', $orderCode)->get();

        // dd($order->toArray());
        return view('admin.order.productList', compact('order', 'orderTotalPrice'));
    }

    // change order status
    public function orderStatus(Request $request)
    {

        // handling null state for order status
        // logger($request->orderStatus);

        if ($request->orderStatus == null) {
            $order = Order::leftjoin('users', 'users.id', 'user_id')
                ->select('orders.*', 'users.name as username')
                ->orderby('created_at', 'desc')
                ->get();

        }

        if ($request->orderStatus != null) {
            $order = Order::leftjoin('users', 'users.id', 'user_id')
                ->select('orders.*', 'users.name as username')
                ->where('orders.status', $request->orderStatus)
                ->orderby('created_at', 'desc')
                ->get();

        }

        return view('admin.order.list', compact('order'));
    }

    // change status for customer's order
    public function changeStatus(Request $request)
    {
        Order::where('id', $request->orderId)
            ->update([
                'status' => $request->orderStatus
            ]);
    }
}
