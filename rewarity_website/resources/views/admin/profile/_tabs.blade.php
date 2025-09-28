@php
    $routes = [
        'Overview' => route('admin.profile.show'),
        'Edit Profile' => route('admin.profile.edit'),
        'Account Settings' => route('admin.profile.settings'),
        'Privacy' => route('admin.profile.privacy'),
    ];
@endphp

<div class="iq-card mb-4">
    <div class="iq-card-body p-3 p-md-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center">
            <div class="d-flex align-items-center mb-3 mb-md-0">
                <img src="{{ $user?->avatar_url ?? asset('assets/admin/images/user/1.jpg') }}" class="img-fluid rounded-circle mr-3" alt="Avatar" style="width:72px;height:72px;object-fit:cover;">
                <div>
                    <h4 class="mb-0">{{ $user->name }}</h4>
                    <small class="text-muted text-uppercase">{{ $user->user_type ?? 'Administrator' }}</small>
                </div>
            </div>
            <div class="ml-md-auto">
                <ul class="nav nav-pills iq-nav" role="tablist">
                    @foreach ($routes as $label => $url)
                        <li class="nav-item">
                            <a href="{{ $url }}" class="nav-link {{ url()->current() === $url ? 'active' : '' }}">{{ $label }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
