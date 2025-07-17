@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Shopping Cart</h2>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Products
            </a>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if($cartItems->count() > 0)
            <div class="card">
                <div class="card-body">
                    @foreach($cartItems as $item)
                        <div class="row align-items-center mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                            <div class="col-md-6">
                                <h5>{{ $item->product->name }}</h5>
                                <p class="text-muted mb-1">{{ Str::limit($item->product->description, 80) }}</p>
                                @if($item->product->stock_quantity < $item->quantity)
                                    <div class="text-danger small">
                                        <i class="fas fa-exclamation-triangle"></i> 
                                        Only {{ $item->product->stock_quantity }} left in stock
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-2">
                                <strong>${{ number_format($item->product->price, 2) }}</strong>
                            </div>
                            <div class="col-md-2">
                                <form method="POST" action="{{ route('cart.update', $item) }}" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-group">
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                               min="1" max="{{ $item->product->stock_quantity }}" 
                                               class="form-control form-control-sm">
                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-sync"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-2">
                                <strong>${{ number_format($item->quantity * $item->product->price, 2) }}</strong>
                                <form method="POST" action="{{ route('cart.destroy', $item) }}" class="d-inline ms-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('Remove this item?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h4>Your cart is empty</h4>
                <p class="text-muted">Start shopping to add items to your cart.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Back to Products
                </a>
            </div>
        @endif
    </div>

    @if($cartItems->count() > 0)
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>${{ number_format($total, 2) }}</span>
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
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong>${{ number_format($total , 2) }}</strong>
                    </div>
                    
                    <form method="POST" action="{{ route('orders.store') }}" id="checkoutForm">
                        @csrf
                        <button type="submit" class="btn btn-success w-100" id="checkoutBtn">
                            <i class="fas fa-credit-card"></i> Checkout
                        </button>
                    </form>
                    
                </div>
            </div>
        </div>
    @endif
</div>

<script>
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    const btn = document.getElementById('checkoutBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
});
</script>
@endsection