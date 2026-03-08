<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
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
            'settings' => ['settings.manage'],
            'backups' => ['backups.manage'],
            'activity-logs' => ['activity-logs.view'],
        ];

        // Create all permissions
        $allPermissionIds = [];
        foreach ($permissionsMap as $group => $permissions) {
            foreach ($permissions as $permName) {
                $perm = Permission::firstOrCreate(
                    ['name' => $permName],
                    ['group' => $group]
                );
                $allPermissionIds[] = $perm->id;
            }
        }

        // Admin role - all permissions
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['guard_name' => 'web', 'is_protected' => true]
        );
        $adminRole->permissions()->syncWithoutDetaching($allPermissionIds);

        // User role - limited permissions (matching current route setup)
        $userRole = Role::firstOrCreate(
            ['name' => 'user'],
            ['guard_name' => 'web', 'is_protected' => false]
        );

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

        $userPermIds = Permission::whereIn('name', $userPermissions)->pluck('id')->toArray();
        $userRole->permissions()->syncWithoutDetaching($userPermIds);
    }
}
