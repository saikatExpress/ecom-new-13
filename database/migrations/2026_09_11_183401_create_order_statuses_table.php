<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('status_id')->constrained('statuses')->cascadeOnDelete()->cascadeOnUpdate();

            $table->userstamps();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['order_id', 'created_at']);
            $table->index(['order_id', 'status_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_statuses');
    }
};
