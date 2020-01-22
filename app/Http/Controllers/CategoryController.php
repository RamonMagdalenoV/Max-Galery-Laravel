<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return $categories;
    }

    public function StoreCategory(CategoryRequest $request)
    {
        $category = new Category();
        $category->category_name = $request->category_name;
        $category->save();
    }

    public function UpdateCategory(CategoryRequest $request)
    {
        $category = Category::find($request->id);
        $category->category_name = $request->category_name;
        $category->save();
    }


    public function DeleteCategory($id)
    {
        $category = Category::find($id);
        $category->delete();
    }




}
