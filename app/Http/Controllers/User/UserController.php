<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // direct user home page
    public function home()
    {
        $products = Product::orderby('created_at', 'asc')->get();
        $categories = Category::all();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        // dd($cart->toArray());
        return view('user.main.home', compact('products', 'categories', 'cart'));
    }

    // product is filtered by category
    public function filterByCategory($id)
    {
        $products = Product::where('category_id', $id)->orderby('created_at', 'asc')->get();
        $categories = Category::all();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        return view('user.main.home', compact('products', 'categories', 'cart'));
    }

    // product details
    public function productDetails($id)
    {
        $product = Product::where('id', $id)->firstOrFail();
        $productList = Product::all();
        // dd($product);
        return view('user.main.productDetails', compact('product', 'productList'));
    }

    // cart list
    public function cartList()
    {
        $cartList = Cart::leftjoin(
            'products',
            'carts.product_id',
            'products.id'
        )
            ->select(
                'carts.*',
                'products.name as product_name',
                'products.price as product_price',
                'products.image as product_image'
            )
            ->where('carts.user_id', Auth::user()->id)->get();

        // total price
        $totalPrice = 0;
        foreach ($cartList as $c) {
            $totalPrice += $c->product_price * $c->qty;
        }
        // logger($totalPrice);
        return view('user.main.cart', compact('cartList', 'totalPrice'));
    }

    // direct changePassword Page
    public function changePasswordPage()
    {
        return view('user.account.changePassword');
    }

    // change User's Password
    public function changePassword(Request $request)
    {
        $this->passwordValidationCheck($request);
        $currentUser = User::where('id', Auth::user()->id)->first();
        $dbPassword = $currentUser->password;

        if (Hash::check($request->oldPassword, $dbPassword)) {
            $data = [
                'password' => Hash::make($request->newPassword),
            ];
            User::where('id', Auth::user()->id)->update($data);
            return back()->with(['changeSuccess' => 'Password Changed Success...']);
        }
        return back()->with(["notMatch" => "Old Password is not correct"]);
    }

    // profile detail page
    public function profileDetail()
    {
        return view('user.account.profileDetail');
    }

    // profile edit page
    public function editPage($id)
    {
        return view('user.account.edit');
    }

    // profile update
    public function update(Request $request, $id)
    {
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);
        if ($request->hasFile('image')) {
            $dbImage = User::where('id', $id)->first();
            $dbImage = $dbImage->image;

            if ($dbImage != null) {
                Storage::delete('public/profileImage/' . $dbImage);
            }
            $imageName = uniqid() . $request->file('image')->getClientOriginalName();
            // dd($imageName);
            $request->file('image')->storeAs('public/profileImage', $imageName);
            $data['image'] = $imageName;
        }
        User::where('id', $id)->update($data);
        return redirect()->route('user#profileDetail')->with(['accountUpdateSuccess' => "Admin Account Updated Successfully"]);
    }

    // history
    public function history()
    {
        // show order history of the current user
        $order = Order::where('user_id', Auth::user()->id)->orderby('created_at', 'desc')->paginate(5);
        // dd($order->toArray());
        return view('user.main.history', compact('order'));
    }

    // get User profile data
    private function getUserData($request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
            'updated_at' => Carbon::now(),
        ];

        return $data;
    }

    // user data validation check
    private function accountValidationCheck($request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'image' => 'file|mimes:png,jpg,jpeg',
        ])->validate();
    }

    // password validation
    private function passwordValidationCheck($request)
    {
        Validator::make($request->all(), [
            'oldPassword' => 'required|min:6',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:newPassword',
        ])->validate();
    }
}
