@extends('layouts.master')
@section('content')
    <div class="px-20 py-10">
        <h2 class="font-bold text-3xl border-l-4 border-blue-500 pl-2">{{$category->name}} Products</h2>
        <!-- Filter Dropdown -->
    <div class="flex justify-end mb-6">
        <form action="{{ route('categoryproduct', $category->id) }}" method="GET" class="flex items-center">
            <label for="sort" class="mr-3 text-gray-700 font-medium text-sm md:text-base">Sort By:</label>
            <select name="sort" id="sort" onchange="this.form.submit()"
                class="border border-gray-200 rounded-full px-4 py-2 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-[#d4af37] transition-all duration-300 text-sm md:text-base">
                <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Default</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
                <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Title (A to Z)</option>
                <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Title (Z to A)</option>
                <option value="created_at_desc" {{ request('sort') == 'created_at_desc' ? 'selected' : '' }}>Latest Added</option>
                <option value="created_at_asc" {{ request('sort') == 'created_at_asc' ? 'selected' : '' }}>Oldest Added</option>
            </select>
        </form>
    </div>
        <div class="grid grid-cols-4 gap-4 mt-5">
            @foreach($products as $product)
            <a href="{{route('viewproduct',$product->id)}}" class="bg-white shadow-md rounded-lg p-4 hover:shadow-lg hover:-translate-y-2 transition-all duration-300">
                <img src="{{asset('images/products/'.$product->photopath)}}" alt="" class="w-full h-48 object-cover rounded-md mb-3">
                <h3 class="font-bold text-xl">{{$product->name}}</h3>
                <p class="text-blue-500 font-bold mt-2">
                    @if($product->discounted_price == '' || $product->discounted_price == 0)
                    Rs. {{$product->price}}
                    @else
                    <span class="line-through text-gray-500">Rs. {{$product->price}}</span>
                    Rs. {{$product->discounted_price}}
                    @endif
                </p>
            </a>
            @endforeach
        </div>
        <div>
            {{ $products->links() }}
        </div>
    </div>
@endsection
