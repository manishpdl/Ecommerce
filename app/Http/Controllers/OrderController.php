<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function store($cartid)
    {
        $cart = Cart::find($cartid);
        $data = [
            'user_id' => auth()->id(),
            'product_id' => $cart->product_id,
            'price' => $cart->product->discounted_price != '' ? $cart->product->discounted_price : $cart->product->price,
            'quantity' => $cart->quantity,
            'name' => $cart->user->name,
            'phone' => '9844210361',
            'address' => 'Chitwan',


        ];
        $order = Order::create($data);

        //send email to user
        $msg = [
            'name' => $order->user->name,
            'product_name' => $order->product->name,
            'price' => $order->price,
            'quantity' => $order->quantity,
            'address' => $order->address,
        ];

        Mail::send('emails.neworder', $msg, function ($message) use ($order) {
            $message->to($order->user->email)
                ->subject('Order Placed ');
        });
        $cart->delete();
        return redirect()->route('mycart')->with('success', 'order placed successfully');
    }
    public function store_esewa(Request $request, $cartid)
    {
        $data = $request->data;
        //decode data
        $data = base64_decode($data);
        $data = json_decode($data, true);
        if ($data['status'] == 'COMPLETE') {
            $cart = Cart::find($cartid);
            $orderdarta = [
                'user_id' => auth()->id(),
                'product_id' => $cart->product_id,
                'price' => $cart->product->discounted_price != '' ? $cart->product->discounted_price : $cart->product->price,
                'quantity' => $cart->quantity,
                'name' => $cart->user->name,
                'phone' => '9812345678',
                'address' => 'Chitwan',
                'payment_method' => 'esewa',
                'payment_status' => 'paid',
            ];

            $order = Order::create($orderdarta);
            //send email to user
            $msg = [
                'name' => $order->user->name,
                'product_name' => $order->product->name,
                'price' => $order->price,
                'quantity' => $order->quantity,
                'address' => $order->address,
            ];

            Mail::send('emails.neworder', $msg, function ($message) use ($order) {
                $message->to($order->user->email)
                    ->subject('Order Placed ');
            });
            $cart->delete();
            return redirect()->route('mycart')->with('success', 'order placed successfully');
        }
    }


    public function index()
    {
        $orders = Order::latest()->get();
        return view('orders.index', compact('orders'));
    }
    public function update_status($orderid, $status)
    {
        $order = Order::find($orderid);
        //update the stock
        if (($order->status == 'Pending' || $order->status == 'pending' ||  $order->status == 'Cancelled') && ($status == 'Processing' || $status == 'Delivered')) {
            $order->product->stock -= $order->quantity;
            $order->product->save();
        }
        if ($order->status == 'Processing' || $order->status == 'Delivered') {
            if ($status == 'Pending' || $status == 'Cancelled') {
                $order->product->stock += $order->quantity;
                $order->product->save();
            }
        }


        $order->status = $status;
        $order->payment_status = $status == 'Delivered' ? 'paid' : ($order->payment_method == 'esewa' ? 'Paid' : 'Unpaid');

        $order->save();
        //send email to user
        $msg = ['name' => $order->user->name, 'status' => $status];
        Mail::send('emails.orderstatus', $msg, function ($message) use ($order) {
            $message->to($order->user->email)
                ->subject('Order Status Updated');
        });
        return back()->with('success', 'Order status updated successfully.');
    }

    public function searchorder(Request $request)
    {
        $searchName = $request->input('name');
        $searchPhone = $request->input('phone');
        $searchStatus = $request->input('status');
        $query = Order::query();
        if ($searchName) {
            $query->where('name', 'like', '%' . $searchName . '%');
        }

        if ($searchPhone) {
            $query->where('phone', 'like', '%' . $searchPhone . '%');
        }
        if ($searchStatus) {
            $query->where('status', $searchStatus);
        }

        $orders = $query->latest()->get();
        return view('orders.index', compact('orders'));
    }
}
