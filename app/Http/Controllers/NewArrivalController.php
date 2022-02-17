<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\Product\ProductCollection;

class NewArrivalController extends Controller
{
    public function heroData()
    {
        $product = Product::where('new_arrival', 1)->orderBy('created_at', 'desc')->take(4)->get();

        return new ProductCollection($product);
    }
}
