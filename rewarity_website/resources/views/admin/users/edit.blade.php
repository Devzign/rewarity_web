@extends('admin.layouts.app')

@section('title', 'Edit User')
@section('page_heading', 'Edit User')

@section('content')
<form method="POST" action="{{ route('admin.users.update', $user) }}">
    @csrf
    @method('PUT')
    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
        <div class="iq-card-header d-flex justify-content-between align-items-center">
            <div class="iq-header-title">
                <h4 class="card-title mb-0">Update user</h4>
            </div>
            <div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
                <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
            </div>
        </div>
        <div class="iq-card-body">
            @include('admin.users._form', ['user' => $user, 'userTypes' => $userTypes, 'statuses' => $statuses, 'isEdit' => true])
        </div>
    </div>
</form>
@endsection
