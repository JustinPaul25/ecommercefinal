<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Sold;
use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Recommendation;
use App\Events\UserNotification;
use App\Http\Resources\Cart\CartCollection;

class OrderController extends Controller
{
    public function list()
    {
        return view('backend.orders');
    }

    public function allOrders()
    {
        $cart = Cart::where('status', '!=', 'unprocess')->get();

        return new CartCollection($cart);
    }

    public function cartChangeStatus(Request $request, Cart $cart)
    {
        if($request->input('status') == "sold") {
            if($cart->method == 'pick-up') {
                $items = CartItem::where('cart_id', $cart->id)->get();
                foreach($items as $item) {
                    $product = Product::where('id', $item->product->id)->first();
                    $product->update([
                        'stock' => ($product->stock - $item->quantity),
                        'sold' => $product->sold + $item->quantity
                    ]);
                    Sold::create([
                        'product_id' => $item->product->id,
                        'cart_id' => $cart->id,
                        'quantity' => $item->quantity,
                        'total_price' => ($item->quantity*$product->price)
                    ]);
    
                    $recommendation = Recommendation::where('user_id', $cart->user_id)->where('product_id', $product->id)->get();
                    
                    if(count($recommendation) == 0) {
                        Recommendation::create([
                            'user_id' => $cart->user_id,
                            'product_id' => $product->id,
                            'score' => 1
                        ]);
                    }
                }
            }
        
            $cart->update([
                'status' => $request->input('status'),
                'date_pickup' => Carbon::now()
            ]);
        } else {
            $cart->update([
                'status' => $request->input('status')
            ]);
            $notification = Notification::where('user_id', $cart->user_id)->first();
            
            $notification->update([
                'order' =>  $notification->order + 1
            ]);

            $user = User::where('id', $cart->user_id)->first();
            broadcast(new UserNotification($user))->toOthers();
        }

        $carts = Cart::where('status', '!=', 'unprocess')->get();

        return new CartCollection($carts);
    }
    
    public function customerOrders()
    {
        $cart = Cart::where('status', '!=', 'unprocess')->where('user_id', auth()->id())->get();

        $data = new CartCollection($cart);
        return view('frontend.orders', ['data' => $data]);
    }

    public function cancelOrder(Cart $cart)
    {
        $cart->update([
            'status' => 'cancelled'
        ]);
    }
}
