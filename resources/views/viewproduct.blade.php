@extends('layouts.master')

@section('content')

{{-- Product Section --}}
<div class="grid grid-cols-5 gap-8 px-20 py-10">

    {{-- Left: Product Image --}}
    <div class="col-span-2">
        <img src="{{ asset('images/products/' . $product->photopath) }}" alt="{{ $product->name }}"
             class="w-full h-96 object-cover ">
    </div>

    {{-- Middle: Product Info --}}
    <div class="col-span-2 border-x px-8">
        <h2 class="text-3xl font-bold mb-2">{{ $product->name }}</h2>
        <h3 class="text-lg font-semibold text-gray-600 mb-4">Product Description</h3>
        <p class="text-gray-700 mb-6">{{ $product->description }}</p>

        {{-- Price --}}
        <div class="text-2xl font-semibold text-blue-600 mb-4">
            @if(empty($product->discounted_price) || $product->discounted_price == 0)
                Rs. {{ $product->price }}
            @else
                <span class="line-through text-gray-500">Rs. {{ $product->price }}</span>
                <span class="ml-2 text-green-600">Rs. {{ $product->discounted_price }}</span>
            @endif
        </div>

        {{-- Stock --}}
        <p class="mb-4 text-gray-800 font-medium">Stock: {{ $product->stock }} items</p>

        {{-- Add to Cart --}}
        @if($product->stock > 0)
        <form action="{{ route('cart.store') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <label for="quantity" class="block mb-2 font-semibold">Quantity:</label>
            <div class="flex items-center space-x-2 mb-4">
                <button type="button" id="decrement" class="bg-gray-300 px-3 py-1 rounded">-</button>
                <input type="number" name="quantity" id="quantity" value="1" min="1" class="border w-12 text-center p-1 rounded" readonly>
                <button type="button" id="increment" class="bg-gray-300 px-3 py-1 rounded">+</button>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md">
                Add to Cart
            </button>
        </form>
        @else
        <p class="text-red-600 font-semibold">Out of stock</p>
        @endif
    </div>

    {{-- Right: Delivery & Warranty --}}
    <div class="col-span-1 text-sm space-y-6">
        <div class="p-4 border rounded-lg shadow">
            <h4 class="font-semibold mb-2">🚚 Delivery Options</h4>
            <p>📍 <span class="font-medium">Bagmati, Kathmandu Metro 22 - Newroad Area</span></p>
            <p class="mt-2">Standard Delivery (Rs. 75)</p>
            <p>Guaranteed by <span class="font-medium">19-23 Jun</span></p>
            <p class="mt-2 text-green-600 font-semibold">💵 Cash on Delivery Available</p>
        </div>

        <div class="p-4 border rounded-lg shadow">
            <h4 class="font-semibold mb-2">🔁 Return & Warranty</h4>
            <p>Change of Mind: <span class="font-medium">14 Days Free Returns</span></p>
            <p>🛡️ Warranty: <span class="text-red-600">Not Available</span></p>
        </div>
    </div>
</div>

{{-- Ratings & Reviews --}}
<div class="px-20 py-10">
    <h3 class="text-2xl font-bold mb-6 border-l-4 border-blue-500 pl-3">Ratings & Reviews of {{ $product->name }}</h3>

    @if($reviews->count() > 0)
        @foreach($reviews as $review)
            <div class="mb-6 p-4 border rounded-lg shadow-sm bg-white">
                <p class="font-semibold mb-1 text-lg">{{ $review->user->name }} 
                    <span class="text-yellow-500">⭐ {{ $review->rating }}</span>
                </p>
                <p class="text-gray-700">{{ $review->comment }}</p>
            </div>
            <div>
                @if($review->imagephoto)
                    <img src="{{ asset('images/reviews/' . $review->imagephoto) }}" alt="Review Image" class="w-24 h-24 object-cover rounded mt-2">
                @endif
                <p class="text-gray-500 text-sm mt-1">Reviewed on: {{ $review->created_at->format('d M Y') }}</p>
            </div>
        @endforeach
    @else
        <p class="text-gray-500 italic">No reviews yet.</p>
    @endif
    {{-- User is logged in or is a customer --}}

    {{-- User can submit a review --}}
    @php
    $hasOrdered = auth()->check() && \App\Models\Order::where('user_id', auth()->id())
        ->where('product_id', $product->id)
        ->where('status', 'Delivered') // or 'Completed'
        ->exists();
        @endphp
         @if($hasOrdered)
    {{-- Submit Review Form --}}
    <div class="mt-10 border rounded-lg p-6 shadow-lg bg-gray-50">
        <h4 class="text-xl font-semibold mb-4">Submit Your Review</h4>
        <form method="post" action="{{ route('product.review') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            {{-- Rating and Comment --}}
            <div class="mb-4">
                <label for="rating" class="block mb-1 font-medium">Rating:</label>
                <select name="rating" id="rating" class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="1">⭐ 1 Star</option>
                    <option value="2">⭐ 2 Stars</option>
                    <option value="3">⭐ 3 Stars</option>
                    <option value="4">⭐ 4 Stars</option>
                    <option value="5">⭐ 5 Stars</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="comment" class="block mb-1 font-medium">Comment:</label>
                <textarea name="comment"  class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div>
                <label for="imagephoto" class="block mb-1 font-medium">Upload Image (optional):</label>
                <input type="file" name="imagephoto" accept="image/*" class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold mt-2 py-2 px-6 rounded-lg">
                Submit Review
            </button>
        </form>
    </div>
   
@endif
</div>

{{-- Related Products --}}
<div class="px-20 py-10">
    <h2 class="text-2xl font-bold mb-5 border-l-4 border-blue-500 pl-3">Related Products</h2>
    <div class="grid grid-cols-4 gap-6">
        @foreach($relatedproducts as $product)
            <a href="{{ route('viewproduct', $product->id) }}" class="bg-white rounded-lg p-4 shadow hover:shadow-lg hover:-translate-y-1 transition duration-300">
                <img src="{{ asset('images/products/'.$product->photopath) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-md mb-3">
                <h3 class="font-bold text-lg">{{ $product->name }}</h3>
                <p class="text-blue-600 font-semibold mt-2">
                    @if($product->discounted_price == '' || $product->discounted_price == 0)
                        Rs. {{ $product->price }}
                    @else
                        <span class="line-through text-gray-400">Rs. {{ $product->price }}</span>
                        Rs. {{ $product->discounted_price }}
                    @endif
                </p>
            </a>
        @endforeach
    </div>
</div>

{{-- Quantity Script --}}
<script>
    const quantity = document.getElementById('quantity');
    const stock = {{ $product->stock }};
    document.getElementById('increment').addEventListener('click', function() {
        if (parseInt(quantity.value) < stock) {
            quantity.value = parseInt(quantity.value) + 1;
        }
    });
    document.getElementById('decrement').addEventListener('click', function() {
        if (parseInt(quantity.value) > 1) {
            quantity.value = parseInt(quantity.value) - 1;
        }
    });
</script>

@endsection
