<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

  Route::group(['middleware' => 'userMiddleware', 'prefix' => 'user'],function(){

        Route::get('/home',[UserController::class,'home'])->name('user#home');
        Route::get('/product/details/{id}',[UserController::class,'productDetails'])->name('user#productDetails');
        Route::post('/comment',[UserController::class,'comment'])->name('user#comment');
        Route::get('/comment/delete/{id}',[UserController::class,'commentDelete'])->name('user#commentDelete');
        Route::post('/rating',[UserController::class,'rating'])->name('user#rating');
        Route::get('/cart',[UserController::class,'cart'])->name('user#cart');
        Route::post('/addToCart',[UserController::class,'addToCart'])->name('user#addToCart');
        Route::get('/deleteCart',[UserController::class,'deleteCart'])->name('user#deleteCart');
        Route::get('/payment/page',[UserController::class,'paymentPage'])->name('user#paymentPage');
        Route::get('/cart/temp',[UserController::class,'cartTemp'])->name('user#cartTemp');
        Route::post('/payment',[UserController::class,'payment'])->name('user#payment');
        Route::get('/order/list',[UserController::class,'orderList'])->name('user#orderList');
        Route::get('/profile/details',[UserController::class,'profileDetails'])->name('user#profileDetails');
        Route::get('/profile/edit',[UserController::class,'profileEdit'])->name('user#profileEdit');
        Route::post('/profile/update/{id}',[UserController::class,'profileUpdate'])->name('user#profileUpdate');
        Route::get('/profile/change/password',[UserController::class,'changePasswordPage'])->name('user#changePasswordPage');
        Route::post('/profile/change/password',[UserController::class,'changePassword'])->name('user#changePassword');
        Route::get('/contact/page',[UserController::class,'contactPage'])->name('user#contactPage');
        Route::post('/contact',[UserController::class,'contact'])->name('user#contact');

});

