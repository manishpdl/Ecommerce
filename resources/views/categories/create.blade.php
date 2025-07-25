@extends('layouts.app')
@section('title','Create Category')

@section('content')
<form action="{{ route('categories.store') }}" method="POST">
    @csrf
<input type="text" class="border border-grey-300 p-2 mb-3 rounded-md w-full" placeholder="Order" name="order" value="{{ old('order') }}">
@error('order')
<div class="text-red-500 mb-3 -mt-3">{{ $message }}</div>
@enderror
<input type="text" class="border border-grey-300 p-2 mb-3 rounded-md w-full" placeholder="Category Name" name="name" value="{{ old('name') }}">
@error('name')
<div class="text-red-500 mb-3 ">{{ $message }}</div>
@enderror
 <div class="flex justify-center mt-4">
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Add Category</button>
<a href="{{ route('categories.index') }}" class="bg-red-600 text-white px-8 py-2 rounded-lg ml-2">Cancel</a>
</div>
</form>

@endsection

