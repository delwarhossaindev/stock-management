<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Get or create default roles
        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id')
            ?? DB::table('roles')->insertGetId([
                'name' => 'admin',
                'guard_name' => 'web',
                'is_protected' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        $userRoleId = DB::table('roles')->where('name', 'user')->value('id')
            ?? DB::table('roles')->insertGetId([
                'name' => 'user',
                'guard_name' => 'web',
                'is_protected' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        // Add role_id column only if it doesn't exist (handles partial migration rerun)
        $tableName = Schema::getConnection()->getTablePrefix() . 'users';
        $hasRoleId = collect(DB::select("SHOW COLUMNS FROM `{$tableName}` WHERE Field = 'role_id'"))->isNotEmpty();
        if (!$hasRoleId) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('role_id')->nullable()->after('email');
            });
        }

        // Map existing enum values to role_id (only if role column still exists)
        if (Schema::hasColumn('users', 'role')) {
            DB::table('users')->where('role', 'admin')->update(['role_id' => $adminRoleId]);
            DB::table('users')->where('role', 'user')->update(['role_id' => $userRoleId]);
            DB::table('users')->whereNull('role_id')->update(['role_id' => $userRoleId]);

            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }

        // Ensure role_id has FK constraint (skip if already constrained)
        if (Schema::hasColumn('users', 'role_id')) {
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'role_id' AND REFERENCED_TABLE_NAME IS NOT NULL
            ");
            if (empty($foreignKeys)) {
                Schema::table('users', function (Blueprint $table) {
                    $table->foreignId('role_id')->nullable(false)->constrained()->change();
                });
            } else {
                // Column exists, just ensure NOT NULL
                DB::statement('ALTER TABLE users MODIFY role_id BIGINT UNSIGNED NOT NULL');
            }
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'user'])->default('user')->after('email');
        });

        // Map back
        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');
        $userRoleId = DB::table('roles')->where('name', 'user')->value('id');

        if ($adminRoleId) {
            DB::table('users')->where('role_id', $adminRoleId)->update(['role' => 'admin']);
        }
        if ($userRoleId) {
            DB::table('users')->where('role_id', $userRoleId)->update(['role' => 'user']);
        }
        DB::table('users')->whereNull('role')->update(['role' => 'user']);

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
};
