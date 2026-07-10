<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('login_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('phone_number')->nullable();

            $table->ipAddress('ip_address');

            $table->text('user_agent')->nullable();

            $table->string('browser')->nullable();

            $table->string('browser_version')->nullable();

            $table->string('platform')->nullable();

            $table->string('platform_version')->nullable();

            $table->string('device')->nullable();

            $table->boolean('success')->default(false);

            $table->string('failure_reason')->nullable();

            $table->timestamp('login_at')->nullable();

            $table->timestamp('logout_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_histories');
    }
};
