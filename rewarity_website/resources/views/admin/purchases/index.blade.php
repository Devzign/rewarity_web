@extends('admin.layouts.app')

@section('title', 'Purchases')
@section('page_heading', 'Purchases')

@section('content')
<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
    <div class="iq-card-header d-flex flex-wrap justify-content-between align-items-center">
        <div class="iq-header-title">
            <h4 class="card-title mb-0">Purchase History</h4>
        </div>
        <form method="GET" action="{{ route('admin.purchases.index') }}" class="form-inline">
            <div class="input-group input-group-sm mr-2">
                <input type="text" class="form-control" name="search" placeholder="Search seller or product" value="{{ $filters['search'] }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit"><i class="ri-search-line"></i></button>
                </div>
            </div>
            <select name="dealer_id" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                <option value="">All dealers</option>
                @foreach ($dealers as $dealer)
                    <option value="{{ $dealer->id }}" @selected($filters['dealer_id'] === $dealer->id)>{{ $dealer->name }}</option>
                @endforeach
            </select>
            <input type="date" name="date_from" class="form-control form-control-sm mr-2" value="{{ optional($filters['date_from'])->format('Y-m-d') }}" onchange="this.form.submit()">
            <input type="date" name="date_to" class="form-control form-control-sm mr-2" value="{{ optional($filters['date_to'])->format('Y-m-d') }}" onchange="this.form.submit()">
            <a href="{{ route('admin.purchases.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
        </form>
    </div>
    <div class="iq-card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-light">
                <tr>
                    <th>Product</th>
                    <th>Dealer</th>
                    <th>Seller</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th class="text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($purchases as $purchase)
                    <tr>
                        <td>{{ $purchase->product?->product_name ?? '—' }}</td>
                        <td>{{ $purchase->dealer?->name ?? '—' }}</td>
                        <td>{{ $purchase->seller_name }}</td>
                        <td>{{ $purchase->quantity }}</td>
                        <td>Rs. {{ number_format($purchase->purchase_price, 2) }}</td>
                        <td>{{ $purchase->purchase_date?->format('d M Y') }}</td>
                        <td class="text-right">
                            <a href="{{ route('admin.purchases.show', $purchase) }}" class="btn btn-outline-secondary btn-sm">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No purchases match the selected filters.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-end">
            {{ $purchases->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
