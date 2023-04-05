<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\DashboardController;

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
    return view('auth.login');
});
// Route::get('/admin/login', function () {
//     return route('auth.login');
// });



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/create', [DashboardController::class, 'create'])->name('dashboard.create');
    Route::get('/dashboard/{post:slug}/update', [DashboardController::class, 'update'])->name('dashboard.update');

    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

    Route::get('/csv/download',[DownloadController::class,'download'])->name('download');

    Route::get('/terms', function () {
        return view('terms');
    })->name('terms.show');
    Route::get('/policy', function () {
        return view('policy');
    })->name('policy.show');
});

require __DIR__.'/auth.php';
