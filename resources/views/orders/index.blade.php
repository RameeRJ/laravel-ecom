@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Orders</h2>
        <a href="{{ route('products.index') }}" class="btn btn-primary">
            <i class="fas fa-shopping-bag"></i> Continue Shopping
        </a>
    </div>

    @if($orders->count() > 0)
        @foreach($orders as $order)
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <h6 class="mb-0">Order #{{ $order->id }}</h6>
                            <small class="text-muted">{{ $order->created_at->format('M j, Y') }}</small>
                        </div>
                        <div class="col-md-3">
                            <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'completed' ? 'success' : 'secondary') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="col-md-3">
                            <strong class="text-success">${{ number_format($order->total_amount, 2) }}</strong>
                        </div>
                        <div class="col-md-3 text-end">
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($order->orderItems->take(3) as $item)
                            <div class="col-md-4 mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ $item->product->name }}</h6>
                                        <small class="text-muted">Qty: {{ $item->quantity }}</small>
                                    </div>
                                    <div>
                                        <strong>${{ number_format($item->price * $item->quantity, 2) }}</strong>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        @if($order->orderItems->count() > 3)
                            <div class="col-md-12">
                                <small class="text-muted">
                                    +{{ $order->orderItems->count() - 3 }} more items
                                </small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
            <h4>No orders found</h4>
            <p class="text-muted">You haven't placed any orders yet.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">
                <i class="fas fa-shopping-bag"></i> Start Shopping
            </a>
        </div>
    @endif
</div>
@endsection