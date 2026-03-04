<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Migrate existing unit text values into the units table
        $existingUnits = DB::table('products')->select('unit')->distinct()->pluck('unit');
        foreach ($existingUnits as $unitName) {
            if ($unitName) {
                DB::table('units')->insert(['name' => $unitName, 'created_at' => now(), 'updated_at' => now()]);
            }
        }

        // Add unit_id FK to products
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('unit_id')->nullable()->after('category_id')->constrained()->nullOnDelete();
        });

        // Link existing products to their unit records
        $units = DB::table('units')->pluck('id', 'name');
        foreach ($units as $name => $id) {
            DB::table('products')->where('unit', $name)->update(['unit_id' => $id]);
        }

        // Drop old text column
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('unit');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('unit')->default('pcs')->after('category_id');
        });

        // Restore unit text from unit_id
        $units = DB::table('units')->pluck('name', 'id');
        foreach ($units as $id => $name) {
            DB::table('products')->where('unit_id', $id)->update(['unit' => $name]);
        }

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropColumn('unit_id');
        });

        Schema::dropIfExists('units');
    }
};
