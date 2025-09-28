<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();

        /** @var LengthAwarePaginator $users */
        $users = User::query()
            ->when($search, function (Builder $query) use ($search): void {
                $query->where(function (Builder $subQuery) use ($search): void {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('employee_id', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'search' => $search,
            'pageHeading' => 'Users',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.users.create', [
            'user' => new User(),
            'userTypes' => $this->userTypes(),
            'statuses' => $this->statuses(),
            'pageHeading' => 'Add User',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'employee_id' => ['nullable', 'string', 'max:100', 'unique:users,employee_id'],
            'user_type' => ['required', Rule::in($this->userTypes())],
            'status' => ['required', Rule::in($this->statuses())],
        ]);

        $user = new User($data);
        $user->password = Hash::make($data['password']);
        $user->user_uid = $this->generateUserUid();
        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        $user->loadMissing(['address', 'mobileNumbers'])->loadCount(['products', 'purchases']);

        return view('admin.users.show', [
            'user' => $user,
            'pageHeading' => 'User Details',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
            'userTypes' => $this->userTypes(),
            'statuses' => $this->statuses(),
            'pageHeading' => 'Edit User',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'employee_id' => ['nullable', 'string', 'max:100', Rule::unique('users', 'employee_id')->ignore($user->id)],
            'user_type' => ['required', Rule::in($this->userTypes())],
            'status' => ['required', Rule::in($this->statuses())],
        ]);

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->fill(collect($data)->except('password')->toArray());

        if (! $user->user_uid) {
            $user->user_uid = $this->generateUserUid();
        }
        $user->save();

        return redirect()
            ->route('admin.users.edit', $user)
            ->with('status', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if (Auth::id() === $user->id) {
            return redirect()
                ->route('admin.users.index')
                ->withErrors('You cannot delete your own account.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'User deleted successfully.');
    }

    /**
     * @return array<int, string>
     */
    private function userTypes(): array
    {
        return ['Admin', 'Dealer', 'Distributor'];
    }

    /**
     * @return array<int, string>
     */
    private function statuses(): array
    {
        return ['Active', 'Inactive', 'Suspended'];
    }

    private function generateUserUid(): string
    {
        do {
            $uid = Str::upper(Str::random(10));
        } while (User::where('user_uid', $uid)->exists());

        return $uid;
    }
}
