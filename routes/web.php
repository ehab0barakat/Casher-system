<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Livewire\Admin\Users as AdminUsers;
use App\Http\Livewire\Admin\Clients as AdminClients;
use App\Http\Livewire\Admin\Branches as AdminBranches;
use App\Http\Livewire\Admin\Workers as AdminWorkers;
use App\Http\Livewire\Admin\Products as AdminProducts;
use App\Http\Livewire\Admin\Services as AdminServices;
use App\Http\Livewire\Admin\Dashboard as AdminDashboard;
use App\Http\Livewire\Admin\Receipts as AdminReceipts;
use App\Http\Livewire\Admin\Suppliers as AdminSuppliers;
use App\Http\Livewire\Admin\Expenses as AdminExpenses;
use App\Http\Livewire\Admin\Categories as AdminCategories;
use App\Http\Livewire\Admin\Reports as AdminReports;
use App\Http\Livewire\Admin\DailyReports as AdminDailyReports;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/db-fresh', function() {

//     Artisan::call('migrate:fresh --seed');

//     return 'DB FRESH SEED';
// });

// Route::get('/storage-link', function() {

//     Artisan::call('storage:link');

//     return 'STORAGE LINKED';
// });

//GENERIC
Route::middleware(['setLocale'])->group(function () {

    Route::get('/', function () {

        if (auth()->user() == null)
            return redirect()->route('login');

        switch (auth()->user()->type) {

                //SUPER ADMIN
            case '-1':
                return redirect()->route('admin.dashboard');
                break;

            case '0':
            case '1':
                return redirect()->route('admin.dashboard');
                break;
        }
    })->name('home');

    Route::get('/change-locale', [\App\Http\Controllers\Controller::class, 'changeLocale'])->name('change-locale');
});

//FOR ADMIN
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'setLocale',
])->group(function () {

    Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');

    Route::get('/receipts/{orderId}', AdminReceipts::class)->name('admin.receipts');

    Route::middleware(['checkPermission:p-reports'])->get('/dashboard/reports', AdminDailyReports::class)->name('admin.dailyReports');

    Route::middleware(['checkPermission:p-receipts'])->get('/dashboard/receipts', AdminReports::class)->name('adminDash.receipts');

    Route::middleware(['checkPermission:p-expenses'])->get('/dashboard/expenses', AdminExpenses::class)->name('admin.expenses');

    Route::middleware(['checkPermission:p-suppliers'])->get('/dashboard/suppliers', AdminSuppliers::class)->name('admin.suppliers');

    Route::middleware(['checkPermission:p-products'])->get('/dashboard/products', AdminProducts::class)->name('admin.products');

    Route::middleware(['checkPermission:p-products'])->get(
        '/dashboard/products/{productId}',
        [Controller::class, 'showBarcode']
    )->name('admin.barcode');

    Route::middleware(['checkPermission:p-clients'])->get('/dashboard/clients', AdminClients::class)->name('admin.clients');

    Route::middleware(['checkPermission:p-branches'])->get('/dashboard/branches', AdminBranches::class)->name('admin.branches');

    Route::middleware(['checkPermission:p-workers'])->get('/dashboard/workers', AdminWorkers::class)->name('admin.workers');

    Route::middleware(['checkPermission:p-users'])->get('/dashboard/users', AdminUsers::class)->name('admin.users');

    Route::middleware(['checkPermission:p-categories'])->get('/dashboard/categories', AdminCategories::class)->name('admin.categories');

});

Route::get('/no-permission', function () {
    return view('no-permission');
})->name('no-permission');
