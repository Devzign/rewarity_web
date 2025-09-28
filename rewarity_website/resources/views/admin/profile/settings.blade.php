@extends('admin.layouts.app')

@section('title', 'Account Settings')
@section('page_heading', 'Account Settings')

@section('content')
@include('admin.profile._tabs', ['user' => $user])

<div class="row">
    <div class="col-lg-8">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Notifications</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <p class="text-muted">Choose the communications you'd like to receive.</p>
                <div class="custom-control custom-switch custom-switch-color custom-control-inline mb-3">
                    <input type="checkbox" class="custom-control-input bg-primary" id="notifyEmail" checked>
                    <label class="custom-control-label" for="notifyEmail">Email Updates</label>
                </div>
                <div class="custom-control custom-switch custom-switch-color custom-control-inline mb-3">
                    <input type="checkbox" class="custom-control-input bg-success" id="notifyPush" checked>
                    <label class="custom-control-label" for="notifyPush">Push Notifications</label>
                </div>
                <div class="custom-control custom-switch custom-switch-color custom-control-inline mb-3">
                    <input type="checkbox" class="custom-control-input bg-warning" id="notifySms">
                    <label class="custom-control-label" for="notifySms">SMS Alerts</label>
                </div>
                <div class="custom-control custom-switch custom-switch-color custom-control-inline mb-3">
                    <input type="checkbox" class="custom-control-input bg-danger" id="notifyWeekly" checked>
                    <label class="custom-control-label" for="notifyWeekly">Weekly Summary</label>
                </div>
            </div>
        </div>
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Integrations</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="media align-items-center mb-4">
                    <div class="rounded iq-card-icon iq-bg-primary mr-3"><i class="ri-slack-line"></i></div>
                    <div class="media-body">
                        <h6 class="mb-0">Slack</h6>
                        <p class="mb-0 text-muted">Receive team alerts directly in Slack.</p>
                    </div>
                    <span class="badge badge-pill badge-success">Connected</span>
                </div>
                <div class="media align-items-center mb-4">
                    <div class="rounded iq-card-icon iq-bg-warning mr-3"><i class="ri-trello-line"></i></div>
                    <div class="media-body">
                        <h6 class="mb-0">Trello</h6>
                        <p class="mb-0 text-muted">Sync tasks with your Trello boards.</p>
                    </div>
                    <button class="btn btn-outline-primary btn-sm" type="button">Connect</button>
                </div>
                <div class="media align-items-center">
                    <div class="rounded iq-card-icon iq-bg-danger mr-3"><i class="ri-dropbox-line"></i></div>
                    <div class="media-body">
                        <h6 class="mb-0">Dropbox</h6>
                        <p class="mb-0 text-muted">Attach files from Dropbox.</p>
                    </div>
                    <button class="btn btn-outline-primary btn-sm" type="button">Connect</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
