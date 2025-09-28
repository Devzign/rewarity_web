@extends('admin.layouts.app')

@section('title', 'User Details')
@section('page_heading', 'User Details')

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-body text-center">
                <img src="{{ $user->avatar_url ?? asset('assets/admin/images/user-profile.jpg') }}" class="img-fluid rounded-circle mb-3" alt="User avatar" style="width:120px;height:120px;object-fit:cover;">
                <h4 class="mb-0">{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->email }}</p>
                <span class="badge badge-primary mb-3">{{ $user->user_type ?? '—' }}</span>
                <div class="d-flex justify-content-around">
                    <div>
                        <small class="text-muted d-block">Status</small>
                        <span class="badge badge-{{ strtolower($user->status) === 'active' ? 'success' : 'secondary' }}">{{ $user->status }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block">Employee ID</small>
                        <span>{{ $user->employee_id ?? '—' }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header">
                <h4 class="card-title mb-0">Contact</h4>
            </div>
            <div class="iq-card-body">
                <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                <p class="mb-2"><strong>Phone:</strong>
                    @if ($user->mobileNumbers->isNotEmpty())
                        {{ $user->mobileNumbers->pluck('number')->join(', ') }}
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </p>
                <p class="mb-0"><strong>Address:</strong><br>
                    @if ($user->address)
                        {{ $user->address->address1 }}<br>
                        @if ($user->address->address2)
                            {{ $user->address->address2 }}<br>
                        @endif
                        {{ $user->address->city }}, {{ $user->address->state }} {{ $user->address->pincode }}<br>
                        {{ $user->address->country }}
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Activities</h4>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary btn-sm">Edit user</a>
            </div>
            <div class="iq-card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Account created</span>
                        <span>{{ $user->created_at?->format('d M Y H:i') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Last updated</span>
                        <span>{{ $user->updated_at?->format('d M Y H:i') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Products managed</span>
                        <span>{{ $user->products_count }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Purchases recorded</span>
                        <span>{{ $user->purchases_count }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
