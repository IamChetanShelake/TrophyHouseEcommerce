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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id')->nullable();
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->decimal('quantity', 10, 2)->nullable();
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->decimal('total_cost', 10, 2)->nullable();
            $table->string('supplier_name')->nullable();
            $table->integer('supplier_contact')->nullable();
            $table->date('purchase_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
