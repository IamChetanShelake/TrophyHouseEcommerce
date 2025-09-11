<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Coupon code (e.g., SAVE20)
            $table->enum('type', ['fixed', 'percentage']); // discount type
            $table->decimal('value', 10, 2); // discount value (e.g., 50.00 or 20%)

            $table->decimal('min_order_amount', 10, 2)->nullable(); // minimum order amount to apply
            $table->integer('usage_limit')->nullable(); // how many times coupon can be used
            $table->integer('used_count')->default(0);  // how many times coupon is already used

            // validity period
            $table->dateTime('start_date')->nullable(); // coupon active from
            $table->dateTime('end_date')->nullable();   // coupon valid till

            $table->boolean('is_active')->default(true); // admin can disable coupon anytime
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
