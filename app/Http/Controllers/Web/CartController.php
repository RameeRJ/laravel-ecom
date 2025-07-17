<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->is_available || $product->stock_quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Product not available or insufficient stock.');
        }

        Cart::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $request->product_id
            ],
            [
                'quantity' => $request->quantity
            ]
        );

        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            return redirect()->route('cart.index')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($cart->product->stock_quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Insufficient stock.');
        }

        $cart->update(['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'Cart updated successfully.');
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            return redirect()->route('cart.index')->with('error', 'Unauthorized access.');
        }

        $cart->delete();

        return redirect()->back()->with('success', 'Item removed from cart.');
    }
}