<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;

class RouteController extends Controller
{
    // get product list
    public function productList()
    {
        $products = Product::get();

        return response()->json($products, 200);
    }

    // category list
    public function categoryList()
    {
        $category = Category::get();
        return response()->json($category, 200);
    }

    // create category
    public function createCategory(Request $request)
    {

        $validation = $this->categoryValidationCheck($request);
        if ($validation->passes()) {
            $data = [
                'name' => $request->category_name,

            ];

            $response = Category::create($data);

            return response()->json($response, 200);
        } else {
            return response()->json(['errors'=>$validation->errors()]);
        }
    }


    // create contact
    public function createContact(Request $request)
    {
        // dd($request->all());
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ];

        Contact::create($data);
        $contacts = Contact::orderby('created_at', 'desc')->get();

        return response()->json($contacts, 200);
    }

    // delete category
    public function deleteCategory($id)
    {
        $data = Category::where('id', $id)->first();

        if (isset($data)) {
            Category::where('id', $id)->delete();
            return response()->json(['status' => true, 'message' => 'delete successful'], 200);
        }

        return response()->json(['status' => false, 'message' => 'There is no category']);




        // post method
        // $data = Category::where('id', $request->id)->first();

        // if (isset($data)) {
        //     Category::where('id', $request->id)->delete();
        //     return response()->json(['message'=>'delete success'], 200);
        // }
        // return response()->json(['status'=>false,'message' => 'There is no category']);

    }

    // POST method category details
    public function categoryDetails(Request $request)
    {

        $data = Category::where('id', $request->category_id)->first();
        if (isset($data)) {
            return response()->json($data, 200);
        }

        return response()->json(['status' => false, 'message' => 'There is no category']);

    }

    // GET method category details
    // public function categoryDetails ($id)
    // {
    //     $data = Category::where('id', $id)->first();
    //     return $data;
    // }


    // update category
    public function updateCategory (Request $request)
    {

        $category = Category::where('id', $request->category_id)->first();
        if (isset($category)) {


        // validation စစ်တယ် ၊ pass ဖြစ်ရင် update လုပ်မယ်
        // fail ဖြစ်ရင် သက်ဆိုင်ရာ error တွေပြပေးမယ်
        $validation = $this->categoryValidationCheck($request);

        if ($validation->passes()) {
            $data = $this->getCategoryData($request);
            $updateData = Category::where('id', $request->category_id)->update($data);
            return response()->json(['status' => true, 'updated_data' => $updateData], 200);
        } else {
            return response()->json(['errors' => $validation->errors()], 422);
        }
    }



        // my original code

        // $category = Category::where('id', $request->category_id)->first();
        // if (isset($category)) {
        //     $validation = $this->categoryValidationCheck($request);

        //     if ($validation->passes()) {
        //         $data = $this->getCategoryData($request);
        //         $updateData = Category::where('id', $request->category_id)->update($data);
        //         return response()->json(['status' => true, 'updated_data' => $updateData], 200);
        //     } else {
        //         return response()->json(['errors' => $validation->errors()], 422);
        //     }

        // }

        // return response()->json(['status'=>false, 'message'=>'There is no category']);
    }

    // get category data
    private function getCategoryData($request)
    {
        return [
            'name' => $request->category_name,
            'updated_at' => Carbon::now(),
        ];
    }

    // category validation
    private function categoryValidationCheck($request)
    {
        // return validator instance
        return Validator::make($request->all(), [
            "category_name" => "required|unique:categories,name," . $request->category_id
        ]);



    }

}
