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
       Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete(); 
        // customer placing the order
    $table->string('order_number')->unique(); 
        // something like ORD-2025-0001
    $table->decimal('total_amount', 10, 2)->default(0);
    $table->decimal('gst_amount', 10, 2)->default(0);
    $table->decimal('grand_total', 10, 2)->default(0);
    $table->string('payment_method')->nullable(); 
        // cashfree, COD, etc.
    $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
    $table->enum('order_status', ['pending', 'processing', 'completed', 'cancelled'])
          ->default('pending'); 
        // general overall status (per-item statuses in order_items)

    $table->timestamp('placed_at')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
