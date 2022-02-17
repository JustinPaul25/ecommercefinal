<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class OnlinePaymentController extends Controller
{
    public function getSetupIntent()
    {
        return auth()->user()->createSetupIntent();
    }

    public function checkout(Request $request)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->where('status', 'unprocess')->first();
        $payment = 0;

        foreach($cart->cartItems as $item) {
            $product = Product::where('id', $item->id)->first();
            $payment += $item->quantity*$product->price;
        }

        $paymentMethodID = $request->get('payment_method');

        auth()->user()->createOrGetStripeCustomer();
        auth()->user()->addPaymentMethod( $paymentMethodID );
        $stripeCharge = $request->user()->charge(
            $payment, $paymentMethodID
        );

        foreach($cart->cartItems as $item) {
            $product = Product::where('id', $item->id)->first();
            storeRecommendation($product);
        }

        $cart->update([
            'status' => 'Sold'
        ]);

        return $stripeCharge;
    }
}
