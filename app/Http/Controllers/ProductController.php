<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResourceCollection;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function index(): ProductResourceCollection
    {
        return new ProductResourceCollection(Product::all());
    }

    public function show($id): ProductResource
    {
        $prod = Product::find($id);

        return new ProductResource($prod);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_code'    => 'required',
            'item_name'    => 'required',
            'inventory'    => 'required',
            'price'        => 'required',
            'brand'        => 'required',
            'category'     => 'required',
            'photo'        => 'nullable',
            'status'       => 'required'
        ]);

        $prod = Product::create($request->all());

        return new ProductResource($prod);
    }

    public function update(Request $request, $id)
    {
        $prod = Product::find($id);
 
        $prod->item_code    = $request->item_code;
        $prod->item_name    = $request->item_name;
        $prod->inventory    = $request->inventory;
        $prod->price        = $request->price;
        $prod->brand        = $request->brand;
        $prod->category     = $request->category;
        $prod->photo        = $request->photo;
        $prod->status       = $request->status;
        $prod->save();

        return new ProductResource($prod);
    }

    public function destroy($id)
    {
        $prod = Product::find($id);

        $prod->delete();

        return "Product deleted";
    }
    
    public function delete()
    {
        Product::truncate();

        return "All products deleted";
    }
}
