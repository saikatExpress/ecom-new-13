<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_guard_blocks', function (Blueprint $table) {
            $table->id();

            $table->enum('type', ['phone','ip','user_token']);
            $table->string('value', 255);
            $table->text('phone_number')->nullable();
            $table->string('reason')->nullable();
            $table->enum('block_type', ['temporary','permanent'])->default('temporary');
            $table->enum('source', ['system','admin'])->default('system');
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index(['type', 'value', 'is_active']);
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_guard_blocks');
    }
};
