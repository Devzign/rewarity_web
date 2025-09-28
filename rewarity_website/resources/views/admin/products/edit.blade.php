@extends('admin.layouts.app')

@section('title', 'Edit Product')
@section('page_heading', 'Edit Product')

@section('content')
<form method="POST" action="{{ route('admin.products.update', $product) }}">
    @csrf
    @method('PUT')
    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
        <div class="iq-card-header d-flex justify-content-between align-items-center">
            <div class="iq-header-title">
                <h4 class="card-title mb-0">Update product</h4>
            </div>
            <div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
                <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
            </div>
        </div>
        <div class="iq-card-body">
            @include('admin.products._form', ['product' => $product, 'dealers' => $dealers, 'isEdit' => true])
        </div>
    </div>
</form>
@endsection
