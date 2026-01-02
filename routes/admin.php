<?php

use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleInformationController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['adminMiddleware','auth'], 'prefix' => 'admin'], function () {

    Route::get('/home', [AdminDashboard::class, 'dashboard'])->name('admin#home');

    Route::group(['prefix' => 'category'], function () {
        Route::get('/list', [CategoryController::class, 'list'])->name('category#list');
        Route::post('/create', action: [CategoryController::class, 'create'])->name('category#create');
        Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('category#delete');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category#edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category#update');

    });

    //product
    Route::group(['prefix' => 'product'], function () {
        Route::get('list', [ProductController::class, 'list'])->name('product#list');
        Route::get('create', [ProductController::class, 'createPage'])->name('product#createPage');
        Route::post('create', [ProductController::class, 'create'])->name('product#create');
        Route::get('delete/{id}', [ProductController::class, 'delete'])->name('product#delete');
        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('product#edit');
        Route::post('update/{id}', [ProductController::class, 'update'])->name('product#update');

    });

    //profile
     Route::group(['prefix' => 'profile'], function () {
       Route::get('details',[AdminProfileController::class,'details'])->name('profile#details');
       Route::get('edit',[AdminProfileController::class,'edit'])->name('profile#edit');
       Route::post('update/{id}',[AdminProfileController::class,'update'])->name('profile#update');
       Route::get('change/password',[AdminProfileController::class,'changePasswordPage'])->name('profile#changePasswordPage');
       Route::post('change/password',[AdminProfileController::class,'changePassword'])->name('profile#changePassword');


       Route::group(['middleware' => 'superAdminMiddleware'], function () {
       Route::get('add/newAdmin',[AdminProfileController::class,'addNewAdminPage'])->name('profile#addNewAdminPage');
       Route::post('add/newAdmin',[AdminProfileController::class,'addNewAdmin'])->name('profile#addNewAdmin');
       Route::get('{accountType}/list',[AdminProfileController::class,'accountList'])->name('profile#accountList');
       Route::get('delete/{id}',[AdminProfileController::class,'delete'])->name('profile#delete');
       });

    });

    //Order
    Route::group(['prefix' => 'order'], function () {
       Route::get('list/{state?}',[OrderController::class,'orderList'])->name('admin#orderList');
       Route::get('details/{orderCode}',[OrderController::class,'orderDetails'])->name('admin#orderDetails');
       Route::get('reject',[OrderController::class,'orderReject'])->name('admin#orderReject');
       Route::get('accept',[OrderController::class,'orderAccept'])->name('admin#orderAccept');
       Route::get('list/accept',[OrderController::class,'orderlistAccept'])->name('admin#orderlistAccept');
    });

    //Sale
    Route::group(['prefix' => 'sale'], function () {
       Route::get('information',[SaleInformationController::class,'saleInformation'])->name('admin#saleInformation');

    });

});
