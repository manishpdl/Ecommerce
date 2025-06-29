<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store($cartid){
        $cart=Cart::find($cartid);
        $data=[
            'user_id'=>auth()->id(),
            'product_id'=>$cart->product_id,
            'price'=>$cart->product->discounted_price !=''? $cart->product->discounted_price:$cart->product->price,
            'quantity'=>$cart->quantity,
            'name'=>$cart->user->name,
            'phone'=>'988484',
            'address'=>'Chitwan',


        ];
        Order::create($data);
        $cart->delete();
        return redirect()->route('mycart')->with('success','order placed successfully');
    }

}
