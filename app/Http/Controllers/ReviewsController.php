<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function store(Request $request)
    {

        Review::create([
            'product_id' => $request->input('product_id'),
            'user_id' => auth()->user()->id,
            'stars' => $request->input('stars'),
            'message' => $request->input('comment')
        ]);
    }
}
