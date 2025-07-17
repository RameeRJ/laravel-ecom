@extends('layouts.app')

@section('title', 'Order Confirmation')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Success Message -->
            <div class="text-center mb-4">
                <div class="mb-3">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                <h2 class="text-success">Order Confirmed!</h2>
                <p class="text-muted">Thank you for your purchase. Your order has been successfully placed.</p>
            </div>

            <!-- Order Details Card -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt"></i> Order Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Order Information</h6>
                            <p><strong>Order Number:</strong> #{{ $order->id }}</p>
                            <p><strong>Order Date:</strong> {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-warning">{{ ucfirst($order->status) }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Customer Information</h6>
                            <p><strong>Name:</strong> {{ $order->user->name }}</p>
                            <p><strong>Email:</strong> {{ $order->user->email }}</p>
                            <p><strong>Total Amount:</strong> 
                                <span class="text-success font-weight-bold">${{ number_format($order->total_amount, 2) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-box"></i> Order Items
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($order->orderItems as $item)
                        <div class="row align-items-center {{ !$loop->last ? 'border-bottom pb-3 mb-3' : '' }}">
                            <div class="col-md-6">
                                <h6>{{ $item->product->name }}</h6>
                                <p class="text-muted mb-0">{{ Str::limit($item->product->description, 80) }}</p>
                            </div>
                            <div class="col-md-2">
                                <strong>${{ number_format($item->price, 2) }}</strong>
                            </div>
                            <div class="col-md-2">
                                <span class="badge bg-secondary">Qty: {{ $item->quantity }}</span>
                            </div>
                            <div class="col-md-2 text-end">
                                <strong>${{ number_format($item->price * $item->quantity, 2) }}</strong>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-calculator"></i> Order Summary
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 offset-md-6">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>${{ number_format($order->total_amount, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping:</span>
                                <span class="text-success">Free</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax:</span>
                                <span>$0.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total:</strong>
                                <strong class="text-success">${{ number_format($order->total_amount, 2) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle"></i> What's Next?
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-3">
                            <i class="fas fa-envelope text-primary mb-2" style="font-size: 2rem;"></i>
                            <h6>Email Confirmation</h6>
                            <p class="text-muted small">We've sent a confirmation email to {{ $order->user->email }}</p>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <i class="fas fa-cog text-warning mb-2" style="font-size: 2rem;"></i>
                            <h6>Processing</h6>
                            <p class="text-muted small">Your order is being processed and will be shipped soon</p>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <i class="fas fa-shipping-fast text-success mb-2" style="font-size: 2rem;"></i>
                            <h6>Tracking</h6>
                            <p class="text-muted small">You'll receive tracking information via email</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center mb-4">
                <a href="{{ route('orders.index') }}" class="btn btn-primary me-2">
                    <i class="fas fa-list"></i> View All Orders
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-shopping-bag"></i> Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endsection