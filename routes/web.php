<?php

use App\Http\Controllers\IssueController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageDashboardController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layout.app');
})->name('home');
Route::view('/login', 'pages.login')->name('login');
Route::post('/login', LoginController::class)->name('login.handle');

Route::group(['middleware' => ['auth:web']], function () {
    Route::get('/dashboard', PageDashboardController::class)->name('dashboard');
    Route::resource('/projects', ProjectController::class);
    Route::resource('/projects/{project:project_id}/issues', IssueController::class);
});
