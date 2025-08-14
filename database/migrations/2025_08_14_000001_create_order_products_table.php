<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id'); // Foreign key to orders table
            $table->unsignedBigInteger('payment_id'); // Foreign key to payments table
            $table->unsignedBigInteger('variant_id'); // Foreign key to product_variants table
            $table->decimal('unit_price', 10, 2); // Unit price (discounted_price of variant)
            $table->integer('quantity'); // Quantity of the product
            $table->enum('status', ['pending', 'approved', 'completed', 'delivered'])->default('pending');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            
            // Indexes for better performance
            $table->index(['order_id', 'status']);
            $table->index('payment_id');
            $table->index('variant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        Schema::dropIfExists('order_products');
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
