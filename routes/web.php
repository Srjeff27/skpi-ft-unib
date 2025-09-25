<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if (! $user) {
        return redirect()->route('login');
    }

    if ($user->role === 'admin') {
        return redirect('/admin');
    }

    if ($user->role === 'verifikator') {
        return redirect('/verifikator');
    }

    // Mahasiswa & role lain menggunakan dashboard Breeze
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Mahasiswa: Portofolio
    Route::get('/portofolio', [\App\Http\Controllers\PortfolioController::class, 'index'])->name('student.portfolios.index');
    Route::get('/portofolio/create', [\App\Http\Controllers\PortfolioController::class, 'create'])->name('student.portfolios.create');
    Route::post('/portofolio', [\App\Http\Controllers\PortfolioController::class, 'store'])->name('student.portfolios.store');
    Route::get('/portofolio/{portfolio}/edit', [\App\Http\Controllers\PortfolioController::class, 'edit'])->name('student.portfolios.edit');
    Route::put('/portofolio/{portfolio}', [\App\Http\Controllers\PortfolioController::class, 'update'])->name('student.portfolios.update');
    Route::delete('/portofolio/{portfolio}', [\App\Http\Controllers\PortfolioController::class, 'destroy'])->name('student.portfolios.destroy');

    // Dokumen SKPI (placeholder)
    Route::get('/dokumen-skpi', function () {
        return view('student.dokumen.index');
    })->name('student.documents.index');
});

require __DIR__.'/auth.php';
