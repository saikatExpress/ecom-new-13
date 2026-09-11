<?php

use App\Enums\StatusEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->string('division_name');
            $table->string('district_name');
            $table->string('status')->default(StatusEnum::ACTIVE);
            $table->timestamps();

            $table->unique(['division_name', 'district_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('districts');
    }
};
