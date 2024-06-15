<?php

use App\Http\Controllers\AnalyzeProductController;
use App\Http\Controllers\DatasetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Models\Dataset;
use App\Models\Transaction;
use EnzoMC\PhpFPGrowth\FPGrowth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('users', UserController::class);
    Route::resource('datasets', DatasetController::class);
    Route::controller(DatasetController::class)->name('dataset.')->prefix('dataset')->group(function () {
        Route::post('import', 'import')->name('import');
        Route::get('download-template', 'downloadTemplate')->name('download-template');
        Route::delete('{dataset}/destroy', 'destroy')->name('destroy');
    });
    Route::controller(AnalyzeProductController::class)->name('analyze.')->prefix('analyze')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('grafik', 'grafik')->name('grafik');
        Route::get('report', 'report')->name('report');
        Route::post('report', 'report')->name('report.filter');
        
    });
    Route::controller(TransactionController::class)->name('transaction.')->prefix('transaction')->group(function () {
        Route::get('', 'index')->name('index');
    });
});

Route::get('import-users', [UserController::class, 'import'])->name('import-users');

require __DIR__ . '/auth.php';
