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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->text('thumbnail')->nullable();
            $table->string('title');
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['date', 'time', 'created_by', 'images']);
            $table->text('thumbnail')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
        });

        Schema::table('news', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['date', 'time', 'created_by', 'files', 'images']);
            $table->text('thumbnail')->nullable();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->foreignId('announcement_id')->nullable()->constrained('announcements');
            $table->text('content')->nullable()->change();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');

        Schema::table('events', function (Blueprint $table) {
            $table->string('date');
            $table->string('time');
            $table->string('created_by');
            $table->text('images');
            $table->dropColumn(['thumbnail', 'start_date', 'end_date']);
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->string('date');
            $table->string('time');
            $table->string('created_by');
            $table->string('files');
            $table->text('images');
            $table->dropColumn('thumbnail');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['announcement_id']);
            $table->dropColumn('announcement_id');
            $table->text('content')->nullable(false)->change();
        });
    }
};
