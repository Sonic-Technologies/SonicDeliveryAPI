<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResourceCollection;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use App\OrderDetail;
use App\Barangay;
use App\Customer;
use App\Order;
use App\Cart;

class OrderController extends Controller
{
    public function index(): OrderResourceCollection
    {
        return new OrderResourceCollection(Order::all());
    }

    public function show($id): OrderResource
    {
        $order = Order::find($id);

        return new OrderResource($order);
    }

    public function store(Request $request)
    {
        $request->validate([
            'barangay' => 'required'
        ]);

        $barangay       = Barangay::find($request->barangay);
        $cust           = Customer::first();
        $cart           = Cart::where('customer_id', $cust->id)->get();
        // $cart           = DB::table('carts')->where('customer_id', '=', $cust->id)->get();
        $grandTotal     = Cart::where('customer_id', $cust->id)->sum('price');

        if(!$cart)
        {
            abort(404);
        }

        $order = new Order();
        $order->customer_id     = $cust->id;
        $order->grand_total     = number_format($grandTotal + $barangay->delivery_charge);
        $order->delivery_fee    = $barangay->delivery_charge;
        $order->status          = "new";
        $order->order_number    = date("Ymd").$cust->id;
        $order->order_date      = date("Ymd");
        $order->save();
        $order_id = $order->id;

        foreach($cart as $item)
        {
           $orderDetail             = new OrderDetail();
           $orderDetail->order_id   = $order_id;
           $orderDetail->item_code  = $item->item_code;
           $orderDetail->item_name  = $item->item_name;
           $orderDetail->quantity   = $item->quantity;
           $orderDetail->price      = $item->price;
           $orderDetail->save();
        }

        return new OrderResource($order);
    }

    public function update($id)
    {
        $order = Order::find($id);

        $order->status = "confirmed";
        $order->save();

        return new OrderResource($order);
    }
}