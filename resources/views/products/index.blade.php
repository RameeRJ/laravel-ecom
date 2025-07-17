@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h5>Filters</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('home') }}">
                    <div class="mb-3">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Search products...">
                    </div>

                    <div class="mb-3">
                        <label for="min_price" class="form-label">Min Price</label>
                        <input type="number" class="form-control" id="min_price" name="min_price" 
                               value="{{ request('min_price') }}" step="0.01" min="0">
                    </div>

                    <div class="mb-3">
                        <label for="max_price" class="form-label">Max Price</label>
                        <input type="number" class="form-control" id="max_price" name="max_price" 
                               value="{{ request('max_price') }}" step="0.01" min="0">
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="available" name="available" 
                                   value="1" {{ request('available') ? 'checked' : '' }}>
                            <label class="form-check-label" for="available">
                                Available Only
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('home') }}" class="btn btn-secondary">Clear</a>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Products</h2>
            <span class="text-muted">{{ $products->total() }} products found</span>
        </div>

        @if($products->count() > 0)
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                <p class="card-text">
                                    <strong class="text-primary">${{ number_format($product->price, 2) }}</strong>
                                </p>
                                <p class="card-text">
                                    <small class="text-muted">
                                        Stock: {{ $product->stock_quantity }}
                                        @if($product->is_available)
                                            <span class="badge bg-success">Available</span>
                                        @else
                                            <span class="badge bg-danger">Out of Stock</span>
                                        @endif
                                    </small>
                                </p>
                            </div>
                            <div class="card-footer">
                                @auth
                                    @if($product->is_available && $product->stock_quantity > 0)
                                        <form method="POST" action="{{ route('cart.store') }}" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-cart-plus"></i> Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary" disabled>Out of Stock</button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary">Login to Add to Cart</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h4>No products found</h4>
                <p class="text-muted">Try adjusting your search criteria.</p>
            </div>
        @endif
    </div>
</div>
@endsection