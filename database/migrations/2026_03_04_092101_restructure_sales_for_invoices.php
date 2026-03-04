<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn(['product_id', 'quantity', 'sell_price']);

            $table->string('invoice_no')->unique()->after('id');
            $table->decimal('subtotal', 12, 2)->default(0)->after('customer_name');
            $table->decimal('discount', 12, 2)->default(0)->after('subtotal');
            $table->decimal('paid_amount', 12, 2)->default(0)->after('total_price');
            $table->decimal('due_amount', 12, 2)->default(0)->after('paid_amount');
        });

        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('sell_price', 10, 2);
            $table->decimal('total', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_items');

        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['invoice_no', 'subtotal', 'discount', 'paid_amount', 'due_amount']);

            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('sell_price', 10, 2);
        });
    }
};
