<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
  public  function myorders()
    {
        $orders=Order::where('user_id', auth()->id())->with('product')->get();
        return response()->json(['message' => 'Order retrived Successfully', 'success' => true,'data'=>$orders,]);
        
    }
}
