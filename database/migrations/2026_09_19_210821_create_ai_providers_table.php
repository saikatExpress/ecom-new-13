<?php

use App\Enums\StatusEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('img_path')->nullable();
            $table->boolean('is_default')->default(0);
            $table->string('status')->default(StatusEnum::ACTIVE);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_providers');
    }
};
