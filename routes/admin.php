<?php

use Illuminate\Support\Facades\Route;

// Auth::routes();
Route::middleware(['auth'])->name('admin.')->namespace("App\Http\Controllers\Admin")->group(function () {
	Route::get('/dashboard', [App\Http\Controllers\Admin\HomeController::class, 'dashboard'])->name('dashboard');
    Route::resource('clients', ClientController::class);
    Route::resource('clients.end-clients', EndClientController::class);
    Route::resource('candidates', CandidateController::class);
    Route::resource('job-opportunities', JobOpportunityController::class);
    Route::get('/get-client-job-opportunity/{clientId}', [App\Http\Controllers\Admin\JobOpportunityController::class, 'getClientJobOpportunity'])->name('get-client-job-opportunity');
    Route::get('/get-end-clients/{id}', [App\Http\Controllers\Admin\EndClientController::class, 'getList'])->name('get-end-clients');
    Route::resource('job-submissions', SubmissionController::class);
    Route::get('/get-candidates-details/{id}', [App\Http\Controllers\Admin\CandidateController::class, 'getCandidatesDetails'])->name('get-candidates-details');
    Route::get('get-candidates-list', [App\Http\Controllers\Admin\CandidateController::class, 'getCandidatesSearch'])->name('get-candidates-list');
    Route::delete('delete-additional-attachment/{id}', [App\Http\Controllers\Admin\CandidateController::class, 'deleteAttachment'])->name('delete-additional-attachment');
    Route::resource('users', UserController::class);
    Route::resource('interviews', InterviewController::class);
    Route::post('/update-password-profile', [App\Http\Controllers\HomeController::class, 'updatePasswordProfile'])->name('profile.password.update');
    Route::get('site-settings', [App\Http\Controllers\Admin\EnvController::class, 'getSiteDetails'])->name('get-site.details');
    Route::post('site-settings', [App\Http\Controllers\Admin\EnvController::class, 'updateSiteSettings'])->name('update-site.details');
    Route::get('mail-settings', [App\Http\Controllers\Admin\EnvController::class, 'getMailDetails'])->name('get-mail.details');
    Route::post('mail-settings', [App\Http\Controllers\Admin\EnvController::class, 'updateMailSettings'])->name('update-mail.details');
    Route::resource('pricing-plans', PricingPlanController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::post('add-client', [App\Http\Controllers\Admin\InvoiceController::class, 'addClient'])->name('add-client');
    Route::post('add-candidate', [App\Http\Controllers\Admin\InvoiceController::class, 'addCandidate'])->name('add-candidate');
    Route::get('mail-invoice/{id}/{emall}', [App\Http\Controllers\Admin\InvoiceController::class, 'mailInvoice'])->name('mail-invoice');
    Route::get('get-opportunity-matches/{id}', [App\Http\Controllers\Admin\JobOpportunityController::class, 'getMatches'])->name('get-opportunity-matches');
    Route::get('get-candidate-matches/{id}', [App\Http\Controllers\Admin\CandidateController::class, 'getMatches'])->name('get-candidate-matches');
    Route::resource('notes', NoteController::class);
    Route::post('upload-auto-resume', [App\Http\Controllers\Admin\CandidateController::class, 'uploadAutoResume'])->name('upload-auto-resume');
    Route::get('calendar', [App\Http\Controllers\Admin\InterviewController::class, 'calendar'])->name('view.calendar');
    Route::get('list-notes/{type}', [App\Http\Controllers\Admin\NoteController::class, 'listNotes'])->name('notes.list');
});

