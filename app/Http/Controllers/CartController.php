<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Shop;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::with('shop')->paginate(10);

        return view('shop.cart', compact('cart'));
    }

    public function store(Request $request)
    {
        $product = json_decode($request->product);
        foreach ($product as $item) {
            $shop = Shop::find($item->id);

            $cart = Cart::where('shop_id', $item->id)->first();
            if ($cart) {
                $cart->increment('qty', $item->qty);
                $cart->total = $shop->price * $cart->qty;
                $cart->save();
            } else {
                $cart = new Cart;
                $cart->shop_id = $shop->id;
                $cart->price = $shop->price;
                $cart->qty = $item->qty;
                $cart->total = $shop->price * $item->qty;
                $cart->save();
            }
        }

        return response()->json(['success' => true, 'message' => 'Cart saved.']);
    }

    public function submit()
    {
        $cart = Cart::with('shop')->get();
        foreach ($cart as $item) {

            $shop = Shop::find($item->shop_id);
            $shop->decrement('stock', $item->qty);
            $item->delete();
        }

        return response()->json(['success' => true, 'message' => 'Data Submit successfully.']);
    }

    public function cancel()
    {
        $cart = Cart::with('shop')->get();
        foreach ($cart as $item) {
            $item->delete();
        }

        return response()->json(['success' => true, 'message' => 'Data Cancel successfully.']);
    }

    public function delete($id)
    {
        $cart = Cart::find($id);
        $cart->delete();

        return response()->json(['success' => true, 'message' => 'Data Deleted successfully.']);
    }
}
