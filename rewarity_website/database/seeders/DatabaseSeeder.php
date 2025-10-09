<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $adminEmail = strtolower((string) env('DEFAULT_ADMIN_EMAIL', 'admin@rewarity.com'));
        $adminName = (string) env('DEFAULT_ADMIN_NAME', 'Administrator');
        $adminPassword = (string) env('DEFAULT_ADMIN_PASSWORD', 'Password123!');

        $admin = User::where('email', $adminEmail)->first();

        if (! $admin) {
            do {
                $userUid = Str::upper(Str::random(10));
            } while (User::where('user_uid', $userUid)->exists());

            User::create([
                'name' => $adminName,
                'email' => $adminEmail,
                'password' => Hash::make($adminPassword),
                'user_uid' => $userUid,
                'user_type' => 'Admin',
                'status' => 'Active',
                'email_verified_at' => now(),
            ]);

            return;
        }

        $shouldUpdate = false;

        if (! $admin->user_uid) {
            do {
                $userUid = Str::upper(Str::random(10));
            } while (User::where('user_uid', $userUid)->exists());

            $admin->user_uid = $userUid;
            $shouldUpdate = true;
        }

        if (! $admin->user_type) {
            $admin->user_type = 'Admin';
            $shouldUpdate = true;
        }

        if (! $admin->status) {
            $admin->status = 'Active';
            $shouldUpdate = true;
        }

        if (! $admin->email_verified_at) {
            $admin->email_verified_at = now();
            $shouldUpdate = true;
        }

        if ($shouldUpdate) {
            $admin->save();
        }
    }
}
