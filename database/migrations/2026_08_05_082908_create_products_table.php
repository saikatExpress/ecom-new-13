<?php

use App\Enums\StatusEnum;
use App\Enums\DiscountTypeEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');

            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('sub_category_id')->nullable()->constrained('sub_categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->cascadeOnDelete()->cascadeOnUpdate();

            $table->string('sku')->unique()->nullable();

            $table->decimal('buy_price', 10,2)->nullable();
            $table->decimal('mrp', 10,2);
            $table->decimal('sell_price', 10,2);

            $table->string('discount_type')->default(DiscountTypeEnum::FIXED->value);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('offer_price', 10, 2)->nullable();

            $table->integer('current_stock')->default(0);
            $table->integer('total_sell_quantity')->default(0);

            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();

            $table->string('status')->default(StatusEnum::ACTIVE->value);

            $table->userstamps();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
