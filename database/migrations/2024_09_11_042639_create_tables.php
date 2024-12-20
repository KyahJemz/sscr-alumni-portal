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
            $table->softDeletes();
            $table->text('id_image')->nullable()->default(null)->after('image');
        });

        Schema::create('hobbies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->string('name');
            $table->text('description');
            $table->text('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('thumbnail')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->text('thumbnail')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('location')->nullable();
            $table->text('url')->nullable();
            $table->string('contribution')->default(null)->nullable();
            $table->string('amount')->default(null)->nullable();
            $table->string('status');
            $table->string('title');
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->text('thumbnail')->nullable();
            $table->string('title');
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->nullable()->constrained('groups');
            $table->foreignId('event_id')->nullable()->constrained('events');
            $table->foreignId('news_id')->nullable()->constrained('news');
            $table->foreignId('announcement_id')->nullable()->constrained('announcements');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->foreignId('rejected_by')->nullable()->constrained('users');
            $table->text('content')->nullable();
            $table->text('images')->nullable();
            $table->text('videos')->nullable();
            $table->string('files')->nullable();
            $table->string('type');
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
        });

        Schema::create('admin_informations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->foreignId('disabled_by')->nullable()->constrained('users');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('department')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('disabled_at')->nullable();
        });

        Schema::create('alumni_informations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->foreignId('disabled_by')->nullable()->constrained('users');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('nationality')->nullable();
            $table->string('civil_status')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender')->nullable();
            $table->text('street_address')->nullable();
            $table->string('country')->nullable();
            $table->string('region')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('barangay')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('martial_status')->nullable();
            $table->string('education_level')->nullable();
            $table->string('course');
            $table->date('birth_date')->nullable();
            $table->string('batch');
            $table->string('phone')->nullable();
            $table->string('occupation')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('user_hobbies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hobbies_id')->constrained('hobbies');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('received_by')->constrained('users');
            $table->foreignId('sent_by')->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->text('message')->nullable();
            $table->string('file')->nullable();
            $table->text('image')->nullable();
            $table->timestamp('read_at')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('group_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('groups');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->foreignId('rejected_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->timestamp('is_invited_at')->nullable();
            $table->foreignId('is_invited_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
        });

        Schema::create('group_admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('groups');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('group_chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('groups');
            $table->foreignId('sent_by')->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->text('message');
            $table->string('files')->nullable();
            $table->text('images')->nullable();
            $table->timestamp('read_at')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('group_hobbies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hobbies_id')->constrained('hobbies');
            $table->foreignId('group_id')->constrained('groups');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts');
            $table->foreignId('commented_by')->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->text('content');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->text('feedback');
            $table->integer('rating');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('type');
            $table->text('content');
            $table->string('url')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('liked_by')->constrained('users');
            $table->foreignId('post_id')->constrained('posts');
            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('feedbacks');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('group_hobbies');
        Schema::dropIfExists('group_chats');
        Schema::dropIfExists('group_admins');
        Schema::dropIfExists('group_members');
        Schema::dropIfExists('post_edit_approvals');
        Schema::dropIfExists('chats');
        Schema::dropIfExists('user_hobbies');
        Schema::dropIfExists('alumni_informations');
        Schema::dropIfExists('admin_informations');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('events');
        Schema::dropIfExists('news');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('hobbies');
        Schema::dropIfExists('likes');
    }
};
