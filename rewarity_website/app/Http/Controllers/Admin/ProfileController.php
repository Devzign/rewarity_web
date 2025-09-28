<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
    {
        /** @var User $user */
        $user = Auth::user();

        $stats = [
            'team_members' => User::count(),
            'products' => Product::count(),
            'purchases' => Purchase::count(),
            'active_dealers' => User::whereRaw('LOWER(user_type) = ?', ['dealer'])->where('status', 'Active')->count(),
        ];

        $recentPurchases = Purchase::with(['product', 'dealer'])->orderByDesc('purchase_date')->limit(5)->get();
        $recentUsers = User::orderByDesc('created_at')->limit(5)->get();

        return view('admin.profile.show', [
            'user' => $user,
            'stats' => $stats,
            'recentPurchases' => $recentPurchases,
            'recentUsers' => $recentUsers,
        ]);
    }

    public function edit(): View
    {
        return view('admin.profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            $data['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->fill(collect($data)->except('password')->toArray());

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()
            ->route('admin.profile.edit')
            ->with('status', 'Profile updated successfully.');
    }

    public function settings(): View
    {
        return view('admin.profile.settings', [
            'user' => Auth::user(),
        ]);
    }

    public function privacy(): View
    {
        return view('admin.profile.privacy', [
            'user' => Auth::user(),
        ]);
    }
}
