<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $totalcategories = Category::count();
        $totalproducts = Product::count();
        $totalorders = Order::count();
        $totaluser = User::count();
        $totalpending = Order::where('status', 'pending')->count();
        $totalamount = DB::table('orders')// This starts a query on the orders table.
            ->where('status', 'completed')
            ->select(DB::raw('SUM(price * quantity) as total'))//Multiply price and quantity, then sum them all — and call it total
            ->value('total');//This returns the single value of the total field.


        return view('dashboard', compact('totalcategories', 'totalproducts', 'totalorders', 'totaluser', 'totalpending', 'totalamount'));
    }
}
