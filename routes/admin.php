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
    Route::resource('job-submissions', SubmissionController::class);
    Route::get('/get-candidates-details/{id}', [App\Http\Controllers\Admin\CandidateController::class, 'getCandidatesDetails'])->name('get-candidates-details');
    Route::get('get-candidates-list', [App\Http\Controllers\Admin\CandidateController::class, 'getCandidatesSearch'])->name('get-candidates-list');
    Route::resource('users', UserController::class);
});

