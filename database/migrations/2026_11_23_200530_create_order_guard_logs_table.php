<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_guard_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->string('phone_hash', 64)->nullable();
            $table->string('user_token', 64)->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->enum('action', ['allowed','violated','blocked']);
            $table->string('reason')->nullable();
            $table->unsignedInteger('violation_count')->default(0);
            $table->timestamps();
            $table->index(['phone_hash', 'action', 'created_at']);
            $table->index(['user_token', 'action', 'created_at']);
            $table->index(['ip_address', 'action', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_guard_logs');
    }
};
