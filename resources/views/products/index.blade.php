@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-primary fw-bold">Products</h1>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('products.index') }}" class="row g-3 mb-4">
            <div class="col-md-3">
                <input type="number" name="min_price" class="form-control" placeholder="Min Price"
                    value="{{ request('min_price') }}">
            </div>
            <div class="col-md-3">
                <input type="number" name="max_price" class="form-control" placeholder="Max Price"
                    value="{{ request('max_price') }}">
            </div>
            <div class="col-md-3">
                <select name="is_available" class="form-select">
                    <option value="">All</option>
                    <option value="1" {{ request('is_available') === '1' ? 'selected' : '' }}>Available</option>
                    <option value="0" {{ request('is_available') === '0' ? 'selected' : '' }}>Unavailable</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
                @if(request()->has('min_price') || request()->has('max_price') || request()->has('is_available'))
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100">Clear</a>
                @endif
            </div>
        </form>

        <!-- Product Cards -->
        <div class="row">
            @forelse($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="https://dummyimage.com/600x400/cccccc/000000&text=Product+Image" class="card-img-top"
                            alt="{{ $product->name }}" style="object-fit:cover; height:180px;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text mb-1">${{ number_format($product->price, 2) }}</p>
                            <span class="badge {{ $product->is_available ? 'bg-success' : 'bg-secondary' }}">
                                {{ $product->is_available ? 'Available' : 'Unavailable' }}
                            </span>
                            <div class="mt-auto d-flex flex-column gap-2">
                                <a href="#" class="btn btn-outline-primary btn-sm">View</a>
                                @auth
                                    @if(auth()->user()->role === 'user' && $product->is_available)
                                        <form method="POST" action="{{ route('cart.store') }}">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit"
                                                class="btn btn-success btn-sm w-100 btn-add-cart d-flex align-items-center justify-content-center gap-2">
                                                <span class="cart-bounce">
                                                    <i class="fas fa-cart-plus fa-lg"></i>
                                                </span>
                                                Add to Cart
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">No products found.</div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>
@endsection