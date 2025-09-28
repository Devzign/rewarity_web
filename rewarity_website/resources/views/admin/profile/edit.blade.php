@extends('admin.layouts.app')

@section('title', 'Edit Profile')
@section('page_heading', 'Edit Profile')

@section('content')
@include('admin.profile._tabs', ['user' => $user])

<div class="row">
    <div class="col-lg-8">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between align-items-center">
                <div class="iq-header-title">
                    <h4 class="card-title">Personal Information</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-row">
                        <div class="form-group col-12 mb-4 d-flex align-items-center">
                            <div class="mr-3">
                                <img src="{{ $user?->avatar_url ?? asset('assets/admin/images/user/1.jpg') }}" alt="avatar" class="img-fluid rounded" style="width:72px;height:72px;object-fit:cover;">
                            </div>
                            <div>
                                <label for="avatar" class="mb-1">Profile Image</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('avatar') is-invalid @enderror" id="avatar" name="avatar" accept="image/*">
                                    <label class="custom-file-label" for="avatar">Choose image</label>
                                </div>
                                <small class="form-text text-muted">JPG or PNG, max 2MB.</small>
                                @error('avatar')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="employee_id">Employee ID</label>
                            <input type="text" class="form-control @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id" value="{{ old('employee_id', $user->employee_id) }}">
                            @error('employee_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="user_type">Role</label>
                            <input type="text" class="form-control @error('user_type') is-invalid @enderror" id="user_type" name="user_type" value="{{ old('user_type', $user->user_type) }}">
                            @error('user_type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="status">Status</label>
                            <select id="status" name="status" class="form-control">
                                @foreach (['Active', 'Inactive', 'Suspended'] as $status)
                                    <option value="{{ $status }}" @selected(old('status', $user->status ?? 'Active') === $status)>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <h5 class="mt-4">Change Password</h5>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Leave blank to keep current">
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-type new password">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between align-items-center">
                <div class="iq-header-title">
                    <h4 class="card-title">Profile Completeness</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <p class="text-muted">Keep your information up to date so team members know how to reach you.</p>
                <div class="progress bg-soft-primary mb-3">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><i class="ri-checkbox-circle-line text-success mr-2"></i>Email verified</li>
                    <li class="mb-2"><i class="ri-checkbox-circle-line text-success mr-2"></i>Name provided</li>
                    <li><i class="ri-close-circle-line text-danger mr-2"></i>Upload profile picture</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
