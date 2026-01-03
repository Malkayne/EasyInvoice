<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessProfileController;
use App\Http\Controllers\ProfileController;

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
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/business/setup', [BusinessProfileController::class, 'create'])->name('business.setup');
    Route::post('/business/setup', [BusinessProfileController::class, 'store'])->name('business.store');
    Route::patch('/profile/business', [BusinessProfileController::class, 'update'])->name('business-profile.update');
    
    Route::resource('customers', \App\Http\Controllers\CustomerController::class)->except(['create', 'edit']);
    Route::resource('invoices', \App\Http\Controllers\InvoiceController::class);
    Route::get('/invoices/{invoice}/download', [\App\Http\Controllers\InvoiceController::class, 'download'])->name('invoices.download');
    Route::post('/invoices/{invoice}/email', [\App\Http\Controllers\InvoiceController::class, 'email'])->name('invoices.email');
    Route::post('/invoices/{invoice}/mark-paid', [\App\Http\Controllers\InvoiceController::class, 'markAsPaid'])->name('invoices.mark-paid');
    
    // Analytics routes
    Route::get('/analytics', [\App\Http\Controllers\AnalyticsController::class, 'index'])->name('analytics.index');
});

Route::get('/i/{token}', [\App\Http\Controllers\InvoiceController::class, 'publicShow'])->name('invoices.public');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', \App\Http\Middleware\EnsureBusinessProfileExists::class])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
