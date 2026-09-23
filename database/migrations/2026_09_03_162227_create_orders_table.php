<?php

use App\Enums\StatusEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Foreign ID Section
            $table->foreignId('status_id')->constrained('statuses')->onDelete('cascade');
            $table->foreignId('customer_type_id')->nullable()->nullOnDelete()->constrained('customer_types');
            $table->foreignId('order_source_id')->nullable()->nullOnDelete()->constrained('order_sources');
            $table->foreignId('delivery_gateway_id')->nullable()->nullOnDelete()->constrained('delivery_gateways');
            $table->foreignId('payment_gateway_id')->nullable()->nullOnDelete()->constrained('payment_gateways');
            $table->foreignId('coupon_id')->nullable()->nullOnDelete()->constrained('coupons');
            $table->foreignId('cancel_reason_id')->nullable()->constrained('cancel_reasons')->nullOnDelete();
            $table->foreignId('assign_user_id')->nullable()->constrained('users');
            $table->foreignId('prepared_by')->nullable()->constrained('users');
            $table->foreignId('locked_by_id')->nullable()->constrained('users');
            $table->foreignId('district_id')->nullable()->constrained('districts')->nullOnDelete();
            // Foreign ID Section

            // Order Section
            $table->string('utm_source')->nullable();
            $table->uuid('idempotency_key')->unique();
            $table->string('invoice_number', 150)->unique();
            $table->string('ip_address')->nullable();
            $table->boolean('is_duplicate')->default(false);
            $table->string('note', 1024)->nullable();
            $table->timestamp('order_date');
            $table->timestamp('prepared_at')->nullable();
            $table->timestamp('locked_at')->nullable();
            // Order Section

            // Customer Section
            $table->string('customer_name');
            $table->string('phone_number');
            $table->string('shipping_address', 5000);
            // Customer Section

            // Price Section
            $table->decimal('buy_price', 20, 2)->default(0)->comment('This Total Sum of buy price for order items');
            $table->decimal('mrp', 20, 2)->default(0)->comment('This Total Sum of mrp price for order items');
            $table->decimal('discount', 20, 2)->default(0)->comment('This Total Sum of Discount value for order items discount');
            $table->decimal('sell_price', 20, 2)->default(0)->comment('This Total Sum of Sell price for order items');
            $table->decimal('additional_cost', 8, 2)->default(0)->comment("Like marketing, facebook cost");
            $table->decimal('net_order_amount', 10,2)->default(0.00)->comment('This is for store total order amount without any discount');
            $table->decimal('advanced_payment', 10,2)->default(0.00)->comment('Customer Advanced Payment');
            $table->decimal('special_discount', 10,2)->default(0.00)->comment('Give this amount for an order');
            $table->decimal('coupon_discount', 10,2)->default(0.00);
            $table->decimal('delivery_charge', 10,2)->default(0.00);
            $table->decimal('total_payable_amount', 10,2)->default(0.00)->comment("This is the final price after all sum & deductions");
            $table->decimal('due', 20, 2)->default(0);
            // Price Section

            // Courier Section
            $table->foreignId('courier_id')->nullable()->nullOnDelete()->constrained('couriers');
            $table->unsignedBigInteger('pickup_store_id')->nullable();
            $table->integer('delivery_type')->default(48)->comment('48 for normal 12 for on need for pathao');
            $table->string('courier_status')->nullable();
            $table->string('consignment_id')->nullable()->comment('Come from courier');
            $table->string('tracking_code')->nullable()->comment('Come from steadfast or pathao');
            $table->decimal('item_weight', 8, 2)->nullable()->comment('This field needed for courier');
            $table->json('callback_response')->nullable()->comment("Courier callback response");
            // Courier Section

            // Status Section
            $table->string('paid_status')->default(StatusEnum::UNPAID)->comment('Use enum paid,unpaid');
            $table->string('status')->default(StatusEnum::ACTIVE)->comment('Status enums are active,inactive,draft');
            // Status Section

            $table->userstamps();
            $table->softDeletes();
            $table->timestamps();

            // Index Section
            $table->index('phone_number');
            $table->index('order_date');
            $table->index(['status_id', 'order_date']);
            $table->index('paid_status');
            $table->index(['assign_user_id', 'order_date']);
            $table->index(['prepared_by', 'order_date']);
            $table->index('courier_status');
            $table->index('consignment_id');
            $table->index('tracking_code');
            $table->index('is_duplicate');
            $table->index('district_id');
            $table->index('customer_type_id');
            $table->index('delivery_gateway_id');
            $table->index('payment_gateway_id');
            // Index Section
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
