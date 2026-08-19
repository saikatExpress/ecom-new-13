<?php

use App\Enums\StatusEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->unsignedInteger('order_range')->default(0);
            $table->string('status')->default(StatusEnum::ACTIVE->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_types');
    }
};
