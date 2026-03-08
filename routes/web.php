<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleReturnController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StockAdjustmentController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// ─── Authenticated routes ────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // --- Dashboard ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('permission:dashboard.view')->name('dashboard');

    // --- Categories ---
    Route::middleware('permission:categories.view')->group(function () {
        Route::resource('categories', CategoryController::class)->only(['index', 'show']);
        Route::get('categories-export', [CategoryController::class, 'export'])->name('categories.export');
    });
    Route::middleware('permission:categories.create')->group(function () {
        Route::resource('categories', CategoryController::class)->only(['create', 'store']);
        Route::post('categories-import', [CategoryController::class, 'import'])->name('categories.import');
        Route::get('categories-sample', [CategoryController::class, 'sampleExport'])->name('categories.sample');
    });
    Route::resource('categories', CategoryController::class)->only(['edit', 'update'])->middleware('permission:categories.edit');
    Route::resource('categories', CategoryController::class)->only(['destroy'])->middleware('permission:categories.delete');

    // --- Brands ---
    Route::middleware('permission:brands.view')->group(function () {
        Route::resource('brands', BrandController::class)->only(['index', 'show']);
    });
    Route::resource('brands', BrandController::class)->only(['create', 'store'])->middleware('permission:brands.create');
    Route::resource('brands', BrandController::class)->only(['edit', 'update'])->middleware('permission:brands.edit');
    Route::resource('brands', BrandController::class)->only(['destroy'])->middleware('permission:brands.delete');

    // --- Units ---
    Route::middleware('permission:units.view')->group(function () {
        Route::resource('units', UnitController::class)->only(['index', 'show']);
        Route::get('units-export', [UnitController::class, 'export'])->name('units.export');
    });
    Route::middleware('permission:units.create')->group(function () {
        Route::resource('units', UnitController::class)->only(['create', 'store']);
        Route::post('units-import', [UnitController::class, 'import'])->name('units.import');
        Route::get('units-sample', [UnitController::class, 'sampleExport'])->name('units.sample');
    });
    Route::resource('units', UnitController::class)->only(['edit', 'update'])->middleware('permission:units.edit');
    Route::resource('units', UnitController::class)->only(['destroy'])->middleware('permission:units.delete');

    // --- Products ---
    Route::middleware('permission:products.view')->group(function () {
        Route::resource('products', ProductController::class)->only(['index', 'show']);
        Route::get('products-export', [ProductController::class, 'export'])->name('products.export');
        Route::get('products/{product}/barcode', [ProductController::class, 'barcode'])->name('products.barcode');
    });
    Route::middleware('permission:products.create')->group(function () {
        Route::resource('products', ProductController::class)->only(['create', 'store']);
        Route::post('products-import', [ProductController::class, 'import'])->name('products.import');
        Route::get('products-sample', [ProductController::class, 'sampleExport'])->name('products.sample');
    });
    Route::resource('products', ProductController::class)->only(['edit', 'update'])->middleware('permission:products.edit');
    Route::resource('products', ProductController::class)->only(['destroy'])->middleware('permission:products.delete');

    // --- Warehouses ---
    Route::resource('warehouses', WarehouseController::class)->only(['index', 'show'])->middleware('permission:warehouses.view');
    Route::resource('warehouses', WarehouseController::class)->only(['create', 'store'])->middleware('permission:warehouses.create');
    Route::resource('warehouses', WarehouseController::class)->only(['edit', 'update'])->middleware('permission:warehouses.edit');
    Route::resource('warehouses', WarehouseController::class)->only(['destroy'])->middleware('permission:warehouses.delete');

    // --- Suppliers ---
    Route::middleware('permission:suppliers.view')->group(function () {
        Route::resource('suppliers', SupplierController::class)->only(['index', 'show']);
        Route::get('suppliers-export', [SupplierController::class, 'export'])->name('suppliers.export');
    });
    Route::middleware('permission:suppliers.create')->group(function () {
        Route::resource('suppliers', SupplierController::class)->only(['create', 'store']);
        Route::post('suppliers-quick', [SupplierController::class, 'quickStore'])->name('suppliers.quick');
        Route::post('suppliers-import', [SupplierController::class, 'import'])->name('suppliers.import');
        Route::get('suppliers-sample', [SupplierController::class, 'sampleExport'])->name('suppliers.sample');
    });
    Route::resource('suppliers', SupplierController::class)->only(['edit', 'update'])->middleware('permission:suppliers.edit');
    Route::resource('suppliers', SupplierController::class)->only(['destroy'])->middleware('permission:suppliers.delete');

    // --- Customers ---
    Route::middleware('permission:customers.view')->group(function () {
        Route::resource('customers', CustomerController::class)->only(['index', 'show']);
        Route::get('customers-export', [CustomerController::class, 'export'])->name('customers.export');
    });
    Route::middleware('permission:customers.create')->group(function () {
        Route::resource('customers', CustomerController::class)->only(['create', 'store']);
        Route::post('customers-quick', [CustomerController::class, 'quickStore'])->name('customers.quick');
        Route::post('customers-import', [CustomerController::class, 'import'])->name('customers.import');
        Route::get('customers-sample', [CustomerController::class, 'sampleExport'])->name('customers.sample');
    });
    Route::resource('customers', CustomerController::class)->only(['edit', 'update'])->middleware('permission:customers.edit');
    Route::resource('customers', CustomerController::class)->only(['destroy'])->middleware('permission:customers.delete');

    // --- Purchases ---
    Route::middleware('permission:purchases.view')->group(function () {
        Route::resource('purchases', PurchaseController::class)->only(['index', 'show']);
        Route::get('purchases/{purchase}/pdf', [PurchaseController::class, 'downloadPdf'])->name('purchases.pdf');
        Route::get('purchases-export', [PurchaseController::class, 'export'])->name('purchases.export');
    });
    Route::middleware('permission:purchases.create')->group(function () {
        Route::resource('purchases', PurchaseController::class)->only(['create', 'store']);
        Route::post('purchases-import', [PurchaseController::class, 'import'])->name('purchases.import');
        Route::get('purchases-sample', [PurchaseController::class, 'sampleExport'])->name('purchases.sample');
    });
    Route::resource('purchases', PurchaseController::class)->only(['edit', 'update'])->middleware('permission:purchases.edit');
    Route::resource('purchases', PurchaseController::class)->only(['destroy'])->middleware('permission:purchases.delete');

    // --- Sales ---
    Route::middleware('permission:sales.view')->group(function () {
        Route::resource('sales', SaleController::class)->only(['index', 'show']);
        Route::get('sales/{sale}/pdf', [SaleController::class, 'downloadPdf'])->name('sales.pdf');
        Route::get('sales-export', [SaleController::class, 'export'])->name('sales.export');
    });
    Route::middleware('permission:sales.create')->group(function () {
        Route::resource('sales', SaleController::class)->only(['create', 'store']);
        Route::post('sales-import', [SaleController::class, 'import'])->name('sales.import');
        Route::get('sales-sample', [SaleController::class, 'sampleExport'])->name('sales.sample');
    });
    Route::resource('sales', SaleController::class)->only(['edit', 'update'])->middleware('permission:sales.edit');
    Route::resource('sales', SaleController::class)->only(['destroy'])->middleware('permission:sales.delete');

    // --- Quotations ---
    Route::middleware('permission:quotations.view')->group(function () {
        Route::resource('quotations', QuotationController::class)->only(['index', 'show']);
        Route::get('quotations/{quotation}/pdf', [QuotationController::class, 'downloadPdf'])->name('quotations.pdf');
        Route::post('quotations/{quotation}/email', [QuotationController::class, 'sendEmail'])->name('quotations.email');
    });
    Route::resource('quotations', QuotationController::class)->only(['create', 'store'])->middleware('permission:quotations.create');
    Route::resource('quotations', QuotationController::class)->only(['edit', 'update'])->middleware('permission:quotations.edit');
    Route::resource('quotations', QuotationController::class)->only(['destroy'])->middleware('permission:quotations.delete');

    // --- POS ---
    Route::middleware('permission:pos.access')->group(function () {
        Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
        Route::post('/pos', [PosController::class, 'store'])->name('pos.store');
    });

    // --- Purchase Returns ---
    Route::resource('purchase-returns', PurchaseReturnController::class)->only(['index', 'show'])->middleware('permission:purchase-returns.view');
    Route::resource('purchase-returns', PurchaseReturnController::class)->only(['create', 'store'])->middleware('permission:purchase-returns.create');

    // --- Sale Returns ---
    Route::resource('sale-returns', SaleReturnController::class)->only(['index', 'show'])->middleware('permission:sale-returns.view');
    Route::resource('sale-returns', SaleReturnController::class)->only(['create', 'store'])->middleware('permission:sale-returns.create');

    // --- Payments ---
    Route::resource('payments', PaymentController::class)->only(['index', 'show'])->middleware('permission:payments.view');
    Route::resource('payments', PaymentController::class)->only(['create', 'store'])->middleware('permission:payments.create');

    // --- Expense Categories ---
    Route::resource('expense-categories', ExpenseCategoryController::class)->only(['index'])->middleware('permission:expense-categories.view');
    Route::resource('expense-categories', ExpenseCategoryController::class)->only(['create', 'store'])->middleware('permission:expense-categories.create');
    Route::resource('expense-categories', ExpenseCategoryController::class)->only(['edit', 'update'])->middleware('permission:expense-categories.edit');
    Route::resource('expense-categories', ExpenseCategoryController::class)->only(['destroy'])->middleware('permission:expense-categories.delete');

    // --- Expenses ---
    Route::resource('expenses', ExpenseController::class)->only(['index'])->middleware('permission:expenses.view');
    Route::resource('expenses', ExpenseController::class)->only(['create', 'store'])->middleware('permission:expenses.create');
    Route::resource('expenses', ExpenseController::class)->only(['edit', 'update'])->middleware('permission:expenses.edit');
    Route::resource('expenses', ExpenseController::class)->only(['destroy'])->middleware('permission:expenses.delete');

    // --- Stock Adjustments ---
    Route::resource('stock-adjustments', StockAdjustmentController::class)->only(['index', 'show'])->middleware('permission:stock-adjustments.view');
    Route::resource('stock-adjustments', StockAdjustmentController::class)->only(['create', 'store'])->middleware('permission:stock-adjustments.create');

    // --- Notifications ---
    Route::get('/notifications', [NotificationController::class, 'index'])->middleware('permission:notifications.view')->name('notifications.index');

    // --- Reports ---
    Route::middleware('permission:reports.view')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
        Route::get('/reports/purchase', [ReportController::class, 'purchase'])->name('reports.purchase');
        Route::get('/reports/sale', [ReportController::class, 'sale'])->name('reports.sale');
        Route::get('/reports/profit', [ReportController::class, 'profit'])->name('reports.profit');
    });

    // --- Profile (own account) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Language switch ---
    Route::get('/language/{lang}', function ($lang) {
        if (in_array($lang, ['bn', 'en'])) {
            auth()->user()->update(['language' => $lang]);
        }
        return redirect()->back();
    })->name('language.switch');

    // --- User management ---
    Route::resource('users', UserController::class)->middleware('permission:users.view')->only(['index', 'show']);
    Route::resource('users', UserController::class)->middleware('permission:users.create')->only(['create', 'store']);
    Route::resource('users', UserController::class)->middleware('permission:users.edit')->only(['edit', 'update']);
    Route::resource('users', UserController::class)->middleware('permission:users.delete')->only(['destroy']);

    // --- Roles & Permissions ---
    Route::resource('roles', RoleController::class)->only(['index'])->middleware('permission:roles.view');
    Route::resource('roles', RoleController::class)->only(['create', 'store'])->middleware('permission:roles.create');
    Route::resource('roles', RoleController::class)->only(['edit', 'update'])->middleware('permission:roles.edit');
    Route::resource('roles', RoleController::class)->only(['destroy'])->middleware('permission:roles.delete');

    Route::resource('permissions', PermissionController::class)->only(['index'])->middleware('permission:permissions.view');
    Route::resource('permissions', PermissionController::class)->only(['create', 'store'])->middleware('permission:permissions.create');
    Route::resource('permissions', PermissionController::class)->only(['edit', 'update'])->middleware('permission:permissions.edit');
    Route::resource('permissions', PermissionController::class)->only(['destroy'])->middleware('permission:permissions.delete');

    // --- Settings ---
    Route::middleware('permission:settings.manage')->group(function () {
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    });

    // --- Database Backup ---
    Route::middleware('permission:backups.manage')->group(function () {
        Route::get('/backups', [BackupController::class, 'index'])->name('backups.index');
        Route::post('/backups', [BackupController::class, 'create'])->name('backups.create');
        Route::get('/backups/{filename}', [BackupController::class, 'download'])->name('backups.download');
        Route::delete('/backups/{filename}', [BackupController::class, 'destroy'])->name('backups.destroy');
    });

    // --- Activity Log ---
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->middleware('permission:activity-logs.view')->name('activity-logs.index');
});

require __DIR__.'/auth.php';
