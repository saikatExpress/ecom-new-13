<?php

use App\Enums\StatusEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('sku')->nullable();
            $table->decimal('buy_price', 10, 2)->nullable();
            $table->decimal('mrp', 10, 2);
            $table->decimal('sell_price', 10, 2);
            $table->boolean('is_default')->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('offer_price', 10, 2)->nullable();
            $table->decimal('offer_percentage', 10, 2)->nullable();
            $table->integer('current_stock')->default(0);
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('img_path')->nullable();
            $table->string('status')->default(StatusEnum::ACTIVE->value);
            $table->userstamps();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
