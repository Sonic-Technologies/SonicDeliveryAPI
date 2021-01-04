<?php

namespace App\Http\Controllers;
     
use App\Http\Resources\CartResourceCollection;
use App\Http\Resources\CartResource;
use Illuminate\Http\Request;
use App\Customer;
use App\Product;
use App\Cart;


class CartController extends Controller
{
    public function index(): CartResourceCollection
    {
        return new CartResourceCollection(Cart::all());
    }

    public function show($id): CartResource
    {
        $cart = Cart::find($id);

        return new CartResource($cart);
    }

    public function store(Request $request)
    {
        $request->validate([
            'quantity' => 'required'
        ]);

        $item = Product::find($id);
        $cust = Customer::first();
        
        $cart = new Cart();
        $cart->customer_id      = $cust->id;
        $cart->item_code        = $item->item_code;
        $cart->item_name        = $item->item_name;
        $cart->quantity         = $request->quantity;
        $cart->price            = number_format($item->price * $request->quantity);
        $cart->save();

        return new CartResource($cart);
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::find($id);

        $cart->quantity = $request->quantity;
        $cart->save();

        return new CartResource($cart);
    }

    public function destroy($id)
    {
        $cart = Cart::find($id);

        $cart->delete();

        return "Item removed from cart";
    }

    public function delete($id)
    {
        $cust = Customer::find($id);

        $cart = Cart::where('customer_id', $cust->id)->delete();
    }
}
