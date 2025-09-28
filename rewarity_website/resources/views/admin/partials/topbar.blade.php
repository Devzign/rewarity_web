@php($user = auth()->user())
<div class="iq-top-navbar">
    <div class="iq-navbar-custom">
        <div class="iq-sidebar-logo">
            <div class="top-logo d-flex align-items-center">
                <a href="{{ route('admin.dashboard') }}" class="logo d-flex align-items-center">
                    <img src="{{ asset('images/logo.png') }}" class="img-fluid" alt="Rewarity logo">
                </a>
            </div>
        </div>
        <div class="navbar-breadcrumb">
            <h5 class="mb-0">{{ $pageHeading }}</h5>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $pageHeading }}</li>
                </ul>
            </nav>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="ri-menu-3-line"></i>
            </button>
            <div class="iq-menu-bt align-self-center">
                <div class="wrapper-menu">
                    <div class="line-menu half start"></div>
                    <div class="line-menu"></div>
                    <div class="line-menu half end"></div>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto navbar-list">
                    <li class="nav-item">
                        <a class="search-toggle iq-waves-effect" href="#"><i class="ri-search-line"></i></a>
                        <form action="#" class="search-box">
                            <input type="text" class="text search-input" placeholder="Type here to search..." />
                        </form>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="iq-waves-effect"><i class="ri-mail-line"></i><span class="badge badge-pill badge-primary badge-up">3</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="iq-waves-effect"><i class="ri-shopping-cart-2-line"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="search-toggle iq-waves-effect">
                            <i class="ri-notification-2-line"></i>
                            <span class="bg-danger dots"></span>
                        </a>
                    </li>
                    <li class="nav-item iq-full-screen"><a href="#" class="iq-waves-effect" id="btnFullscreen"><i class="ri-fullscreen-line"></i></a></li>
                </ul>
            </div>
            <ul class="navbar-list">
                <li>
                    <a href="#" class="search-toggle iq-waves-effect iq-bg-box text-white">
                        <img src="{{ $user?->avatar_url ?? asset('assets/admin/images/user/1.jpg') }}" class="img-fluid rounded" alt="user">
                    </a>
                    <div class="iq-sub-dropdown iq-user-dropdown">
                        <div class="iq-card shadow-none m-0">
                            <div class="iq-card-body p-0 ">
                                <div class="bg-primary p-3">
                                    <h5 class="mb-0 text-white line-height">Hello {{ $user?->name ?? 'Admin' }}</h5>
                                    <span class="text-white font-size-12">{{ $user?->user_type ?? 'Administrator' }}</span>
                                </div>
                                <a href="{{ route('admin.profile.show') }}" class="iq-sub-card iq-bg-primary-hover">
                                    <div class="media align-items-center">
                                        <div class="rounded iq-card-icon iq-bg-primary"><i class="ri-file-user-line"></i></div>
                                        <div class="media-body ml-3">
                                            <h6 class="mb-0">My Profile</h6>
                                            <p class="mb-0 font-size-12">View personal profile details.</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('admin.profile.edit') }}" class="iq-sub-card iq-bg-primary-success-hover">
                                    <div class="media align-items-center">
                                        <div class="rounded iq-card-icon iq-bg-success"><i class="ri-profile-line"></i></div>
                                        <div class="media-body ml-3">
                                            <h6 class="mb-0">Edit Profile</h6>
                                            <p class="mb-0 font-size-12">Modify your personal details.</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('admin.profile.settings') }}" class="iq-sub-card iq-bg-primary-danger-hover">
                                    <div class="media align-items-center">
                                        <div class="rounded iq-card-icon iq-bg-danger"><i class="ri-account-box-line"></i></div>
                                        <div class="media-body ml-3">
                                            <h6 class="mb-0">Account settings</h6>
                                            <p class="mb-0 font-size-12">Manage your account parameters.</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('admin.profile.privacy') }}" class="iq-sub-card iq-bg-primary-secondary-hover">
                                    <div class="media align-items-center">
                                        <div class="rounded iq-card-icon iq-bg-secondary"><i class="ri-lock-line"></i></div>
                                        <div class="media-body ml-3">
                                            <h6 class="mb-0">Privacy Settings</h6>
                                            <p class="mb-0 font-size-12">Control your privacy parameters.</p>
                                        </div>
                                    </div>
                                </a>
                                <div class="d-inline-block w-100 text-center p-3">
                                    <form method="POST" action="{{ route('admin.logout') }}">
                                        @csrf
                                        <button type="submit" class="iq-bg-danger iq-sign-btn w-100" role="button">Sign out<i class="ri-login-box-line ml-2"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>
