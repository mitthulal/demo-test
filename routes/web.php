<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DashboardController;
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
    return view('welcome');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/index/{id}', [InvoiceController::class, 'index'])->name('index');
    Route::get('/create/{id}/{type}', [InvoiceController::class, 'create'])->name('create');
    Route::post('/store', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/delete/{id}', [InvoiceController::class, 'delete'])->name('delete');
    Route::get('/invoices/{invoice}/send', [InvoiceController::class, 'send'])->name('send');
    Route::get('/invoice/{invoice}/download', [InvoiceController::class, 'exportPDF'])->name('invoice.download');
    Route::get('/send-payment-link/{id}', [InvoiceController::class, 'sendPaymentLink'])->name('payment.send');



});

require __DIR__.'/auth.php';
