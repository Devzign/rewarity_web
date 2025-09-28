@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page_heading', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-6 col-lg-3">
        <a href="{{ route('admin.users.index') }}" class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden text-decoration-none">
            <div class="iq-card-body pb-0">
                <div class="rounded-circle iq-card-icon iq-bg-success"><i class="ri-group-line"></i></div>
                <span class="float-right line-height-6">Total Users</span>
                <div class="clearfix"></div>
                <div class="text-center">
                    <h2 class="mb-0 text-dark"><span class="counter">{{ number_format($metrics['totalUsers']) }}</span></h2>
                    <p class="mb-0 text-secondary line-height">{{ number_format($metrics['activeAdmins']) }} admins active</p>
                </div>
            </div>
            <div id="chart-1"></div>
        </a>
    </div>
    <div class="col-md-6 col-lg-3">
        <a href="{{ route('admin.users.index') }}" class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden text-decoration-none">
            <div class="iq-card-body pb-0">
                <div class="rounded-circle iq-card-icon iq-bg-warning"><i class="ri-user-smile-line"></i></div>
                <span class="float-right line-height-6">Active Dealers</span>
                <div class="clearfix"></div>
                <div class="text-center">
                    <h2 class="mb-0 text-dark"><span class="counter">{{ number_format($metrics['activeDealers']) }}</span></h2>
                    <p class="mb-0 text-secondary line-height">Dealers currently trading</p>
                </div>
            </div>
            <div id="chart-2"></div>
        </a>
    </div>
    <div class="col-md-6 col-lg-3">
        <a href="{{ route('admin.products.index') }}" class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden text-decoration-none">
            <div class="iq-card-body pb-0">
                <div class="rounded-circle iq-card-icon iq-bg-info"><i class="ri-shopping-bag-3-line"></i></div>
                <span class="float-right line-height-6">Products</span>
                <div class="clearfix"></div>
                <div class="text-center">
                    <h2 class="mb-0 text-dark"><span class="counter">{{ number_format($metrics['totalProducts']) }}</span></h2>
                    <p class="mb-0 text-secondary line-height">{{ number_format($metrics['lowStockProducts']) }} low stock alerts</p>
                </div>
            </div>
            <div id="chart-3"></div>
        </a>
    </div>
    <div class="col-md-6 col-lg-3">
        <a href="{{ route('admin.purchases.index') }}" class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden text-decoration-none">
            <div class="iq-card-body pb-0">
                <div class="rounded-circle iq-card-icon iq-bg-danger"><i class="ri-shopping-cart-line"></i></div>
                <span class="float-right line-height-6">Purchases</span>
                <div class="clearfix"></div>
                <div class="text-center">
                    <h2 class="mb-0 text-dark"><span class="counter">{{ number_format($metrics['purchasesThisMonth']) }}</span></h2>
                    <p class="mb-0 text-secondary line-height">Recorded this month</p>
                </div>
            </div>
            <div id="chart-4"></div>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Monthly sales trend </h4>
                </div>
                <div class="iq-card-header-toolbar d-flex align-items-center">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a href="#" class="nav-link active">Latest</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Month</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">All Time</a></li>
                    </ul>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="d-flex justify-content-around">
                    <div class="price-week-box mr-5">
                        <span>Current Week</span>
                        <h2>$<span class="counter">{{ number_format($metrics['purchasesThisMonth'], 2) }}</span> <i class="ri-funds-line text-success font-size-18"></i></h2>
                    </div>
                    <div class="price-week-box">
                        <span>Previous Week</span>
                        <h2>$<span class="counter">52.55</span><i class="ri-funds-line text-danger font-size-18"></i></h2>
                    </div>
                </div>
            </div>
            <div id="chart-5"></div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height animation-card">
            <div class="iq-card-body p-0">
                <div class="an-text">
                    <span>Quarterly Target </span>
                    <h2 class="display-4 font-weight-bold">$<span>2M</span></h2>
                </div>
                <div class="an-img">
                    <div class="bodymovin" data-bm-path="{{ asset('assets/admin/images/small/data.json') }}" data-bm-renderer="svg" data-bm-loop="true"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Top Grossing</h4>
                </div>
                <div class="iq-card-header-toolbar d-flex align-items-center">
                    <div class="dropdown">
                        <span class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown">
                        <i class="ri-more-2-fill"></i>
                        </span>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a>
                            <a class="dropdown-item" href="#"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
                            <a class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a>
                            <a class="dropdown-item" href="#"><i class="ri-printer-fill mr-2"></i>Print</a>
                            <a class="dropdown-item" href="#"><i class="ri-file-download-fill mr-2"></i>Download</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iq-card-body">
                @foreach ($recentProducts->take(3) as $product)
                    <div class="row {{ !$loop->first ? 'mt-4' : '' }}">
                        <div class="col-sm-8">
                            <div class="media-sellers">
                                <div class="media-sellers-img">
                                    <img src="{{ asset('assets/admin/images/page-img/0' . ($loop->index + 1) . '.jpg') }}" class="mr-3 rounded" alt="Product image">
                                </div>
                                <div class="media-sellers-media-info">
                                    <h5 class="mb-0"><a class="text-dark" href="#">{{ $product->product_name }}</a></h5>
                                    <p class="mb-1">Code: {{ $product->product_code }}</p>
                                    <div class="sellers-dt">
                                        <span class="font-size-12">Dealer: <a href="#">{{ $product->dealer?->name ?? '—' }}</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 text-center mt-3">
                            <h5 class="mb-0">{{ number_format($product->current_stock) }}</h5>
                            <span>Stock</span>
                        </div>
                        <div class="col-sm-2 text-center mt-3">
                            <ul class="list-inline mb-0 list-star">
                                <li class="list-inline-item text-warning"><i class="ri-star-fill"></i></li>
                                <li class="list-inline-item text-warning"><i class="ri-star-fill"></i></li>
                                <li class="list-inline-item text-warning"><i class="ri-star-fill"></i></li>
                                <li class="list-inline-item text-warning"><i class="ri-star-fill"></i></li>
                                <li class="list-inline-item text-warning"><i class="ri-star-fill"></i></li>
                            </ul>
                            <span>Rating</span>
                        </div>
                    </div>
                @endforeach
                @if ($recentProducts->isEmpty())
                    <p class="text-muted mb-0">No product data available.</p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Support Tickets</h4>
                        </div>
                        <div class="iq-card-header-toolbar d-flex align-items-center">
                            <div class="dropdown">
                                <span class="dropdown-toggle dropdown-bg" data-toggle="dropdown">View all</span>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a>
                                    <a class="dropdown-item" href="#"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        @forelse ($recentUsers->take(4) as $user)
                            <div class="media-support">
                                <div class="media-support-header mb-2">
                                    <div class="media-support-user-img mr-3">
                                        <img class="rounded-circle" src="{{ asset('assets/admin/images/user/0' . ($loop->index + 1) . '.jpg') }}" alt="user">
                                    </div>
                                    <div class="media-support-info mt-2">
                                        <h6 class="mb-0"><a href="#" class="">{{ $user->name }}</a></h6>
                                        <small>{{ $user->created_at?->diffForHumans() }}</small>
                                    </div>
                                    <div class="mt-3">
                                        <span class="badge badge-success">Pending</span>
                                    </div>
                                </div>
                                <div class="media-support-body">
                                    <p class="mb-0">{{ Str::limit($user->email, 50) }}</p>
                                </div>
                            </div>
                            @if (! $loop->last)
                                <hr class="mt-4 mb-4">
                            @endif
                        @empty
                            <p class="text-muted mb-0">No support tickets to display.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Cash flow</h4>
                        </div>
                        <div class="iq-card-header-toolbar d-flex align-items-center">
                            <div class="dropdown">
                                <span class="dropdown-toggle text-primary" data-toggle="dropdown">
                                <i class="ri-more-2-fill"></i>
                                </span>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a>
                                    <a class="dropdown-item" href="#"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="bar-chart-6"></div>
                </div>
                <div class="iq-card">
                    <div class="iq-card-body p-0">
                        <div class="row align-items-center no-gutters">
                            <div class="col-lg-6">
                                <div class="p-4">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="iq-icon-box rounded-circle iq-bg-primary"><i class="ri-facebook-fill"></i></a>
                                        <h4 class="mb-0"><span class="counter">200</span>k<small class="d-block font-size-14">Posts</small></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div id="wave-chart-7"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="iq-card">
                    <div class="iq-card-body p-0">
                        <div class="row align-items-center no-gutters">
                            <div class="col-lg-6">
                                <div class="p-4">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="iq-icon-box rounded-circle iq-bg-success"><i class="ri-twitter-fill"></i></a>
                                        <h4 class="mb-0"><span class="counter">400</span>k<small class="d-block font-size-14">Tweets</small></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div id="wave-chart-8"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Activity timeline</h4>
                </div>
                <div class="iq-card-header-toolbar d-flex align-items-center">
                    <div class="dropdown">
                        <span class="dropdown-toggle text-primary" data-toggle="dropdown">View All</span>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a>
                            <a class="dropdown-item" href="#"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iq-card-body">
                <ul class="iq-timeline">
                    @foreach ($recentPurchases->take(4) as $purchase)
                        <li>
                            <div class="timeline-dots border-primary"></div>
                            <h6 class="float-left mb-1">{{ $purchase->product?->product_name ?? 'Purchase' }}</h6>
                            <small class="float-right mt-1">{{ $purchase->purchase_date?->format('d M Y') ?? '—' }}</small>
                            <div class="d-inline-block w-100">
                                <p>Seller: {{ $purchase->seller_name ?? '—' }} · Qty {{ $purchase->quantity }}</p>
                            </div>
                        </li>
                    @endforeach
                    @if ($recentPurchases->isEmpty())
                        <li>
                            <div class="timeline-dots"></div>
                            <h6 class="float-left mb-1">No recent activity</h6>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="iq-card">
            <img src="{{ asset('assets/admin/images/small/img-1.jpg') }}" class="img-fluid w-100 rounded" alt="card image">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">How to setup E-store</h4>
                </div>
                <div class="iq-card-header-toolbar d-flex align-items-center">
                    <div class="dropdown">
                        <span class="dropdown-toggle" data-toggle="dropdown"><i class="ri-settings-5-fill"></i></span>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a>
                            <a class="dropdown-item" href="#"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
                            <a class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iq-card-body">
                <span class="font-size-16">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</span>
                <small class="text-muted mt-3 d-inline-block w-100">Saturday, {{ now()->format('j F Y') }}</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Order Summary</h4>
                </div>
                <div class="iq-card-header-toolbar d-flex align-items-center">
                    <div class="dropdown">
                        <span class="dropdown-toggle text-primary" data-toggle="dropdown"><i class="ri-more-2-fill"></i></span>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a>
                            <a class="dropdown-item" href="#"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
                            <a class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a>
                            <a class="dropdown-item" href="#"><i class="ri-printer-fill mr-2"></i>Print</a>
                            <a class="dropdown-item" href="#"><i class="ri-file-download-fill mr-2"></i>Download</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="table-responsive">
                    <table class="table mb-0 table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">Package No.</th>
                                <th scope="col">Date</th>
                                <th scope="col">Delivery</th>
                                <th scope="col">Status</th>
                                <th scope="col">Location</th>
                                <th scope="col">Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($recentPurchases->take(5) as $purchase)
                            <tr>
                                <td>#{{ str_pad((string) $purchase->id, 7, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $purchase->purchase_date?->format('d/m/Y') ?? '—' }}</td>
                                <td>{{ optional($purchase->purchase_date)->addDays(4)?->format('d/m/Y') ?? '—' }}</td>
                                <td><div class="badge badge-pill badge-success">Moving</div></td>
                                <td>{{ $purchase->seller_name ?? '—' }}</td>
                                <td>
                                    <div class="iq-progress-bar">
                                        <span class="bg-success" data-percent="90"></span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No recent orders available.</td>
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
