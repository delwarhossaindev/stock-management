<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('tax_type')->default('percentage')->after('discount');
            $table->decimal('tax_value', 8, 2)->default(0)->after('tax_type');
            $table->decimal('tax_amount', 12, 2)->default(0)->after('tax_value');
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->string('tax_type')->default('percentage')->after('discount');
            $table->decimal('tax_value', 8, 2)->default(0)->after('tax_type');
            $table->decimal('tax_amount', 12, 2)->default(0)->after('tax_value');
        });
    }

    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn(['tax_type', 'tax_value', 'tax_amount']);
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['tax_type', 'tax_value', 'tax_amount']);
        });
    }
};
