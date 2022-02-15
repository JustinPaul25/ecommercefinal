<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function store(Request $request)
    {
        $product = Product::where('id', $request->input('product_id'))->first();
        
        return storeRecommendation($product, 'Visited');
    }
}
