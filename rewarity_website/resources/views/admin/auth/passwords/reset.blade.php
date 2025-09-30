@extends('admin.layouts.guest')

@section('title', 'Reset Password')

@section('content')
<section class="sign-in-page">
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <img src="{{ asset('images/logo.png') }}" alt="Rewarity logo" class="img-fluid" style="max-height: 60px;">
                            <h3 class="mt-3 mb-0">Reset your password</h3>
                            <p class="text-muted">Choose a new password to continue.</p>
                        </div>

                        @include('admin.partials.flash')

                        <form method="POST" action="{{ route('password.update') }}" novalidate>
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <label for="email" class="text-muted small text-uppercase">Email address</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $email) }}" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="password" class="text-muted small text-uppercase">New password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation" class="text-muted small text-uppercase">Confirm password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Reset password</button>
                        </form>

                        <div class="text-center mt-4">
                            <a href="{{ route('admin.login') }}" class="text-muted">Back to sign in</a>
                        </div>
                    </div>
                </div>
                <p class="text-center text-muted small mt-3">&copy; {{ now()->year }} Rewarity. All rights reserved.</p>
            </div>
        </div>
    </div>
</section>
@endsection
