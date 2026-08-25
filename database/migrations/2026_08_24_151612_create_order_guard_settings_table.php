<?php

use App\Enums\StatusEnum;
use App\Enums\TimeUnitEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_guard_settings', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('phone_order_limit')->default(2);
            $table->unsignedInteger('phone_order_period_value')->default(1);
            $table->string('phone_order_period_unit')->default(TimeUnitEnum::DAY);

            $table->unsignedInteger('ip_order_limit')->default(5);
            $table->unsignedInteger('ip_order_period_value')->default(1);
            $table->string('ip_order_period_unit')->default(TimeUnitEnum::HOUR);

            $table->unsignedInteger('user_token_order_limit')->default(4);
            $table->unsignedInteger('user_token_order_period_value')->default(1);
            $table->string('user_token_order_period_unit')->default(TimeUnitEnum::HOUR);

            $table->boolean('auto_block_enabled')->default(true);
            $table->unsignedInteger('block_after_attempts')->nullable();

            $table->unsignedInteger('block_duration_value')->nullable();
            $table->string('block_duration_unit')->nullable();

            $table->string('block_message')->nullable();

            $table->string('status')->default(StatusEnum::ACTIVE);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_guard_settings');
    }
};
