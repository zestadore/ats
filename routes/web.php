<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/migrate', function () {
    Artisan::call("migrate");
});

Route::get('/optimize', function () {
    Artisan::call("optimize");
    Artisan::call("cache:clear");
    Artisan::call("config:clear");
    Artisan::call("view:clear");
    Artisan::call("route:clear");
    Artisan::call("config:cache");
});

Route::get('/seed', function () {
    Artisan::call("db:seed");
});

Route::get('/profile', [App\Http\Controllers\HomeController::class, 'authUserProfile'])->name('profile')->middleware('auth');
Route::post('/update-profile', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('profile.update')->middleware('auth');
Route::get('/change-password', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('change.password')->middleware('auth');
Route::post('/change-password', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('update.password')->middleware('auth');
Route::get('/view-invoice/{id}', [App\Http\Controllers\Admin\InvoiceController::class, 'publicInvoice'])->name('view-invoice');
Route::get('/download-invoice/{id}', [App\Http\Controllers\Admin\InvoiceController::class, 'downloadInvoice'])->name('download-invoice');
Route::get('/company-signup', [App\Http\Controllers\RegisterController::class, 'companySignup'])->name('company-signup');
Route::post('/company-signup', [App\Http\Controllers\RegisterController::class, 'registerCompany'])->name('company-signup.register');
Route::get('/verify-email/{id}', [App\Http\Controllers\RegisterController::class, 'verifyEmail'])->name('verify-email');
Route::get('/update-candidates-ai', [App\Http\Controllers\HomeController::class, 'updateCandidatesAI']);
Route::get('/update-skills-ai', [App\Http\Controllers\HomeController::class, 'updateSkillsAI']);