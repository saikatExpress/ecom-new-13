<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            $table->string('group_name')->index();
            $table->string('setting_key')->unique();
            $table->string('label')->unique();
            $table->json('value')->nullable();

            $table->string('type')->default('string');
            $table->text('description')->nullable();
            $table->boolean('autoload')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
