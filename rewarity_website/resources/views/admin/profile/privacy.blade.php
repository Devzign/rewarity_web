@extends('admin.layouts.app')

@section('title', 'Privacy Settings')
@section('page_heading', 'Privacy Settings')

@section('content')
@include('admin.profile._tabs', ['user' => $user])

<div class="row">
    <div class="col-lg-8">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Security Controls</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <p class="text-muted">Manage how your information is shared with your organisation.</p>
                <div class="custom-control custom-checkbox custom-control-inline mb-3">
                    <input type="checkbox" class="custom-control-input" id="visibilityEmail" checked>
                    <label class="custom-control-label" for="visibilityEmail">Show my email address to team members</label>
                </div>
                <div class="custom-control custom-checkbox custom-control-inline mb-3">
                    <input type="checkbox" class="custom-control-input" id="visibilityProfile" checked>
                    <label class="custom-control-label" for="visibilityProfile">Allow others to view my full profile</label>
                </div>
                <div class="custom-control custom-checkbox custom-control-inline mb-3">
                    <input type="checkbox" class="custom-control-input" id="visibilityAnalytics">
                    <label class="custom-control-label" for="visibilityAnalytics">Share my activity for analytics</label>
                </div>
                <div class="custom-control custom-checkbox custom-control-inline mb-3">
                    <input type="checkbox" class="custom-control-input" id="visibilityMarketing">
                    <label class="custom-control-label" for="visibilityMarketing">Receive product updates from marketing</label>
                </div>
                <hr>
                <h5 class="mb-3">Two-factor authentication</h5>
                <p class="text-muted">Add an extra layer of security to your account by enabling two-factor authentication.</p>
                <button class="btn btn-outline-primary" type="button">Enable 2FA</button>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Active Sessions</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <p class="text-muted">You’re logged in on these devices.</p>
                <div class="media align-items-center mb-3">
                    <div class="rounded iq-card-icon iq-bg-primary mr-3"><i class="ri-macbook-line"></i></div>
                    <div class="media-body">
                        <h6 class="mb-0">MacOS · Chrome</h6>
                        <small class="text-muted">127.0.0.1 · Active now</small>
                    </div>
                </div>
                <div class="media align-items-center mb-3">
                    <div class="rounded iq-card-icon iq-bg-warning mr-3"><i class="ri-smartphone-line"></i></div>
                    <div class="media-body">
                        <h6 class="mb-0">iOS · Safari</h6>
                        <small class="text-muted">Last active 2 days ago</small>
                    </div>
                    <button class="btn btn-outline-danger btn-sm" type="button">Sign out</button>
                </div>
                <div class="media align-items-center">
                    <div class="rounded iq-card-icon iq-bg-info mr-3"><i class="ri-windows-line"></i></div>
                    <div class="media-body">
                        <h6 class="mb-0">Windows · Edge</h6>
                        <small class="text-muted">Last active 1 week ago</small>
                    </div>
                    <button class="btn btn-outline-danger btn-sm" type="button">Sign out</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
