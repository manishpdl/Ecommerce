<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Reviews;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
     public function review(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

    $data['user_id'] = auth()->id();

        // Create the review
    Reviews::create($data);
        return redirect()->back()->with('success', 'Review submitted successfully');
    }
    public function index()
    {
        $reviews = Reviews::with(['user', 'product'])->get();
        return view('reviews.index', compact('reviews'));
    }

    public function destroy($id)
    {
        $review = Reviews::findOrFail($id);
        $review->delete();
        return redirect()->back()->with('success', 'Review deleted successfully');
    }
}
