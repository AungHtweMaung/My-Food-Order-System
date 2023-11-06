<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Mockery\Generator\StringManipulation\Pass\Pass;

class ProductController extends Controller
{
    // product list
    public function list()
    {
        // product table ထဲက field အားလုံးကို ယူတယ်။ categories table ထဲက name ကိုပဲယူတယ်။
        // table တွေ join ထားလို့ field name တွေတူရင် ဘယ်ကောင်ကို ပြောမှန်းမသိဘူး overwrite လုပ်သွားတယ်
        // အဲ့တာကြောင့် ဘယ် table ထဲက ဘယ် field ပါဆိုပြီး သုံးပေးရတာ
        $products = Product::select('products.*', 'categories.name as category_name')
            ->when(request('searchKey'), function ($query) {
                $query->where('products.name', 'like', '%' . request('searchKey') . '%');
            })
            ->leftjoin('categories', 'products.category_id', 'categories.id')
            ->orderby('products.created_at', 'desc')
            ->paginate(3);

        // for pagination
        $products->appends(request()->query());
        // dd($products);
        return view('admin.products.productList', ['products' => $products]);
    }

    // direct product edit page
    public function editPage($id)
    {
        $categories = Category::get();
        // dd($categories->toArray());
        $product = Product::where('id', $id)->first();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // edit product
    public function update(Request $request, $id)
    {

        $this->productValidationCheck($request, 'update');
        $data = $this->getProductData($request);

        if ($request->hasFile('productImage')) {
            $dbImage = Product::where('id', $request->productId)->first();
            $dbImage = $dbImage->image;

            if ($dbImage != null) {
                // Storage dir means Storage/app
                Storage::delete('public/productImage/' . $dbImage);
            }

            $imageName = uniqid() . $request->productImage->getClientOriginalName();
            $request->productImage->storeAs('public/productImage/' . $imageName);
            $data['image'] = $imageName;
        }

        Product::where('id', $id)->update($data);
        return redirect()->route('product#list')->with(['updateMessage' => 'Product Updated Successfully!']);
    }


    // direct product detail page
    public function detail($id)
    {
        $product = Product::select('products.*', 'categories.name as category_name')
            ->leftjoin('categories', 'products.category_id', 'categories.id')
            ->where('products.id', $id)->first();
        return view('admin.products.detail', compact('product'));
    }


    // direct  product createPage
    public function createPage()
    {
        $categories = Category::select('id', 'name')->get();
        // dd($categories->toArray());
        return view('admin.products.create', compact('categories'));
    }

    // delete product
    public function delete($id)
    {
        Product::where('id', $id)->delete();
        return redirect()->route('product#list')->with(['deleteMessage' => 'Product Deleted Successfully!']);
    }


    //  create product
    public function create(Request $request)
    {
        $this->productValidationCheck($request, 'create');
        $data = $this->getProductData($request);

        if ($request->hasFile('productImage')) {
            $imageName = uniqid() . $request->productImage->getClientOriginalName();
            $request->productImage->storeAs('public/productImage/' . $imageName);
            $data['image'] = $imageName;
        }

        Product::create($data);
        return redirect()->route('product#list')->with(['createMessage' => 'Product Created Successfully!']);
        // return view('admin.products.create');
    }

    // validation for product
    private function productValidationCheck($request, $action)
    {
        // validationRule ထဲမှာ Image တွက် required စစ်တယ်ဆိုရင် product create အတွက် အဆင်ပြေတယ်
        // update အတွက် အဆင်မပြေဘူး။ update က ပုံအသစ်မထည့်ဘဲနဲ့လည်း အဆင်ပြေတယ်။
        // So, action para တစ်ခုထည့်ပြီး  solve လုပ်လိုက်တာ
        $validationRules = [
            'productName' => 'required|unique:products,name,' . $request->productId,
            'productCategory' => 'required',
            'productDescription' => 'required|min:10',
            'productWaitingTime' => 'required',
            'productPrice' => 'required|numeric',
        ];

        // action သည် create ဆို required ပါမယ်။ create မဟုတ်ရင် required မထည့်ဘူး
        $validationRules['productImage'] = $action == 'create' ? 'required|file|mimes:png,jpg,jpeg' : 'file|mimes:png,jpg,jpeg';

        Validator::make($request->all(), $validationRules)->validate();
    }

    // change product data to array format
    private function getProductData($request)
    {
        return [
            'category_id' => $request->productCategory,
            'name' => $request->productName,
            'description' => $request->productDescription,
            'price' => $request->productPrice,
            'waiting_time' => $request->productWaitingTime,
        ];
    }
}
