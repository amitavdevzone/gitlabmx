<?php

use App\Http\Controllers\ProjectController;
use App\Http\Integrations\Gitlab\GitlabConnector;
use App\Http\Integrations\Gitlab\Requests\GitlabFetchProjectsRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layout.app');
})->name('home');

Route::resource('/projects', ProjectController::class);
