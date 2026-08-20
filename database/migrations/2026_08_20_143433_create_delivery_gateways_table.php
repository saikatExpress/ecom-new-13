<?php

use App\Enums\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->unsignedInteger('min_time')->nullable();
            $table->unsignedInteger('max_time')->nullable();
            $table->string('time_unit')->default('days');
            $table->unsignedInteger('delivery_fee')->default(0);
            $table->unsignedInteger('position')->default(0);
            $table->string('status')->default(StatusEnum::ACTIVE);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_gateways');
    }
};
