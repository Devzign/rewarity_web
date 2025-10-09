<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Support\DefaultAdmin;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DefaultAdmin::ensure();
    }
}
