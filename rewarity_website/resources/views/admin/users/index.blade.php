@extends('admin.layouts.app')

@section('title', 'Users')
@section('page_heading', 'Users')

@section('content')
<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
    <div class="iq-card-header d-flex flex-wrap justify-content-between align-items-center">
        <div class="iq-header-title">
            <h4 class="card-title mb-0">Team Directory</h4>
        </div>
        <div class="d-flex align-items-center">
            <form method="GET" class="form-inline" action="{{ route('admin.users.index') }}">
                <div class="input-group input-group-sm mr-2">
                    <input type="text" name="search" class="form-control" placeholder="Search users..." value="{{ $search }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit"><i class="ri-search-line"></i></button>
                    </div>
                </div>
            </form>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm"><i class="ri-user-add-line mr-1"></i>Add User</a>
        </div>
    </div>
    <div class="iq-card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-light">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th class="text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->user_type ?? '—' }}</td>
                        <td>
                            <span class="badge badge-{{ strtolower($user->status) === 'active' ? 'success' : (strtolower($user->status) === 'suspended' ? 'warning' : 'secondary') }}">{{ $user->status }}</span>
                        </td>
                        <td>{{ $user->created_at?->format('d M Y') }}</td>
                        <td class="text-right">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-secondary btn-sm">View</a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No users found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-end">
            {{ $users->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
