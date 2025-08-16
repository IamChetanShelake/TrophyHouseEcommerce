<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payment_items', function (Blueprint $table) {
            // Ensure each item belongs to a payment
            if (!Schema::hasColumn('payment_items', 'payment_id')) {
                $table->foreignId('payment_id')->constrained('payments')->cascadeOnDelete();
            }

            // Product variant link
            if (!Schema::hasColumn('payment_items', 'product_variant_id')) {
                $table->foreignId('product_variant_id')->nullable()
                      ->constrained('product_variants')->nullOnDelete();
            }

            // Customization request link
            if (!Schema::hasColumn('payment_items', 'customization_request_id')) {
                $table->foreignId('customization_request_id')->nullable()
                      ->constrained('customization_requests')->nullOnDelete();
            }

            // Customization status (quick access)
            if (!Schema::hasColumn('payment_items', 'customization_status')) {
                $table->enum('customization_status', [
                    'not_applicable',
                    'pending',
                    'in_progress',
                    'completed',
                    'ready_to_pickup',
                    'delivered'
                ])->default('not_applicable');
            }

            // Assigned designer
            if (!Schema::hasColumn('payment_items', 'designer_id')) {
                $table->foreignId('designer_id')->nullable()
                      ->constrained('users')->nullOnDelete();
            }

            // Delivery status
            if (!Schema::hasColumn('payment_items', 'delivery_status')) {
                $table->enum('delivery_status', ['pending', 'ready_to_pickup', 'delivered'])
                      ->default('pending');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payment_items', function (Blueprint $table) {
            if (Schema::hasColumn('payment_items', 'delivery_status')) $table->dropColumn('delivery_status');
            if (Schema::hasColumn('payment_items', 'designer_id')) $table->dropConstrainedForeignId('designer_id');
            if (Schema::hasColumn('payment_items', 'customization_status')) $table->dropColumn('customization_status');
            if (Schema::hasColumn('payment_items', 'customization_request_id')) $table->dropConstrainedForeignId('customization_request_id');
            if (Schema::hasColumn('payment_items', 'product_variant_id')) $table->dropConstrainedForeignId('product_variant_id');
            if (Schema::hasColumn('payment_items', 'payment_id')) $table->dropConstrainedForeignId('payment_id');
        });
    }
};
