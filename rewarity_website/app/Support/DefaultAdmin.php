<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Throwable;

class DefaultAdmin
{
    /**
     * Ensure the default administrator account exists and has required attributes.
     */
    public static function ensure(): void
    {
        try {
            // Abort if the users table is not ready yet (e.g. before migrations run).
            if (! Schema::hasTable('users')) {
                return;
            }

            $config = (array) config('admin');

            $email = strtolower(trim((string) data_get($config, 'default_admin.email', 'admin@rewarity.com')));

            if ($email === '') {
                return;
            }

            $name = (string) data_get($config, 'default_admin.name', 'Administrator');
            $password = (string) data_get($config, 'default_admin.password', 'Password123!');
            $forcePasswordSync = filter_var(
                data_get($config, 'force_password_sync', false),
                FILTER_VALIDATE_BOOLEAN
            );

            $admin = User::where('email', $email)->first();

            if (! $admin) {
                User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'user_uid' => self::generateUniqueUserUid(),
                    'user_type' => 'Admin',
                    'status' => 'Active',
                    'email_verified_at' => now(),
                ]);

                return;
            }

            $shouldSave = false;

            if ($forcePasswordSync && ! Hash::check($password, $admin->password)) {
                $admin->password = Hash::make($password);
                $shouldSave = true;
            }

            if (! $admin->user_uid) {
                $admin->user_uid = self::generateUniqueUserUid();
                $shouldSave = true;
            }

            if (strcasecmp((string) $admin->user_type, 'Admin') !== 0) {
                $admin->user_type = 'Admin';
                $shouldSave = true;
            }

            if (strcasecmp((string) $admin->status, 'Active') !== 0) {
                $admin->status = 'Active';
                $shouldSave = true;
            }

            if (! $admin->email_verified_at) {
                $admin->email_verified_at = now();
                $shouldSave = true;
            }

            if ($shouldSave) {
                $admin->save();
            }
        } catch (Throwable $exception) {
            report($exception);
        }
    }

    private static function generateUniqueUserUid(): string
    {
        do {
            $userUid = Str::upper(Str::random(10));
        } while (User::where('user_uid', $userUid)->exists());

        return $userUid;
    }
}
