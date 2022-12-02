<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function products()
    {
        return view('products');
    }
    public function addproduct(Request $request){
        $request->validate(
            [
            'name'=> 'required|unique:products',
            'price'=> 'required',
            ],
            [
                'name.required'=>'Name is Required',
                'price.unique'=>'Name Already Exist',
                'price.required'=>'Price Is Required',
            ]
    );
        $product=new Product();
        $product->name=$request->name;
        $product->price=$request->price;
        $product->save();
        return response()->json([
            'status'=> 'success',
        ]);
    }
}
