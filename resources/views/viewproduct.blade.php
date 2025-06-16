@extends('layouts.master')

@section('content')
<div class="grid grid-cols-5 gap-6 px-20 py-10">
    {{-- Left: Product Image --}}
    <div class="col-span-2">
        <img src="{{ asset('images/products/' . $product->photopath) }}" alt="{{ $product->name }}" class="w-full h-96 object-cover rounded-md">
    </div>

    {{-- Middle: Product Info --}}
    <div class="col-span-2 border-x-2 px-6">
        <h2 class="text-2xl font-bold mb-4">{{ $product->name }}</h2>

           <h2 class="text-1xl font-bold mb-4">{{ $product->description }}</h2>
        {{-- Price --}}
        <div class="text-xl font-semibold text-blue-600 mb-2">
            @if(empty($product->discounted_price) || $product->discounted_price == 0)
                Rs. {{ $product->price }}
            @else
                <span class="line-through text-gray-500">Rs. {{ $product->price }}</span>
                <span class="ml-2 text-green-600">Rs. {{ $product->discounted_price }}</span>
            @endif
        </div>

        {{-- Stock --}}
        <p class="mb-4 text-gray-700">Stock: <span class="font-medium">{{ $product->stock }}</span> items</p>

        {{-- Add to Cart Form --}}
        @if($product->stock > 0)
        <form method="POST" action="">
            @csrf
            <label for="quantity" class="block mb-2 font-medium">Quantity:</label>
            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}"
                   class="w-24 border rounded px-2 py-1 mb-4">
            <br>
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                Add to Cart
            </button>
        </form>
        @else
        <p class="text-red-600 font-semibold">Out of stock</p>
        @endif
    </div>

    {{-- Right: Delivery & Warranty --}}
    <div class="col-span-1 text-sm text-gray-800 space-y-4">
        <div>
            <h3 class="font-semibold mb-1">Delivery Options</h3>
            <p>📍 <span class="font-medium">Bagmati, Kathmandu Metro 22 - Newroad Area, Newroad</span> <a href="#" class="text-blue-500">CHANGE</a></p>
            <p class="mt-2">🚚 <span class="font-medium">Standard Delivery</span></p>
            <p>Guaranteed by <span class="font-medium">19-23 Jun</span></p>
            <p>Delivery Fee: <span class="font-medium">Rs. 75</span></p>
            <p>💵 Cash on Delivery: <span class="text-green-600 font-medium">Available</span></p>
        </div>

        <div class="border-t pt-3">
            <h3 class="font-semibold mb-1">Return & Warranty</h3>
            <p>🔁 Change of Mind: <span class="font-medium">14 Days Free Returns</span></p>
            <p>🛡️ Warranty: <span class="text-red-600">Not Available</span></p>
        </div>
    </div>
</div>
@endsection
