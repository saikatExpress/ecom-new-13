<?php

use App\Enums\DiscountTypeEnum;
use App\Enums\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete()->cascadeOnUpdate();

            $table->string('sku')->unique()->nullable();
            $table->decimal('buy_price', 10, 2)->nullable();
            $table->decimal('mrp', 10, 2);
            $table->decimal('sell_price', 10, 2);

            $table->string('discount_type')->default(DiscountTypeEnum::FIXED->value);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('offer_price', 10, 2)->nullable();

            $table->integer('current_stock')->default(0);
            $table->integer('total_sell_quantity')->default(0);

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
