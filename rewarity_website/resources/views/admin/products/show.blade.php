@extends('admin.layouts.app')

@section('title', 'Product Details')
@section('page_heading', 'Product Details')

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Overview</h4>
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-primary btn-sm">Edit</a>
            </div>
            <div class="iq-card-body">
                <p class="mb-2"><strong>Name:</strong> {{ $product->product_name }}</p>
                <p class="mb-2"><strong>Code:</strong> {{ $product->product_code }}</p>
                <p class="mb-2"><strong>Dealer:</strong> {{ $product->dealer?->name ?? '—' }}</p>
                <p class="mb-2"><strong>Purchase price:</strong> Rs. {{ number_format($product->purchase_price, 2) }}</p>
                <p class="mb-2"><strong>Selling price:</strong> Rs. {{ number_format($product->selling_price, 2) }}</p>
                <p class="mb-2"><strong>Current stock:</strong> {{ $product->current_stock }}</p>
                <p class="mb-2"><strong>Low stock alert:</strong> {{ $product->low_stock_alert }}</p>
                <p class="mb-2"><strong>Status:</strong>
                    <span class="badge badge-{{ $product->status ? 'success' : 'secondary' }}">{{ $product->status ? 'Active' : 'Inactive' }}</span>
                </p>
                <p class="mb-0"><strong>Start date:</strong> {{ $product->start_date?->format('d M Y') ?? '—' }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Recent purchases</h4>
                <a href="{{ route('admin.purchases.index', ['search' => $product->product_name]) }}" class="btn btn-outline-secondary btn-sm">View all</a>
            </div>
            <div class="iq-card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th>Dealer</th>
                            <th>Seller</th>
                            <th>Quantity</th>
                            <th>Purchase price</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($product->purchases->take(5) as $purchase)
                            <tr>
                                <td>{{ $purchase->dealer?->name ?? '—' }}</td>
                                <td>{{ $purchase->seller_name }}</td>
                                <td>{{ $purchase->quantity }}</td>
                                <td>Rs. {{ number_format($purchase->purchase_price, 2) }}</td>
                                <td>{{ $purchase->purchase_date?->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No purchases recorded for this product yet.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
