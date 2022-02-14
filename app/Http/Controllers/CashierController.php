<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function checkout(Request $request)
    {
        $myCart = Cart::create([
            'status' => 'Walk In',
            'user_id' => 1
        ]);

        foreach($request->input('list') as $product) {
            
            CartItem::create([
                'cart_id' => $myCart->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['pcs']
            ]);

            $currentProduct = Product::where('id', $product['product_id'])->first();
            $currentProduct->update([
                'stock' => ($currentProduct->stock - $product['pcs']),
                'sold' => ($currentProduct->sold + $product['pcs'])
            ]);
        }
        
        return;
    }
}
