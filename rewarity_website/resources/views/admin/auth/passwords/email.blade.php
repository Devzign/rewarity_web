@extends('admin.layouts.guest')

@section('title', 'Forgot Password')

@section('content')
<section class="sign-in-page">
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <img src="{{ asset('images/logo.png') }}" alt="Rewarity logo" class="img-fluid" style="max-height: 60px;">
                            <h3 class="mt-3 mb-0">Forgot your password?</h3>
                            <p class="text-muted">Enter your email to receive a reset link.</p>
                        </div>

                        @include('admin.partials.flash')

                        <form method="POST" action="{{ route('password.email') }}" novalidate>
                            @csrf

                            <div class="form-group">
                                <label for="email" class="text-muted small text-uppercase">Email address</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required autofocus>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Email password reset link</button>
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
