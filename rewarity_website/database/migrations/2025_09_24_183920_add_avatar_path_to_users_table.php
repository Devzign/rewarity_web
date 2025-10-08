<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $afterColumn = Schema::hasColumn('users', 'status') ? 'status' : 'password';

        Schema::table('users', function (Blueprint $table) use ($afterColumn): void {
            $table->string('avatar_path')->nullable()->after($afterColumn);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn('avatar_path');
        });
    }
};
