@extends('admin.layouts.app')

@section('title', 'Profile')
@section('page_heading', 'Profile')

@section('content')
@include('admin.profile._tabs', ['user' => $user])

<div class="row">
    <div class="col-lg-4">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-body">
                <div class="text-center">
                    <img src="{{ $user?->avatar_url ?? asset('assets/admin/images/user/1.jpg') }}" alt="avatar" class="img-fluid rounded-circle" style="width:120px;height:120px;object-fit:cover;">
                    <h4 class="mt-3 mb-0">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ ucfirst($user->user_type ?? 'Administrator') }}</p>
                    <div class="d-flex justify-content-center">
                        <span class="badge badge-pill badge-success mr-2">Active</span>
                        <span class="badge badge-pill badge-primary">{{ $user->status ?? 'Active' }}</span>
                    </div>
                </div>
                <hr>
                <h6 class="mb-2">Contact Information</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="ri-mail-line mr-2 text-primary"></i>{{ $user->email }}</li>
                    <li class="mb-2"><i class="ri-hashtag mr-2 text-primary"></i>{{ $user->employee_id ?? '—' }}</li>
                    <li class="mb-2"><i class="ri-calendar-check-line mr-2 text-primary"></i>Joined {{ $user->created_at?->format('d M Y') ?? '—' }}</li>
                </ul>
            </div>
        </div>
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between align-items-center">
                <div class="iq-header-title">
                    <h4 class="card-title mb-0">Team Snapshot</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Team Members
                        <span class="badge badge-primary badge-pill">{{ number_format($stats['team_members']) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Products
                        <span class="badge badge-info badge-pill">{{ number_format($stats['products']) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Purchases
                        <span class="badge badge-success badge-pill">{{ number_format($stats['purchases']) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Active Dealers
                        <span class="badge badge-warning badge-pill">{{ number_format($stats['active_dealers']) }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Recent Purchases</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Product</th>
                                <th>Dealer</th>
                                <th>Quantity</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentPurchases as $purchase)
                                <tr>
                                    <td>{{ $purchase->product?->product_name ?? '—' }}</td>
                                    <td>{{ $purchase->dealer?->name ?? '—' }}</td>
                                    <td>{{ $purchase->quantity }}</td>
                                    <td>{{ $purchase->purchase_date?->format('d M Y') ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No purchase activity yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Recent Users</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <ul class="iq-timeline">
                    @foreach ($recentUsers as $recent)
                        <li>
                            <div class="timeline-dots border-success"></div>
                            <h6 class="float-left mb-1">{{ $recent->name }}</h6>
                            <small class="float-right mt-1">{{ $recent->created_at?->format('d M Y') ?? '—' }}</small>
                            <div class="d-inline-block w-100">
                                <p class="mb-0">{{ $recent->email }}</p>
                            </div>
                        </li>
                    @endforeach
                    @if ($recentUsers->isEmpty())
                        <li>
                            <div class="timeline-dots"></div>
                            <h6 class="mb-0">No new users</h6>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
