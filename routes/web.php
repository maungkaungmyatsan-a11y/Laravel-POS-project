<?php

use Laravel\Socialite\Socialite;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialLoginController;

require_once __DIR__ ."/admin.php";
require_once __DIR__ ."/user.php";

Route::redirect('/', '/login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['adminMiddleware'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


//social login

Route::get('/auth/{provider}/redirect', [SocialLoginController::class,'redirect'])->name('social#redirect');

Route::get('/auth/{provider}/callback', [SocialLoginController::class,'callback'])->name('social#redirect');
