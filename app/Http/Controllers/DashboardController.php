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
        $totalorders = Order::where('status', '!=', 'Cancelled')->count(); // Count all orders except those that are cancelled
        $totaluser = User::where('role', 'user')->count(); // Count only users with the role 'user'
        $totalpending = Order::where('status', 'pending')->count();
        // $totalrevenue = DB::table('orders')// This starts a query on the orders table.
        //     ->where('status', 'Delivered')// Filter orders that are delivered
        //     ->select(DB::raw('SUM(price * quantity) as total'))//Multiply price and quantity, then sum them all — and call it total
        //     ->value('total');//This returns the single value of the total field.

        $allorders = Order::where('status', 'Delivered')->get();
        $totalrevenue = 0;
        foreach ($allorders as $order) {
            $totalrevenue += $order->price * $order->quantity;
        }

        // Get all categories and count products in each category
        $allcat = Category::get();
        foreach ($allcat as $cat) {
            $cat->totalproducts = Product::where('category_id', $cat->id)->count();
        }
        //for the chart
        $allcategories = $allcat->pluck('name')->toArray();
        $allproducts = $allcat->pluck('totalproducts')->toArray();
        $allcategories = json_encode($allcategories);
        $allproducts = json_encode($allproducts);


        //monthly revenue

        
    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $currentYear = date('Y');
    
    // Get all categories' names
    $categories = Category::pluck('name')->toArray();
    
    // Prepare empty data matrix: [ 'Category1' => [0,0,...], 'Category2' => [...], ... ]
    $dataMatrix = [];
    foreach ($categories as $category) {
        $dataMatrix[$category] = array_fill(0, 12, 0);
    }
    
    // For each category and month, calculate monthly sales
    foreach ($categories as $category) {
        foreach ($months as $index => $month) {
            $monthNum = date('m', strtotime($month));
            $monthlySum = Order::join('products', 'orders.product_id', '=', 'products.id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->where('categories.name', $category)
                ->where('orders.status', 'Delivered')
                ->whereYear('orders.created_at', $currentYear)
                ->whereMonth('orders.created_at', $monthNum)
                ->sum(DB::raw('orders.price * orders.quantity'));

            $dataMatrix[$category][$index] = (float) $monthlySum;
        }
    }

    // Encode for JS
    $monthsJson = json_encode($months);
    $categoriesJson = json_encode($categories);
    $dataMatrixJson = json_encode($dataMatrix);

        return view('dashboard', compact(
            'totalcategories',
            'totalproducts',
            'totalorders',
            'totaluser',
            'totalpending',
            'totalrevenue',
            'allcategories',
            'allproducts',
           
            'categoriesJson',
            'dataMatrixJson',
            'monthsJson'

        ));
    }
}
