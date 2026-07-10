<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('phone_number', 20)->index();

            $table->string('purpose', 30)->index();

            $table->string('code_hash');

            $table->unsignedTinyInteger('attempts')->default(0);

            $table->unsignedTinyInteger('max_attempts')->default(5);

            $table->timestamp('expires_at');

            $table->timestamp('sent_at')->nullable();

            $table->timestamp('consumed_at')->nullable();

            $table->ipAddress('ip_address')->nullable();

            $table->text('user_agent')->nullable();

            $table->timestamps();

            $table->index(['phone_number','purpose','consumed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};
