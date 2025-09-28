@php
    $dashboardActive = request()->routeIs('admin.dashboard');
    $usersActive = request()->routeIs('admin.users.*');
    $productsActive = request()->routeIs('admin.products.*');
    $purchasesActive = request()->routeIs('admin.purchases.*');
@endphp
<div class="iq-sidebar">
    <div class="iq-sidebar-logo d-flex justify-content-between">
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/logo.png') }}" class="img-fluid" alt="Rewarity logo">
        </a>
        <div class="iq-menu-bt align-self-center">
            <div class="wrapper-menu">
                <div class="line-menu half start"></div>
                <div class="line-menu"></div>
                <div class="line-menu half end"></div>
            </div>
        </div>
    </div>
    <div id="sidebar-scrollbar">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                <li class="iq-menu-title"><i class="ri-separator"></i><span>Main</span></li>
                <li class="{{ $dashboardActive ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="iq-waves-effect {{ $dashboardActive ? 'active' : '' }}">
                        <i class="ri-home-4-line"></i><span>Dashboard</span>
                    </a>
                </li>

                <li class="iq-menu-title"><i class="ri-separator"></i><span>Management</span></li>
                <li class="{{ $usersActive ? 'active' : '' }}">
                    <a href="#user-info" class="iq-waves-effect {{ $usersActive ? '' : 'collapsed' }}" data-toggle="collapse" aria-expanded="{{ $usersActive ? 'true' : 'false' }}"><i class="ri-user-line"></i><span>User</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                    <ul id="user-info" class="iq-submenu collapse {{ $usersActive ? 'show' : '' }}" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}"><a href="{{ route('admin.users.index') }}">User List</a></li>
                        <li class="{{ request()->routeIs('admin.users.create') ? 'active' : '' }}"><a href="{{ route('admin.users.create') }}">User Add</a></li>
                    </ul>
                </li>
                <li class="{{ $productsActive ? 'active' : '' }}">
                    <a href="#products" class="iq-waves-effect {{ $productsActive ? '' : 'collapsed' }}" data-toggle="collapse" aria-expanded="{{ $productsActive ? 'true' : 'false' }}"><i class="ri-shopping-bag-line"></i><span>Products</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                    <ul id="products" class="iq-submenu collapse {{ $productsActive ? 'show' : '' }}" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('admin.products.index') ? 'active' : '' }}"><a href="{{ route('admin.products.index') }}">All Products</a></li>
                        <li class="{{ request()->routeIs('admin.products.create') ? 'active' : '' }}"><a href="{{ route('admin.products.create') }}">Add Product</a></li>
                    </ul>
                </li>
                <li class="{{ $purchasesActive ? 'active' : '' }}">
                    <a href="#purchases" class="iq-waves-effect {{ $purchasesActive ? '' : 'collapsed' }}" data-toggle="collapse" aria-expanded="{{ $purchasesActive ? 'true' : 'false' }}"><i class="ri-table-line"></i><span>Purchases</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                    <ul id="purchases" class="iq-submenu collapse {{ $purchasesActive ? 'show' : '' }}" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('admin.purchases.index') ? 'active' : '' }}"><a href="{{ route('admin.purchases.index') }}">Purchase List</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
