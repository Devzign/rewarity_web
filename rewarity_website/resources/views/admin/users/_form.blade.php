@php($isEdit = isset($isEdit) && $isEdit)
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Full name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="employee_id">Employee ID</label>
            <input type="text" name="employee_id" id="employee_id" class="form-control" value="{{ old('employee_id', $user->employee_id) }}" placeholder="Optional">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="user_type">Role</label>
            <select name="user_type" id="user_type" class="form-control" required>
                <option value="">Select role</option>
                @foreach ($userTypes as $type)
                    <option value="{{ $type }}" @selected(old('user_type', $user->user_type) === $type)>{{ $type }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected(old('status', $user->status ?? 'Active') === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="password">Password {{ $isEdit ? '(leave blank to keep current)' : '' }}</label>
            <input type="password" name="password" id="password" class="form-control" {{ $isEdit ? '' : 'required' }}>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="password_confirmation">Confirm password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" {{ $isEdit ? '' : 'required' }}>
        </div>
    </div>
</div>
