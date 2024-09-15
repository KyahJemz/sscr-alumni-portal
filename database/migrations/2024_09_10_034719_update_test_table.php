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
        Schema::table('test_models', function (Blueprint $table) {
            $table->string('title')->nullable()->after('id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_models', function (Blueprint $table) {
            $table->string('title')->nullable()->after('updated_at')->change();
        });
    }
};