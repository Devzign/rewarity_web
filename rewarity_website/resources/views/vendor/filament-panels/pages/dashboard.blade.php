@php
    use App\Models\Product;
    use App\Models\User;
    $authUser = auth()->user();
    $totalUsers = User::count();
    $activeDealers = User::where('user_type', 'Dealer')->where('status', 'Active')->count();
    $activeDistributors = User::where('user_type', 'Distributor')->where('status', 'Active')->count();
    $activeAdmins = User::where('user_type', 'Admin')->where('status', 'Active')->count();
    $newUsersThisWeek = User::where('created_at', '>=', now()->subWeek())->count();
    $totalProducts = Product::count();
    $lowStockProducts = Product::whereColumn('current_stock', '<=', 'low_stock_alert')->count();
    $healthyStockProducts = Product::whereColumn('current_stock', '>', 'low_stock_alert')->count();

    $panel = filament()->getPanel();
    $usersCreateRoute = $panel->generateRouteName('resources.users.create');
    $productsIndexRoute = $panel->generateRouteName('resources.products.index');
    $usersIndexRoute = $panel->generateRouteName('resources.users.index');
@endphp

<x-filament-panels::page>
    <div class="space-y-8">
        <section class="rounded-3xl bg-white/95 p-8 lg:p-10 shadow-xl ring-1 ring-gray-950/5 grid gap-8 lg:grid-cols-3">
            <div class="lg:col-span-2 flex flex-col gap-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <x-filament::avatar :user="$authUser" class="h-16 w-16 ring-4 ring-emerald-100" />
                        <div class="space-y-1">
                            <p class="text-xs font-semibold uppercase tracking-widest text-emerald-600">Welcome back</p>
                            <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $authUser?->name ?? 'Team Member' }}</h1>
                            <p class="text-sm text-gray-500">{{ $authUser?->user_type ?? 'Administrator' }} · {{ now()->format('l, d M Y') }}</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ filament()->getPanel()->route('auth.profile') }}"
                           class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-5 py-2 text-sm font-medium text-emerald-700 transition hover:bg-emerald-200">
                            <x-filament::icon icon="heroicon-o-user-circle" class="h-5 w-5" />
                            View Profile
                        </a>
                        <a href="{{ filament()->getPanel()->route('auth.logout') }}"
                           class="inline-flex items-center gap-2 rounded-full bg-rose-100 px-5 py-2 text-sm font-medium text-rose-700 transition hover:bg-rose-200"
                           onclick="event.preventDefault(); document.getElementById('admin-dashboard-logout').submit();">
                            <x-filament::icon icon="heroicon-o-arrow-right-on-rectangle" class="h-5 w-5" />
                            Sign Out
                        </a>
                        <form id="admin-dashboard-logout" action="{{ filament()->getPanel()->route('auth.logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-5 text-gray-900">
                        <span class="text-sm font-medium text-emerald-700">Total Users</span>
                        <strong class="mt-1 block text-3xl font-semibold">{{ number_format($totalUsers) }}</strong>
                        <p class="text-xs text-emerald-700/80">{{ $newUsersThisWeek }} joined this week</p>
                    </div>
                    <div class="rounded-2xl border border-sky-100 bg-sky-50 p-5 text-gray-900">
                        <span class="text-sm font-medium text-sky-700">Active Dealers</span>
                        <strong class="mt-1 block text-3xl font-semibold">{{ number_format($activeDealers) }}</strong>
                        <p class="text-xs text-sky-700/80">{{ number_format($activeDistributors) }} active distributors</p>
                    </div>
                    <div class="rounded-2xl border border-amber-100 bg-amber-50 p-5 text-gray-900">
                        <span class="text-sm font-medium text-amber-700">Products Managed</span>
                        <strong class="mt-1 block text-3xl font-semibold">{{ number_format($totalProducts) }}</strong>
                        <p class="text-xs text-amber-700/80">{{ number_format($healthyStockProducts) }} healthy · {{ number_format($lowStockProducts) }} low stock</p>
                    </div>
                </div>
            </div>

            <div class="relative z-10 grid gap-6 content-center">
                <div class="rounded-3xl bg-white p-6 text-gray-900 shadow-lg ring-1 ring-gray-950/5">
                    <p class="text-xs font-semibold uppercase tracking-widest text-emerald-600">Today&apos;s Summary</p>
                    <dl class="mt-3 space-y-3 text-sm">
                        <div class="flex items-center justify-between">
                            <dt class="flex items-center gap-2 text-gray-600">
                                <x-filament::icon icon="heroicon-m-user-group" class="h-4 w-4 text-emerald-500" />
                                New signups
                            </dt>
                            <dd class="text-base font-semibold text-emerald-700">
                                {{ User::whereDate('created_at', today())->count() }}
                            </dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="flex items-center gap-2 text-gray-600">
                                <x-filament::icon icon="heroicon-m-chart-bar-square" class="h-4 w-4 text-emerald-500" />
                                Low stock alerts
                            </dt>
                            <dd class="text-base font-semibold text-amber-600">{{ $lowStockProducts }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="flex items-center gap-2 text-gray-600">
                                <x-filament::icon icon="heroicon-m-shield-check" class="h-4 w-4 text-emerald-500" />
                                Active admins
                            </dt>
                            <dd class="text-base font-semibold text-emerald-700">{{ $activeAdmins }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
            <article class="lg:col-span-2 space-y-6">
                <div class="profile-card p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold">User Segments</h3>
                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-emerald-700">Overview</span>
                    </div>
                    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4 text-sm">
                        <div class="rounded-2xl border border-emerald-100/60 bg-emerald-50/60 p-4">
                            <p class="text-emerald-700 font-semibold flex items-center gap-2">
                                <x-filament::icon icon="heroicon-o-user-group" class="h-5 w-5" /> Dealers
                            </p>
                            <p class="mt-2 text-2xl font-bold text-emerald-900">{{ number_format($activeDealers) }}</p>
                            <p class="text-xs text-emerald-700/70">Active accounts</p>
                        </div>
                        <div class="rounded-2xl border border-sky-100 bg-sky-50 p-4">
                            <p class="text-sky-700 font-semibold flex items-center gap-2">
                                <x-filament::icon icon="heroicon-o-building-office" class="h-5 w-5" /> Distributors
                            </p>
                            <p class="mt-2 text-2xl font-bold text-sky-900">{{ number_format($activeDistributors) }}</p>
                            <p class="text-xs text-sky-700/70">Active accounts</p>
                        </div>
                        <div class="rounded-2xl border border-purple-100 bg-purple-50 p-4">
                            <p class="text-purple-700 font-semibold flex items-center gap-2">
                                <x-filament::icon icon="heroicon-o-shield-check" class="h-5 w-5" /> Admins
                            </p>
                            <p class="mt-2 text-2xl font-bold text-purple-900">{{ number_format($activeAdmins) }}</p>
                            <p class="text-xs text-purple-700/70">Active admins</p>
                        </div>
                        <div class="rounded-2xl border border-amber-100 bg-amber-50 p-4">
                            <p class="text-amber-700 font-semibold flex items-center gap-2">
                                <x-filament::icon icon="heroicon-o-sparkles" class="h-5 w-5" /> New this week
                            </p>
                            <p class="mt-2 text-2xl font-bold text-amber-900">{{ number_format($newUsersThisWeek) }}</p>
                            <p class="text-xs text-amber-700/70">Across all roles</p>
                        </div>
                    </div>
                </div>

                <div class="profile-card p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold">Inventory Health</h3>
                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-emerald-700">Products</span>
                    </div>
                    <div class="mt-6 grid gap-6 md:grid-cols-2">
                        <div class="space-y-4">
                            <p class="profile-section-title">Stock Breakdown</p>
                            <div class="space-y-3 text-sm">
                                <div class="flex items-center justify-between">
                                    <span class="flex items-center gap-2 text-gray-600">
                                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                        Above alert level
                                    </span>
                                    <span class="font-semibold text-emerald-700">{{ number_format($healthyStockProducts) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="flex items-center gap-2 text-gray-600">
                                        <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                                        Needs restock soon
                                    </span>
                                    <span class="font-semibold text-amber-600">{{ number_format($lowStockProducts) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="flex items-center gap-2 text-gray-600">
                                        <span class="h-2.5 w-2.5 rounded-full bg-rose-500"></span>
                                        Out of stock
                                    </span>
                                    <span class="font-semibold text-rose-600">{{ number_format(Product::where('current_stock', '<=', 0)->count()) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <p class="profile-section-title">Highlights</p>
                            <div class="rounded-2xl bg-emerald-50 p-4">
                                <h4 class="text-emerald-800 font-semibold">Keep the momentum</h4>
                                <p class="mt-2 text-sm text-emerald-700/80">Encourage distributors to replenish low stock items and reward dealers maintaining healthy stock levels.</p>
                            </div>
                            <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-emerald-100/70">
                                <p class="text-sm text-gray-600">See full inventory insights in the <strong>Products</strong> section.</p>
                                @if (Illuminate\Support\Facades\Route::has($productsIndexRoute))
                                    <a href="{{ filament()->getPanel()->route('resources.products.index') }}" class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-emerald-600">
                                        Manage products
                                        <x-filament::icon icon="heroicon-o-arrow-up-right" class="h-4 w-4" />
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            <aside class="space-y-6">
                <div class="profile-card p-6">
                    <div class="flex items-center gap-4">
                        <x-filament::avatar :user="$authUser" class="h-14 w-14" />
                        <div>
                            <h3 class="text-lg font-semibold">{{ $authUser?->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $authUser?->email }}</p>
                            <span class="mt-1 inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                <x-filament::icon icon="heroicon-o-shield-check" class="h-4 w-4" />
                                {{ $authUser?->user_type ?? 'Admin' }}
                            </span>
                        </div>
                    </div>
                    <dl class="mt-6 space-y-3 text-sm text-gray-600">
                        <div class="flex items-center justify-between">
                            <dt>Employee ID</dt>
                            <dd class="font-semibold text-gray-900">{{ $authUser?->employee_id ?? '—' }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt>Status</dt>
                            <dd class="inline-flex items-center gap-2 font-semibold text-emerald-600">
                                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                {{ $authUser?->status ?? 'Active' }}
                            </dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt>Joined</dt>
                            <dd class="font-semibold text-gray-900">{{ optional($authUser?->created_at)->format('d M Y') ?? '—' }}</dd>
                        </div>
                    </dl>
                        <a href="{{ filament()->getPanel()->route('auth.profile') }}" class="mt-6 inline-flex items-center gap-2 rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700">
                        Edit profile
                        <x-filament::icon icon="heroicon-o-pencil-square" class="h-4 w-4" />
                    </a>
                </div>

                <div class="profile-card p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                    <div class="mt-4 grid gap-3">
                        @if (Illuminate\Support\Facades\Route::has($usersCreateRoute))
                            <a href="{{ filament()->getPanel()->route('resources.users.create') }}" class="flex items-center gap-3 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100">
                                <x-filament::icon icon="heroicon-o-user-plus" class="h-5 w-5" />
                                Add new user
                            </a>
                        @endif
                        @if (Illuminate\Support\Facades\Route::has($productsIndexRoute))
                            <a href="{{ filament()->getPanel()->route('resources.products.index') }}" class="flex items-center gap-3 rounded-xl border border-sky-100 bg-sky-50 px-4 py-3 text-sm font-semibold text-sky-700 transition hover:bg-sky-100">
                                <x-filament::icon icon="heroicon-o-archive-box" class="h-5 w-5" />
                                Review products
                            </a>
                        @endif
                        @if (Illuminate\Support\Facades\Route::has($usersIndexRoute))
                            <a href="{{ filament()->getPanel()->route('resources.users.index') }}" class="flex items-center gap-3 rounded-xl border border-purple-100 bg-purple-50 px-4 py-3 text-sm font-semibold text-purple-700 transition hover:bg-purple-100">
                                <x-filament::icon icon="heroicon-o-chart-bar-square" class="h-5 w-5" />
                                View user analytics
                            </a>
                        @endif
                    </div>
                </div>
            </aside>
        </section>
    </div>
</x-filament-panels::page>
