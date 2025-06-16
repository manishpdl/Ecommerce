<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home(){
        $latestproduct= Product::latest()->take(4)->get();
        return view('welcome',compact('latestproduct'));
    }
    public function viewproduct($id){
        $product= Product::FindOrFail($id);
        return view('viewproduct',compact('product'));
    }
    public function login()
    {
        return view('login'); 
    }
   
}