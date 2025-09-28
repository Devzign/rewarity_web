@extends('admin.layouts.guest')

@section('title', 'Admin Login')

@section('content')
<section class="sign-in-page">
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <img src="{{ asset('images/logo.png') }}" alt="Rewarity logo" class="img-fluid" style="max-height: 60px;">
                            <h3 class="mt-3 mb-0">Admin Portal</h3>
                            <p class="text-muted">Sign in to manage Rewarity</p>
                        </div>

                        @include('admin.partials.flash')

                        <form method="POST" action="{{ route('admin.login.attempt') }}" novalidate>
                            @csrf

                            <div class="form-group">
                                <label for="email" class="text-muted small text-uppercase">Email address</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="password" class="text-muted small text-uppercase d-flex justify-content-between align-items-center">
                                    <span>Password</span>
                                    <a href="#" class="text-muted">Forgot?</a>
                                </label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">Keep me signed in</label>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                        </form>
                    </div>
                </div>
                <p class="text-center text-muted small mt-3">&copy; {{ now()->year }} Rewarity. All rights reserved.</p>
            </div>
        </div>
    </div>
</section>
@endsection
