<?php

use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\User\AccountController;
use App\Http\Controllers\Frontend\User\DashboardController;
use App\Http\Controllers\Frontend\User\ProfileController;

/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('contact', [ContactController::class, 'index'])->name('contact');
Route::post('contact/send', [ContactController::class, 'send'])->name('contact.send');
Route::get('ar/privacy', [HomeController::class, 'privacyAr']);
Route::get('en/privacy', [HomeController::class, 'privacyEn']);

/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 * These routes can not be hit if the password is expired
 */
Route::group(['middleware' => ['auth', 'password_expires']], function () {
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        // User Dashboard Specific
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // User Account Specific
        Route::get('account', [AccountController::class, 'index'])->name('account');

        // User Profile Specific
        Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    });
});


Route::get('req', 'HomeController@request');
Route::get('payment/{price}/{plan_id}/{plan_type}/{user_id}', 'HomeController@payment')->name('payment');
Route::get('apple/payment/{price}/{plan_id}/{plan_type}/{user_id}', 'HomeController@applePayment')->name('apple.payment');
Route::get('mada/payment/{price}/{plan_id}/{plan_type}/{user_id}', 'HomeController@madaPayment')->name('mada.payment');
Route::get('payment-status', 'HomeController@checkStatus')->name('payment.status');
Route::get('payment-mada-status', 'HomeController@checkMadaStatus')->name('payment.mada.status');
Route::get('payment-apple-status', 'HomeController@checkApplePayStatus')->name('payment.apple.status');
