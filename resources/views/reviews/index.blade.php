@extends('layouts.app')
@section('title', 'Product Reviews')

@section('content')

<table class="w-full">
        <tr class=" bg-gray-200">
            <th  class="p-2 border border-gray-50">User_Id</th>
             <th  class="p-2 border border-gray-50">User_Name</th>
             <th class="p-2 border border-gray-50  ">Image</th>
             <th  class="p-2 border border-gray-50  ">Product</th>
            <th sclass="p-2 border border-gray-50 ">Rating</th>
            <th  class="p-2 border border-gray-50 ">Review</th>
            <th  class="p-2 border border-gray-50">Actiom</th>
        </tr>
    
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach($reviews as $review)
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">{{ $review->user_id }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $review->user->name}}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                @if($review->imagephoto)
                    <img src="{{ asset('images/reviews/' . $review->imagephoto) }}" alt="Review Image" class="w-16 h-16 object-cover rounded">
                @else
                    No Image
                @endif
            <td class="px-6 py-4 whitespace-nowrap">{{ $review->product->name }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $review->rating }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $review->comment }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <form action="{{ route('reviews.destroy',$review->id) }}" method="get">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
@endsection