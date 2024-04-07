<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PageDashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimeEntryController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::view('/login', 'pages.login')->name('login');
Route::post('/login', LoginController::class)->name('login.handle');

Route::group(['middleware' => ['auth:web']], function () {
    Route::post('/logout', LogoutController::class)->name('logout');
    Route::get('/dashboard', PageDashboardController::class)->name('dashboard');
    Route::resource('/clients', ClientController::class)->only(['index', 'create', 'show', 'store']);

    /** Project related routes are grouped here. */
    Route::resource('/projects', ProjectController::class);
    Route::group(['prefix' => 'projects'], function () {
        Route::resource('/{project}/issues', IssueController::class);
        Route::resource('/{project}/deliveries', DeliveryController::class)
            ->only(['create', 'store', 'index', 'edit', 'update']);
        Route::resource('/{project}/deliveries/{delivery}/estimates', EstimateController::class)
            ->only(['create', 'store', 'index']);
    });

    Route::resource('/time-entries', TimeEntryController::class)->only(['store', 'create']);
});
