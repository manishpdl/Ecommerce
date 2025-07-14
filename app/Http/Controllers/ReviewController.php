<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function review(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
            'imagephoto' => 'nullable|image', // Validate image upload
        ]);


       $hasOrdered=Order::where('user-id',auth()->id())
            ->where('product_id', $request->product_id)
            ->where('status', 'Delivered') // or 'Completed'
            ->exists();

        if (!$hasOrdered) {
            return redirect()->back()->with('error', 'You can only review products you have purchased.');
        }

        // Handle file upload if an image is provided
        if ($request->hasFile('imagephoto')) {
            $file = $request->file('imagephoto');
            $fileName = auth()->id() . '_review_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/reviews'), $fileName);
            $data['imagephoto'] = $fileName; // Save the file name to the database
        }
        // Set the user ID from the authenticated user  
        $data['user_id'] = auth()->id();

        // Create the review
        Review::create($data);
        return redirect()->back()->with('success', 'Review submitted successfully');
    }
    public function index()
    {
        $reviews = Review::with(['user', 'product'])->get();
        return view('reviews.index', compact('reviews'));
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        // Optional: delete image file from server
        if ($review->imagephoto && file_exists(public_path('images/reviews/' . $review->imagephoto))) {
            unlink(public_path('images/reviews/' . $review->imagephoto));
        }
        $review->delete();
        return redirect()->back()->with('success', 'Review deleted successfully');
    }
}
