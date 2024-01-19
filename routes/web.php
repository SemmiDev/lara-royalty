<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VoucherController;
use App\Models\Tenant;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/tenants', [TenantController::class, 'store'])->name('tenants.store');
    Route::put('/tenants/{tenant}', [TenantController::class, 'update'])->name('tenants.update');
    Route::delete('/tenants/{tenant}', [TenantController::class, 'destroy'])->name('tenants.destroy');

    Route::get('/tenants/{tenant}/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::post('/tenants/{tenant}/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::put('/tenants/{tenant}/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/tenants/{tenant}/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::get('/tenants/{tenant}/customers/{customer}/transactions', [CustomerController::class, 'transactionHistory'])->name('customers.transactionHistory');
    Route::get('/tenants/{tenant}/customers/{customer}/vouchers/history', [CustomerController::class, 'voucherHistory'])->name('customers.voucherHistory');
    Route::get('/tenants/{tenant}/customers/{customer}/vouchers/redeem', [CustomerController::class, 'redeemVoucher'])->name('customers.redeemVoucher');

    Route::get("/tenants/{tenant}/transactions", [TransactionController::class, 'index'])->name('transactions.index');
    Route::get("/tenants/{tenant}/transactions/create", [TransactionController::class, 'create'])->name('transactions.create');
    Route::post("/tenants/{tenant}/transactions/store", [TransactionController::class, 'store'])->name('transactions.store');
    Route::get("/tenants/{tenant}/transactions/{transaction}/invoices", [TransactionController::class, 'invoice'])->name('transactions.invoice');

    Route::get("/tenants/{tenant}/vouchers", [VoucherController::class, 'create'])->name('vouchers.create');
    Route::post("/tenants/{tenant}/vouchers", [VoucherController::class, 'store'])->name('vouchers.store');
    Route::get("/tenants/{tenant}/vouchers/{voucher}", [VoucherController::class, 'show'])->name('vouchers.show');

    Route::get("/tenants/{tenant}/redeem", [VoucherController::class, 'redeem'])->name('vouchers.redeem');
    Route::post("/tenants/{tenant}/redeem", [VoucherController::class, 'redeemVoucher'])->name('vouchers.redeemVoucher');
});

require __DIR__ . '/auth.php';
