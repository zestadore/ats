<?php

use Illuminate\Support\Facades\Route;

// Auth::routes();
Route::middleware(['auth'])->name('admin.')->namespace("App\Http\Controllers\Admin")->group(function () {
	Route::get('/dashboard', [App\Http\Controllers\Admin\HomeController::class, 'dashboard'])->name('dashboard');
    Route::resource('clients', ClientController::class);
    Route::resource('clients.end-clients', EndClientController::class);
    Route::resource('candidates', CandidateController::class);
    Route::resource('job-opportunities', JobOpportunityController::class);
    Route::get('/get-end-clients/{id}', [App\Http\Controllers\Admin\EndClientController::class, 'getList'])->name('get-end-clients');
});

