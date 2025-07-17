@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <h1 class="h3 mb-0 fw-bold text-primary">Admin Dashboard</h1>
    <!-- Uncomment if you want to add a product button -->
    <!--
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Product
    </a>
    -->
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="card-title text-uppercase fw-semibold">Total Orders</h6>
                    <h2 class="mb-0">{{ number_format($totalOrders) }}</h2>
                </div>
                <i class="fas fa-shopping-cart fa-2x opacity-75"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="card-title text-uppercase fw-semibold">Total Revenue</h6>
                    <h2 class="mb-0">${{ number_format($totalRevenue, 2) }}</h2>
                </div>
                <i class="fas fa-dollar-sign fa-2x opacity-75"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
            <div class="card bg-info text-white shadow-sm h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-uppercase fw-semibold">Total Products</h6>
                        <h2 class="mb-0">{{ number_format($totalProducts) }}</h2>
                    </div>
                    <i class="fas fa-box fa-2x opacity-75"></i>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="card-title text-uppercase fw-semibold">Low Stock</h6>
                    <h2 class="mb-0">{{ number_format($lowStockProducts) }}</h2>
                </div>
                <i class="fas fa-exclamation-triangle fa-2x opacity-75"></i>
            </div>
        </div>
    </div>
</div>
@endsection