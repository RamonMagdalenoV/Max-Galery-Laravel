<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Http\Requests\BrandRequest;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        return Brand::all();
    }

    public function Store(BrandRequest $request)
    {
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->save();
    }

    public function Update(BrandRequest $request)
    {
        $brand = Brand::find($request->id);
        $brand->name = $request->name;
        $brand->save();
    }

    public function Delete($id)
    {
        $brand = Brand::find($id);
        $brand->delete();
    }
}
