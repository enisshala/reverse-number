<?php

use App\Http\Controllers\Frontend\CreatePlanController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\SearchNumberController;
use App\Http\Controllers\Frontend\CreateAccountController;
use App\Http\Controllers\Frontend\User\AccountController;
use App\Http\Controllers\Frontend\User\ProfileController;
use App\Http\Controllers\Frontend\User\DashboardController;
use App\Http\Controllers\Frontend\PagesController;

/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('contact', [ContactController::class, 'index'])->name('contact');
Route::post('contact/send', [ContactController::class, 'send'])->name('contact.send');

//Search number
Route::post('search-number', [SearchNumberController::class, 'search'])->name('search-number');

//Create Account
Route::get('create-account', [CreateAccountController::class, 'index'])->name('create-account');
Route::post('create-account', [CreateAccountController::class, 'create'])->name('create-account');

//Billing Routes
Route::get('billing-success', [CreateAccountController::class, 'executeAgreement'])->name('execute-agreement');
Route::get('billing-cancel', [CreateAccountController::class, 'executeCancel'])->name('execute-cancel');

//Create Plan
Route::get('create-the-plan', [CreatePlanController::class, 'index'])->name('create-the-plan');

//Pages Routes
Route::get('terms-conditions', [PagesController::class, 'terms'])->name('terms');
Route::get('privacy-policy', [PagesController::class, 'privacy'])->name('privacy');
Route::get('about-us', [PagesController::class, 'about'])->name('about');

/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 * These routes can not be hit if the password is expired
 */
Route::group(['middleware' => ['auth', 'password_expires']], function () {
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        // User Dashboard Specific
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('request-cancel', [DashboardController::class, 'requestCancel'])->name('request-cancel');

        // User Account Specific
        Route::get('account', [AccountController::class, 'index'])->name('account');

        //Subscription Cancel
        Route::post('subscription-cancel', [CreateAccountController::class, 'subscriptionCancel'])->name('subscription-cancel');
        Route::post('subscribe-now', [CreateAccountController::class, 'createSubscription'])->name('subscribe-now');

        // User Profile Specific
        Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');

    });
});
