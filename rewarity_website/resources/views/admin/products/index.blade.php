@extends('admin.layouts.app')

@section('title', 'Products')
@section('page_heading', 'Products')

@section('content')
<div class="iq-card iq-card-block iq-card-stretch iq-card-height mb-3">
    <div class="iq-card-header d-flex flex-wrap justify-content-between align-items-center">
        <div class="iq-header-title">
            <h4 class="card-title mb-0">Inventory</h4>
        </div>
        <div class="d-flex align-items-center">
            <form method="GET" class="form-inline" action="{{ route('admin.products.index') }}">
                <div class="input-group input-group-sm mr-2">
                    <input type="text" class="form-control" name="search" placeholder="Search products" value="{{ $filters['search'] }}">
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
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
            </form>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm"><i class="ri-add-line mr-1"></i>Add Product</a>
        </div>
    </div>
    <div class="iq-card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-light">
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Dealer</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->product_code }}</td>
                        <td>{{ $product->dealer?->name ?? '—' }}</td>
                        <td>
                            <span class="badge badge-{{ $product->current_stock <= $product->low_stock_alert ? 'warning' : 'success' }}">
                                {{ $product->current_stock }}
                            </span>
                            <small class="d-block text-muted">Alert at {{ $product->low_stock_alert }}</small>
                        </td>
                        <td>
                            <span class="badge badge-{{ $product->status ? 'success' : 'secondary' }}">{{ $product->status ? 'Active' : 'Inactive' }}</span>
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-outline-secondary btn-sm">View</a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No products found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-end">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
