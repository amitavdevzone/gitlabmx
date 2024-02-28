<?php

use App\Http\Controllers\IssueController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layout.app');
})->name('home');

Route::resource('/projects', ProjectController::class);
Route::resource('/projects/{project:project_id}/issues', IssueController::class);
