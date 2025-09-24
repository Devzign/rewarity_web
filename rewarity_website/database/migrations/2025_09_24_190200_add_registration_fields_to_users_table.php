<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('user_uid', 16)->nullable()->unique()->after('id');
            $table->string('employee_id')->nullable()->unique()->after('user_uid');
            $table->string('user_type')->nullable()->after('email');
            $table->string('status')->default('Active')->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn(['user_uid', 'employee_id', 'user_type', 'status']);
        });
    }
};
