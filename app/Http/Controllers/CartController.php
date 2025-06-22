<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request){
    $data=$request->validate(
        [
            'quantity'=>'required',
            'product_id'=>'required'
        ]);
    $data['user_id']=auth()->id();
    Cart::create($data);
 return back()->with('success','Successfully added to the cart');
    }
}
