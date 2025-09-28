@extends('admin.layouts.app')

@section('title', 'Add Product')
@section('page_heading', 'Add Product')

@section('content')
<form method="POST" action="{{ route('admin.products.store') }}">
    @csrf
    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
        <div class="iq-card-header d-flex justify-content-between align-items-center">
            <div class="iq-header-title">
                <h4 class="card-title mb-0">New product</h4>
            </div>
            <div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm">Save product</button>
            </div>
        </div>
        <div class="iq-card-body">
            @include('admin.products._form', ['product' => $product, 'dealers' => $dealers, 'isEdit' => false])
        </div>
    </div>
</form>
@endsection
