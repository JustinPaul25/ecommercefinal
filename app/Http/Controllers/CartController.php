<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartItem\CartItemCollection;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function list()
    {
        return view('frontend.cart');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->where('status', 'unprocess')->get();

        if(count($cart) == 0) {
            $myCart = Cart::create([
                'status' => 'unprocess',
                'user_id' => $user->id
            ]);
        } else {
            $myCart = $cart[0];
        }

        CartItem::create([
            'cart_id' => $myCart->id,
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity')
        ]);

        return 'product added to cart';
    }

    public function myCart()
    {
        $items = [];
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->where('status', 'unprocess')->get();
        if(count($cart) == 0) {
            $myCart = [];
        } else {
            $myCart = $cart[0];
            $items = CartItem::where('cart_id', $myCart->id)->get();
        }

        return new CartItemCollection($items);
    }

    public function destroyItem(CartItem $cartItem)
    {
        $cartItem->delete();

        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->where('status', 'unprocess')->get();
        if(count($cart) == 0) {
            $myCart = [];
        } else {
            $myCart = $cart[0];
        }

        $items = CartItem::where('cart_id', $myCart->id)->get();

        return new CartItemCollection($items);
    }

    public function myCartCheckout()
    {
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->where('status', 'unprocess')->first();

        $cart->update([
            'status' => 'Item/s Getting Ready'
        ]);

        $items = [];

        return new CartItemCollection($items);
    }
}