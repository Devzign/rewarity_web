<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('admin:create', function (): int {
    $name = trim((string) $this->ask('Admin name'));
    $email = strtolower(trim((string) $this->ask('Admin email')));

    if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->error('A valid email address is required.');

        return self::FAILURE;
    }

    if (User::where('email', $email)->exists()) {
        $this->error("A user with email {$email} already exists.");

        return self::FAILURE;
    }

    $password = (string) $this->secret('Password (min. 8 characters)');

    if (strlen($password) < 8) {
        $this->error('Password must be at least 8 characters.');

        return self::FAILURE;
    }

    $confirmPassword = (string) $this->secret('Confirm password');

    if ($password !== $confirmPassword) {
        $this->error('Password confirmation does not match.');

        return self::FAILURE;
    }

    do {
        $userUid = Str::upper(Str::random(10));
    } while (User::where('user_uid', $userUid)->exists());

    $user = User::create([
        'name' => $name ?: 'Administrator',
        'email' => $email,
        'password' => Hash::make($password),
        'user_uid' => $userUid,
        'user_type' => 'Admin',
        'status' => 'Active',
    ]);

    $this->info("Admin user created successfully (ID: {$user->id}).");

    return self::SUCCESS;
})->purpose('Interactively create an Admin user for the control panel');
