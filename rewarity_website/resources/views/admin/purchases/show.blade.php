@extends('admin.layouts.app')

@section('title', 'Purchase Details')
@section('page_heading', 'Purchase Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Purchase summary</h4>
                <a href="{{ route('admin.purchases.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
            </div>
            <div class="iq-card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Product:</strong> {{ $purchase->product?->product_name ?? '—' }}</p>
                        <p class="mb-2"><strong>Dealer:</strong> {{ $purchase->dealer?->name ?? '—' }}</p>
                        <p class="mb-2"><strong>Seller:</strong> {{ $purchase->seller_name }}</p>
                        <p class="mb-2"><strong>Quantity:</strong> {{ $purchase->quantity }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Price per unit:</strong> Rs. {{ number_format($purchase->purchase_price, 2) }}</p>
                        <p class="mb-2"><strong>Total cost:</strong> Rs. {{ number_format($purchase->purchase_price * $purchase->quantity, 2) }}</p>
                        <p class="mb-2"><strong>Purchase date:</strong> {{ $purchase->purchase_date?->format('d M Y') }}</p>
                    </div>
                </div>
                <div class="mt-3">
                    <h5 class="mb-2">Notes</h5>
                    <p class="mb-0">{{ $purchase->notes ?: 'No additional notes recorded.' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
