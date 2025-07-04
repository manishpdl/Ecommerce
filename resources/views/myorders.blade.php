@extends('layouts.master')
@section('title','my orders')

@section('content')
<div class="px-20 py-10">
    <h2 class="font-bold text-3xl border-l-4 border-blue-500 pl-2">My Orders</h2>
    <div class="grid grid-cols-1 gap-5">
        @foreach ($orders as $order)
        <div class="shadow-lg p-4 flex justify-between items-center border rounded-lg">
            <div class="flex gap-4">
                <img src="{{ asset('images/products/'.$order->product->photopath) }}" alt="" class="h-32 w-32 object-cover">
                <div>
                    <h1 class="font-bold text-xl">{{ $order->product->name }}</h1>
                    <p class="text-gray-500">
                        @if($order->product->discounted_price)
                        <span class="text-red-600 font-bold text-lg">
                            Rs. {{ $order->product->discounted_price }}
                        </span>
                        <span class="text-gray-500 line-through">
                            Rs. {{ $order->product->price }}
                        </span>
                        @else
                        <span class="text-red-600 font-bold text-lg">
                            Rs. {{ $order->product->price }}
                        </span>
                        @endif
                    </p>
                    <p class="text-gray-500">Quantity: {{ $order->quantity }}</p>
                    <p class="text-gray-500">Total: Rs. {{ $order->price * $order->quantity }}</p>
                    <p class="text-gray-500">Payment Method: {{ $order->payment_method }}</p>
                    <p class="text-gray-500">Payment Status: {{ $order->payment_status }}</p>
                    <p class="text-gray-500">Order Status: {{ $order->status }}</p>

                </div>
            </div>
            <div class="grid gap-4">
                @if($order->status == 'Pending' || $order->status == 'pending')
                <form action="{{ route('order.cancel') }}" method="post">
                    @csrf
                    <input type="hidden" name="orderid" value="{{ $order->id }}">
                    <button type="submit" class="bg-blue-600 block text-center text-white px-4 py-2 rounded-lg">Cancel Order</button>
                </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endsection