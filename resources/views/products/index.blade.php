@extends('layouts.app')
@section('title', 'Products')
@section('content')
       
    <div class="flex justify-end mb-4">
         <form action="{{ route('search.product') }}" method="get" class="mb-4 flex gap-4 ">
            <input type="text" name="search" placeholder="Search by Category" value="{{ request('search') }}" class="border p-2 rounded">
            <button type="submit" value="Search" class="bg-blue-600 text-white px-2 py-2 rounded-lg">Search</button>
        </form>
        <a href="{{route('products.create')}}" class="bg-blue-600 text-white px-4 py-2 mb-4 ml-4 rounded-lg ">Add Product</a>
    </div>
    <table class="w-full">
        <tr class="bg-gray-200">
            <th class="p-2 border border-gray-50">Picture</th>
            <th class="p-2 border border-gray-50">Product Name</th>
            <th class="p-2 border border-gray-50">Price</th>
            <th class="p-2 border border-gray-50">Discounted Price</th>
            <th class="p-2 border border-gray-50">Description</th>
            <th class="p-2 border border-gray-50">Stock</th>
            <th class="p-2 border border-gray-50">Category</th>
            <th class="p-2 border border-gray-50">Action</th>
        </tr>
        @foreach($products as $product)
        <tr class="text-center">
            <td class="p-2 border border-gray-100">
                <img src="{{asset('images/products/'.$product->photopath)}}" alt="" class="h-16">
            </td>
            <td class="p-2 border border-gray-100">{{$product->name}}</td>
            <td class="p-2 border border-gray-100">{{$product->price}}</td>
            <td class="p-2 border border-gray-100">{{$product->discounted_price ?? '--'}}</td>
            <td class="p-2 border border-gray-100">{{$product->description}}</td>
            <td class="p-2 border border-gray-100">{{$product->stock}}</td>
            <td class="p-2 border border-gray-100">{{$product->category->name}}</td>
            <td class="p-2 flex gap-2 border border-gray-100">
                <a href="{{route('products.edit',$product->id)}}" class="bg-blue-600 text-white px-2 py-1 rounded-md">Edit</a>
                <a href="{{route('products.destroy',$product->id)}}" onclick="return confirm('Are you sure to delete?');" class="bg-red-600 text-white px-2 py-1 rounded-md">Delete</a>
            </td>
        </tr>
        @endforeach
       
    </table>  
    <div class="mt-3 text-white">
        {{ $products->links() }}   
    </div>
  
@endsection