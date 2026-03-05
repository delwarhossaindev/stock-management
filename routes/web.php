<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// ─── Authenticated routes (Admin + User) ────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- View & List (both roles) ---
    Route::resource('categories', CategoryController::class)->only(['index', 'show']);
    Route::resource('units', UnitController::class)->only(['index', 'show']);
    Route::resource('products', ProductController::class)->only(['index', 'show']);
    Route::resource('suppliers', SupplierController::class)->only(['index', 'show']);
    Route::resource('customers', CustomerController::class)->only(['index', 'show']);
    Route::resource('purchases', PurchaseController::class)->only(['index', 'show', 'create', 'store']);
    Route::resource('sales', SaleController::class)->only(['index', 'show', 'create', 'store']);
    Route::resource('quotations', QuotationController::class)->only(['index', 'show', 'create', 'store']);
    Route::get('quotations/{quotation}/pdf', [QuotationController::class, 'downloadPdf'])->name('quotations.pdf');
    Route::post('quotations/{quotation}/email', [QuotationController::class, 'sendEmail'])->name('quotations.email');

    // --- Quick store (both roles – needed when creating purchases/sales) ---
    Route::post('suppliers-quick', [SupplierController::class, 'quickStore'])->name('suppliers.quick');
    Route::post('customers-quick', [CustomerController::class, 'quickStore'])->name('customers.quick');

    // --- Export (both roles) ---
    Route::get('categories-export', [CategoryController::class, 'export'])->name('categories.export');
    Route::get('units-export', [UnitController::class, 'export'])->name('units.export');
    Route::get('products-export', [ProductController::class, 'export'])->name('products.export');
    Route::get('suppliers-export', [SupplierController::class, 'export'])->name('suppliers.export');
    Route::get('customers-export', [CustomerController::class, 'export'])->name('customers.export');
    Route::get('purchases-export', [PurchaseController::class, 'export'])->name('purchases.export');
    Route::get('sales-export', [SaleController::class, 'export'])->name('sales.export');

    // --- Reports (both roles) ---
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
    Route::get('/reports/purchase', [ReportController::class, 'purchase'])->name('reports.purchase');
    Route::get('/reports/sale', [ReportController::class, 'sale'])->name('reports.sale');
    Route::get('/reports/profit', [ReportController::class, 'profit'])->name('reports.profit');

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

    // ─── Admin-only routes ───────────────────────────────────────────
    Route::middleware(['role:admin'])->group(function () {
        // --- User management ---
        Route::resource('users', UserController::class);

        // --- Master data CUD (create, update, delete) ---
        Route::resource('categories', CategoryController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('units', UnitController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('products', ProductController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('suppliers', SupplierController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('customers', CustomerController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);

        // --- Purchase & Sale edit/delete (admin only) ---
        Route::resource('purchases', PurchaseController::class)->only(['edit', 'update', 'destroy']);
        Route::resource('sales', SaleController::class)->only(['edit', 'update', 'destroy']);
        Route::resource('quotations', QuotationController::class)->only(['edit', 'update', 'destroy']);

        // --- Import & Sample download (admin only) ---
        Route::post('categories-import', [CategoryController::class, 'import'])->name('categories.import');
        Route::get('categories-sample', [CategoryController::class, 'sampleExport'])->name('categories.sample');
        Route::post('units-import', [UnitController::class, 'import'])->name('units.import');
        Route::get('units-sample', [UnitController::class, 'sampleExport'])->name('units.sample');
        Route::post('products-import', [ProductController::class, 'import'])->name('products.import');
        Route::get('products-sample', [ProductController::class, 'sampleExport'])->name('products.sample');
        Route::post('suppliers-import', [SupplierController::class, 'import'])->name('suppliers.import');
        Route::get('suppliers-sample', [SupplierController::class, 'sampleExport'])->name('suppliers.sample');
        Route::post('customers-import', [CustomerController::class, 'import'])->name('customers.import');
        Route::get('customers-sample', [CustomerController::class, 'sampleExport'])->name('customers.sample');
        Route::post('purchases-import', [PurchaseController::class, 'import'])->name('purchases.import');
        Route::get('purchases-sample', [PurchaseController::class, 'sampleExport'])->name('purchases.sample');
        Route::post('sales-import', [SaleController::class, 'import'])->name('sales.import');
        Route::get('sales-sample', [SaleController::class, 'sampleExport'])->name('sales.sample');
    });
});

require __DIR__.'/auth.php';
