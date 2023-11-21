<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // direct category list
    public function list()
    {
        $categories = Category::when(request('searchKey'), function ($query) {
            $query->where('name', 'like', '%' . request('searchKey') . '%');
        })
            ->orderBy('created_at', 'desc')->paginate(3);
        // dd($categories->toArray());
        return view('admin.category.list', compact('categories'));
    }

    // delete category
    public function delete($id)
    {
        // dd($id);
        Category::where('id', $id)->delete();
        return back()->with(['deleteMessage' => 'Category deleted!']);
    }

    // direct category createPage
    public function createPage()
    {
        return view("admin.category.create");
    }

    // create category
    public function create(Request $request)
    {
        // dd($request->all());
        $this->categoryValidationCheck($request);
        $data = $this->requestCategoryData($request);
        Category::create($data);
        return redirect()->route('category#list')->with(['createMessage' => 'Category Created!']);
    }

    // direct category editPage
    public function editPage($id)
    {
        $category = Category::where("id", $id)->firstOrFail();
        return view("admin.category.edit", ['category'=>$category]);
    }

    public function update(Request $request, $id)
    {

        $this->categoryValidationCheck($request);
        $data = $this->requestCategoryData($request);
        Category::where("id", $id)->update($data);
        return redirect()->route('category#list')->with(['updateMessage' => 'Category Updated!']);
    }

    // category validation check
    private function categoryValidationCheck($request)
    {
        Validator::make($request->all(), [
            "categoryName" => "required|unique:categories,name," . $request->categoryId
        ])->validate();
    }

    // change category request data into array format
    private function requestCategoryData($request)
    {
        $data = [
            "name" => $request->categoryName,
        ];
        return $data;
    }
}
