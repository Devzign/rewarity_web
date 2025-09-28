@extends('admin.layouts.app')

@section('title', 'Add User')
@section('page_heading', 'Add User')

@section('content')
<form method="POST" action="{{ route('admin.users.store') }}">
    @csrf
    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
        <div class="iq-card-header d-flex justify-content-between align-items-center">
            <div class="iq-header-title">
                <h4 class="card-title mb-0">Create a new user</h4>
            </div>
            <div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm">Save</button>
            </div>
        </div>
        <div class="iq-card-body">
            @include('admin.users._form', ['user' => $user, 'userTypes' => $userTypes, 'statuses' => $statuses, 'isEdit' => false])
        </div>
    </div>
</form>
@endsection
