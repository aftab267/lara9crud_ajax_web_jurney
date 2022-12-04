<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function products()
    {
        $products=Product::latest()->paginate(5);
        return view('products',compact('products'));
    }
    //add product
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
     //update product
     public function updateproduct(Request $request){
        $request->validate(
            [
            'up_name'=> 'required|unique:products,name,'.$request->up_id,
            'up_price'=> 'required',
            ],
            [
                'up_name.required'=>'Name is Required',
                'up_price.unique'=>'Price Already Exist',
                'up_price.required'=>'Price Is Required',
            ]
    );

        Product::where('id',$request->up_id)->update([
            'name'=>$request->up_name,
            'price'=>$request->up_price,
        ]);
        return response()->json([
            'status'=> 'success',
        ]);
     }
     public function deleteproduct(Request $request){
        Product::find($request->product_id)->delete();
        return response()->json([
            'status'=> 'success',
        ]);
     }
}
