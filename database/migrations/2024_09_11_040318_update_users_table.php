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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->foreignId('disabled_by')->nullable()->constrained('users');
            $table->foreignId('rejected_by')->nullable()->constrained('users');
            $table->string('username')->unique()->after('name');
            $table->string('role')->after('password');
            $table->boolean('is_active_now')->default(false)->after('role');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamp('disabled_at')->nullable();
            $table->string('email_verified_at', 100)->nullable()->default(null)->after('is_active_now')->change();
            $table->string('remember_token', 100)->nullable()->default(null)->after('email_verified_at')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['approved_by']);
            $table->dropForeign(['deleted_by']);
            $table->dropForeign(['disabled_by']);
            $table->dropForeign(['rejected_by']);
            $table->dropColumn([
                'created_by',
                'approved_by',
                'deleted_by',
                'disabled_by',
                'rejected_by',
                'username',
                'role',
                'is_active_now',
                'approved_at',
                'rejected_at',
                'disabled_at'
            ]);
            $table->string('email_verified_at')->nullable(false)->default(null)->change();
            $table->string('remember_token')->nullable(false)->default(null)->change();
        });
    }
};
