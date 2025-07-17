<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\OrderConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display the user's orders
     */
    public function index()
    {
        $orders = Order::with('orderItems.product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Process the checkout and create order
     */
    public function store(Request $request)
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        // Check stock availability
        foreach ($cartItems as $item) {
            if (!$item->product->is_available || $item->product->stock_quantity < $item->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', "Product '{$item->product->name}' is not available or insufficient stock.");
            }
        }

        $totalAmount = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        DB::beginTransaction();

        try {
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'status' => 'pending'
            ]);

            // Create order items and update stock
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);

                // Update product stock
                $item->product->decrement('stock_quantity', $item->quantity);

                // Update availability if out of stock
                if ($item->product->stock_quantity <= 0) {
                    $item->product->update(['is_available' => false]);
                }
            }

            // Clear cart
            Cart::where('user_id', Auth::id())->delete();

            // Load order with relationships for email
            $order->load(['orderItems.product', 'user']);

            // Send order confirmation email
            try {
                Mail::to(Auth::user()->email)->send(new OrderConfirmation($order));
            } catch (\Exception $e) {
                // Log email error but don't fail the order
                \Log::error('Order confirmation email failed: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('orders.confirmation', $order)
                ->with('success', 'Order placed successfully! A confirmation email has been sent.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')
                ->with('error', 'Order creation failed. Please try again.');
        }
    }

    /**
     * Show order confirmation page
     */
    public function confirmation(Order $order)
    {
        // Ensure user can only view their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to order.');
        }

        $order->load(['orderItems.product', 'user']);

        return view('orders.confirmation', compact('order'));
    }

    /**
     * Show specific order details
     */
    public function show(Order $order)
    {
        // Ensure user can only view their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to order.');
        }

        $order->load(['orderItems.product']);

        return view('orders.show', compact('order'));
    }
}