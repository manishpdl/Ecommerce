<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
     @include('layouts.alert')

    @php
        $categories = \App\Models\Category::orderBy('order', 'asc')->get();
    @endphp
    
    <div class="flex gap-3 justify-end items-center text-sm bg-gray-500 text-white py-2 px-12">
        @auth
            <a href="">Hi, {{auth()->user()->name}}</a>
            <a href="{{route('mycart')}}" class="text-white relative">My Cart
                <span class="absolute -top-2 -right-3 bg-yellow-500 text-black rounded-full px-1 text-xs">
                      {{ auth()->user()->carts->count() }}
                </span>
            </a>
            <a href="{{ Route('myorders') }}" class="text-white">My Orders</a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-white">Logout</button>
            </form>
        @else
            <a href="/login">Login</a>
        @endauth

    </div>
    
    <nav class="flex justify-between items-center py-3 px-12 bg-gray-900
 text-white ">
        <h1 class="font-bold text-lg ">
            मनिष
        </h1>
        
        <form action="{{ route('search') }}">
            <input type="search" name="query" id="" placeholder="Search Products" class="px-3 py-2 text-black rounded min-w-[500px]" value="{{ request('query') }}">
            <button type="submit" class="bg-white text-blue-500 px-4 py-2 rounded hover:bg-gray-200 transition duration-200">Search</button>
        </form>
        
        <div class="flex gap-3">
            <a href="/" class="" hover:text-blue-600">Home</a>
            @foreach ($categories as $category)
                <a href="{{route('categoryproduct',$category->id)}}" class="hover:text-blue-600">{{$category->name}}</a>
            @endforeach
        
        </div>
    </nav>

    @yield('content')

    <footer class="text-center bg-gray-800 text-white p-4 mt-5 ">
        <p>&copy; 2025 My Laravel Project</p>
        <p>Created by Manish</p>
    </footer>
</body>

</html>