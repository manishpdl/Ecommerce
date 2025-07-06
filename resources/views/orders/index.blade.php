@extends('layouts.app')
@section('title', 'Orders')
@section('content')

<form method="GET" action="{{ route('search.order') }}" class="mb-4 flex gap-4">
    <input type="text" name="name" placeholder="Search by Username" value="{{ request('name') }}" class="border p-2 rounded">
    <input type="text" name="phone" placeholder="Search by phone" value="{{ request('phone') }}" class="border p-2 rounded">
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
    <select name="status" class="border pl-2 pr-7 rounded">
        <option value="">All Status</option>
        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
        <option value="Processing" {{ request('status') == 'Processing' ? 'selected' : '' }}>Processing</option>
        <option value="Delivered" {{ request('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>
</form>

    <table class="w-full">
        <tr class="bg-gray-200">
            <th class="p-2 border border-gray-50">Order Date</th>
            <th class="p-2 border border-gray-50">Product Picture</th>
            <th class="p-2 border border-gray-50">Product Name</th>
            <th class="p-2 border border-gray-50">Customer Name</th>
            <th class="p-2 border border-gray-50">Customer Phone</th>
            <th class="p-2 border border-gray-50">Customer Address</th>
            <th class="p-2 border border-gray-50">Price</th>
            <th class="p-2 border border-gray-50">Quantity</th>
            <th class="p-2 border border-gray-50">Total Amount</th>
            <th class="p-2 border border-gray-50">Payment Method</th>
            <th class="p-2 border border-gray-50">Payment Status</th>
            <th class="p-2 border border-gray-50">Order Status</th>
            <th class="p-2 border border-gray-50">Action</th>
        </tr>
        @foreach($orders as $order)
        <tr class="text-center">
            <td class="p-2 border">{{ $order->created_at }}</td>
            <td class="p-2 border">
                <img src="{{ asset('images/products/' . $order->product->photopath) }}" class="w-16 mx-auto h-16 object-cover">
            </td>
            <td class="p-2 border">{{ $order->product->name }}</td>
            <td class="p-2 border">{{ $order->name }}</td>
            <td class="p-2 border">{{ $order->phone }}</td>
            <td class="p-2 border">{{ $order->address }}</td>
            <td class="p-2 border">{{ $order->price }}</td>
            <td class="p-2 border">{{ $order->quantity }}</td>
            <td class="p-2 border">{{ $order->price * $order->quantity }}</td>
            <td class="p-2 border">{{ $order->payment_method }}</td>
            <td class="p-2 border">{{ $order->payment_status }}</td>
            <td class="p-2 border">{{ $order->status }}</td>
            <td class="p-2 border flex flex-wrap gap-1 justify-center">
                <a href="{{route('orders.status',[$order->id,'Pending'])}}" class="px-1 bg-blue-500 text-white">Pe</a>
                <a href="{{route('orders.status',[$order->id,'Processing'])}}" class="px-1 bg-yellow-500 text-white">Pr</a>
                <a href="{{route('orders.status',[$order->id,'Delivered'])}}" class="px-1 bg-green-500 text-white">De</a>
                <a href="{{route('orders.status',[$order->id,'Cancelled'])}}" class="px-1 bg-red-500 text-white">Ca</a>
            </td>
        </tr>
        @endforeach
    </table>
@endsection