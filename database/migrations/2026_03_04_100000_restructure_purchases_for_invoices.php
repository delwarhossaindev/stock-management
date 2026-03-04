<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn(['product_id', 'quantity', 'buy_price']);

            $table->string('purchase_no')->nullable()->after('id');
            $table->decimal('subtotal', 12, 2)->default(0)->after('supplier_id');
            $table->decimal('discount', 12, 2)->default(0)->after('subtotal');
            $table->decimal('paid_amount', 12, 2)->default(0)->after('total_price');
            $table->decimal('due_amount', 12, 2)->default(0)->after('paid_amount');
        });

        // Backfill existing rows with unique purchase_no
        $purchases = DB::table('purchases')->orderBy('id')->get();
        foreach ($purchases as $purchase) {
            DB::table('purchases')->where('id', $purchase->id)->update([
                'purchase_no' => 'PUR-' . str_pad($purchase->id, 6, '0', STR_PAD_LEFT),
                'subtotal' => $purchase->total_price,
                'paid_amount' => $purchase->total_price,
                'due_amount' => 0,
            ]);
        }

        // Now make it unique and not nullable
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('purchase_no')->nullable(false)->unique()->change();
        });

        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('buy_price', 10, 2);
            $table->decimal('total', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_items');

        Schema::table('purchases', function (Blueprint $table) {
            $table->dropUnique(['purchase_no']);
            $table->dropColumn(['purchase_no', 'subtotal', 'discount', 'paid_amount', 'due_amount']);
            $table->foreignId('product_id')->after('id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->after('supplier_id');
            $table->decimal('buy_price', 10, 2)->after('quantity');
        });
    }
};
