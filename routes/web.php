<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::get('categories-export', [CategoryController::class, 'export'])->name('categories.export');
    Route::post('categories-import', [CategoryController::class, 'import'])->name('categories.import');
    Route::get('categories-sample', [CategoryController::class, 'sampleExport'])->name('categories.sample');

    Route::resource('units', UnitController::class);
    Route::get('units-export', [UnitController::class, 'export'])->name('units.export');
    Route::post('units-import', [UnitController::class, 'import'])->name('units.import');
    Route::get('units-sample', [UnitController::class, 'sampleExport'])->name('units.sample');

    Route::resource('products', ProductController::class);
    Route::get('products-export', [ProductController::class, 'export'])->name('products.export');
    Route::post('products-import', [ProductController::class, 'import'])->name('products.import');
    Route::get('products-sample', [ProductController::class, 'sampleExport'])->name('products.sample');

    Route::resource('suppliers', SupplierController::class);
    Route::get('suppliers-export', [SupplierController::class, 'export'])->name('suppliers.export');
    Route::post('suppliers-import', [SupplierController::class, 'import'])->name('suppliers.import');
    Route::get('suppliers-sample', [SupplierController::class, 'sampleExport'])->name('suppliers.sample');
    Route::post('suppliers-quick', [SupplierController::class, 'quickStore'])->name('suppliers.quick');

    Route::resource('customers', CustomerController::class);
    Route::get('customers-export', [CustomerController::class, 'export'])->name('customers.export');
    Route::post('customers-import', [CustomerController::class, 'import'])->name('customers.import');
    Route::get('customers-sample', [CustomerController::class, 'sampleExport'])->name('customers.sample');
    Route::post('customers-quick', [CustomerController::class, 'quickStore'])->name('customers.quick');

    Route::resource('purchases', PurchaseController::class);
    Route::get('purchases-export', [PurchaseController::class, 'export'])->name('purchases.export');
    Route::post('purchases-import', [PurchaseController::class, 'import'])->name('purchases.import');
    Route::get('purchases-sample', [PurchaseController::class, 'sampleExport'])->name('purchases.sample');

    Route::resource('sales', SaleController::class);
    Route::get('sales-export', [SaleController::class, 'export'])->name('sales.export');
    Route::post('sales-import', [SaleController::class, 'import'])->name('sales.import');
    Route::get('sales-sample', [SaleController::class, 'sampleExport'])->name('sales.sample');

    Route::resource('users', UserController::class);

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
    Route::get('/reports/purchase', [ReportController::class, 'purchase'])->name('reports.purchase');
    Route::get('/reports/sale', [ReportController::class, 'sale'])->name('reports.sale');
    Route::get('/reports/profit', [ReportController::class, 'profit'])->name('reports.profit');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/language/{lang}', function ($lang) {
        if (in_array($lang, ['bn', 'en'])) {
            auth()->user()->update(['language' => $lang]);
        }
        return redirect()->back();
    })->name('language.switch');
});

require __DIR__.'/auth.php';
