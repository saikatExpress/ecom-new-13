<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();

            // Foreign ID Section
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('product_id')->nullable()->nullOnDelete()->constrained('products')->cascadeOnUpdate();
            $table->foreignId('product_variant_id')->nullable()->nullOnDelete()->constrained('product_variants')->cascadeOnUpdate();
            // Foreign ID Section

            // Product Section
            $table->string('product_name');
            $table->string('product_sku')->nullable();
            $table->string('product_img_path')->nullable();
            // Product Section

            // Variant Snapshot Section
            $table->string('variant_name')->nullable();
            $table->string('variant_sku')->nullable();
            $table->json('variant_options')->nullable();
            // Variant Snapshot Section

            // Quantity Section
            $table->unsignedInteger('quantity')->default(1);
            // Quantity Section

            // Price Section
            $table->decimal('buy_price', 20, 2)->default(0);
            $table->decimal('mrp', 20, 2)->default(0);
            $table->decimal('sell_price', 20, 2)->default(0);
            $table->decimal('discount', 20, 2)->default(0);
            // Price Section

            // Profit Section
            $table->decimal('profit', 20, 2)->default(0)->comment('Total profit for this order detail');
            // Profit Section

            $table->timestamps();

            // Index Section
            $table->index('product_id');
            $table->index('product_variant_id');
            $table->index(['order_id', 'product_id']);
            $table->index(['order_id', 'product_variant_id']);
            // Index Section
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
