<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissionsMap = [
            'dashboard' => ['dashboard.view'],
            'categories' => ['categories.view', 'categories.create', 'categories.edit', 'categories.delete'],
            'brands' => ['brands.view', 'brands.create', 'brands.edit', 'brands.delete'],
            'units' => ['units.view', 'units.create', 'units.edit', 'units.delete'],
            'products' => ['products.view', 'products.create', 'products.edit', 'products.delete'],
            'warehouses' => ['warehouses.view', 'warehouses.create', 'warehouses.edit', 'warehouses.delete'],
            'suppliers' => ['suppliers.view', 'suppliers.create', 'suppliers.edit', 'suppliers.delete'],
            'customers' => ['customers.view', 'customers.create', 'customers.edit', 'customers.delete'],
            'purchases' => ['purchases.view', 'purchases.create', 'purchases.edit', 'purchases.delete'],
            'sales' => ['sales.view', 'sales.create', 'sales.edit', 'sales.delete'],
            'quotations' => ['quotations.view', 'quotations.create', 'quotations.edit', 'quotations.delete'],
            'pos' => ['pos.access'],
            'purchase-returns' => ['purchase-returns.view', 'purchase-returns.create'],
            'sale-returns' => ['sale-returns.view', 'sale-returns.create'],
            'payments' => ['payments.view', 'payments.create'],
            'expenses' => ['expenses.view', 'expenses.create', 'expenses.edit', 'expenses.delete'],
            'expense-categories' => ['expense-categories.view', 'expense-categories.create', 'expense-categories.edit', 'expense-categories.delete'],
            'stock-adjustments' => ['stock-adjustments.view', 'stock-adjustments.create'],
            'notifications' => ['notifications.view'],
            'reports' => ['reports.view'],
            'users' => ['users.view', 'users.create', 'users.edit', 'users.delete'],
            'roles' => ['roles.view', 'roles.create', 'roles.edit', 'roles.delete'],
            'permissions' => ['permissions.view', 'permissions.create', 'permissions.edit', 'permissions.delete'],
            'settings' => ['settings.manage'],
            'backups' => ['backups.manage'],
            'activity-logs' => ['activity-logs.view'],
        ];

        // Create all permissions
        $allPermissions = [];
        foreach ($permissionsMap as $permissions) {
            foreach ($permissions as $permName) {
                $allPermissions[] = Permission::firstOrCreate(
                    ['name' => $permName, 'guard_name' => 'web']
                );
            }
        }

        // Admin role - all permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions($allPermissions);

        // User role - limited permissions
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        $userPermissions = [
            'dashboard.view',
            'categories.view', 'units.view', 'products.view', 'brands.view',
            'suppliers.view', 'customers.view', 'warehouses.view',
            'purchases.view', 'purchases.create',
            'sales.view', 'sales.create',
            'quotations.view', 'quotations.create',
            'pos.access',
            'purchase-returns.view', 'purchase-returns.create',
            'sale-returns.view', 'sale-returns.create',
            'payments.view', 'payments.create',
            'expenses.view',
            'stock-adjustments.view',
            'notifications.view',
            'reports.view',
        ];

        $userRole->syncPermissions($userPermissions);
    }
}
