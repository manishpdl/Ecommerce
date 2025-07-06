<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(4);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('order', 'asc')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'discounted_price' => 'nullable|numeric|lt:price',
            'description' => 'required|string',
            'stock' => 'required|numeric',
            'photopath' => 'required|image'
        ]);

        // Handle file upload
        $file = $request->file('photopath'); //Gets the uploaded image
        $fileName = time() . '.' . $file->getClientOriginalExtension(); //Renames it to something unique
        $file->move(public_path('images/products'), $fileName); //Moves it to public/images/products
        $data['photopath'] = $fileName; //Saves the file name to the database

        // Create the product
        Product::create($data);
        return redirect()->route('products.index')->with('success', 'Product Created Successfully'); //Shows success message
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('order', 'asc')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'discounted_price' => 'nullable|numeric|lt:price',
            'description' => 'required|string',
            'stock' => 'required|numeric',
            'photopath' => 'nullable|image'
        ]);

        $product = Product::findOrFail($id);
        if ($request->hasFile('photopath')) {
            // Handle file upload
            $file = $request->file('photopath');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/products'), $fileName);
            $data['photopath'] = $fileName;
            //unlink the old image
            if (file_exists(public_path('images/products/' . $product->photopath))) {
                unlink(public_path('images/products/' . $product->photopath));
            }
        }

        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Product Updated Successfully');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        //unlink the image
        if (file_exists(public_path('images/products/' . $product->photopath))) {
            unlink(public_path('images/products/' . $product->photopath));
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product Deleted Successfully');
    }



   public function searchproduct(Request $request){
     $searchproduct = $request->input('search');
     $products=Product::query();

     if($searchproduct){
 $products = $products->whereHas('category', function ($query) use ($searchproduct) {
            $query->where('name', 'like', '%' . $searchproduct . '%');
        });     }else{
        $products=$products->latest();      
        }
     $products = $products->paginate(4);
     return view('products.index',compact('products'));
     
     }
}
     