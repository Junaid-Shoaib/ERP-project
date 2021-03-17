<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AccountGroupController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\YearController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Years

Route::get('years', [YearController::class, 'index'])
    ->name('years')
    ->middleware('auth');

Route::get('years/create', [YearController::class, 'create'])
    ->name('years.create')
    ->middleware('auth');

Route::get('years/{year}', [YearController::class, 'show'])
    ->name('years.show')
    ->middleware('auth');

Route::post('years', [YearController::class, 'store'])
    ->name('years.store')
    ->middleware('auth');

Route::get('years/{year}/edit', [YearController::class, 'edit'])
    ->name('years.edit')
    ->middleware('auth');

Route::put('years/{year}', [YearController::class, 'update'])
    ->name('years.update')
    ->middleware('auth');

Route::delete('years/{year}', [YearController::class, 'destroy'])
    ->name('years.destroy')
    ->middleware('auth');

//Documents

Route::get('documents', [DocumentController::class, 'index'])
->name('documents')
->middleware('auth');



Route::get('documents/create', [DocumentController::class, 'create'])
    ->name('documents.create')
    ->middleware('auth');

//     Route::get('doctypes/{doctype}', [DocumentController::class, 'show'])
//     ->name('doctypes.show')
//     ->middleware('auth');

// Route::post('doctypes', [DocumentController::class, 'store'])
//     ->name('doctypes.store')
//     ->middleware('auth');

//     Route::get('doctypes/{doctype}/edit', [DocumentController::class, 'edit'])
//     ->name('doctypes.edit')
//     ->middleware('auth');

//     Route::put('doctypes/{doctype}', [DocumentController::class, 'update'])
//     ->name('doctypes.update')
//     ->middleware('auth');

//     Route::delete('doctypes/{doctype}', [DocumentController::class, 'destroy'])
//     ->name('doctypes.destroy')
//     ->middleware('auth');


// DocumentType

Route::get('doctypes', [DocumentTypeController::class, 'index'])
->name('doctypes')
->middleware('auth');



Route::get('doctypes/create', [DocumentTypeController::class, 'create'])
    ->name('doctypes.create')
    ->middleware('auth');

    Route::get('doctypes/{doctype}', [DocumentTypeController::class, 'show'])
    ->name('doctypes.show')
    ->middleware('auth');

Route::post('doctypes', [DocumentTypeController::class, 'store'])
    ->name('doctypes.store')
    ->middleware('auth');

    Route::get('doctypes/{doctype}/edit', [DocumentTypeController::class, 'edit'])
    ->name('doctypes.edit')
    ->middleware('auth');

    Route::put('doctypes/{doctype}', [DocumentTypeController::class, 'update'])
    ->name('doctypes.update')
    ->middleware('auth');

    Route::delete('doctypes/{doctype}', [DocumentTypeController::class, 'destroy'])
    ->name('doctypes.destroy')
    ->middleware('auth');

//Account 

Route::get('accounts', [AccountController::class, 'index'])
->name('accounts')
->middleware('auth');


Route::get('accounts/create', [AccountController::class, 'create'])
    ->name('accounts.create')
    ->middleware('auth');

    Route::get('accounts/{company}', [AccountController::class, 'show'])
    ->name('accounts.show')
    ->middleware('auth');

Route::post('accounts', [AccountController::class, 'store'])
    ->name('accounts.store')
    ->middleware('auth');

    Route::get('accounts/{account}/edit', [AccountController::class, 'edit'])
    ->name('accounts.edit')
    ->middleware('auth');

    Route::put('accounts/{account}', [AccountController::class, 'update'])
    ->name('accounts.update')
    ->middleware('auth');

    Route::delete('accounts/{account}', [AccountController::class, 'destroy'])
    ->name('accounts.destroy')
    ->middleware('auth');

//Company 

Route::get('companies', [CompanyController::class, 'index'])
->name('companies')
->middleware('auth');


Route::get('companies/create', [CompanyController::class, 'create'])
    ->name('companies.create')
    ->middleware('auth');

    Route::get('companies/{company}', [CompanyController::class, 'show'])
    ->name('companies.show')
    ->middleware('auth');

Route::post('companies', [CompanyController::class, 'store'])
    ->name('companies.store')
    ->middleware('auth');

    Route::get('companies/{company}/edit', [CompanyController::class, 'edit'])
    ->name('companies.edit')
    ->middleware('auth');

    Route::put('companies/{company}', [CompanyController::class, 'update'])
    ->name('companies.update')
    ->middleware('auth');

    Route::delete('companies/{company}', [CompanyController::class, 'destroy'])
    ->name('companies.destroy')
    ->middleware('auth');

//Dashboard

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

//AccountGroups

Route::get('accountgroups', [AccountGroupController::class, 'index'])
    ->name('accountgroups')
    ->middleware('auth');

Route::get('accountgroups/create', [AccountGroupController::class, 'create'])
    ->name('accountgroups.create')
    ->middleware('auth');

Route::get('accountgroups/{accountgroup}', [AccountGroupController::class, 'show'])
    ->name('accountgroups.show')
    ->middleware('auth');

Route::post('accountgroups', [AccountGroupController::class, 'store'])
    ->name('accountgroups.store')
    ->middleware('auth');

Route::get('accountgroups/{accountgroup}/edit', [AccountGroupController::class, 'edit'])
    ->name('accountgroups.edit')
    ->middleware('auth');

Route::put('accountgroups/{accountgroup}', [AccountGroupController::class, 'update'])
    ->name('accountgroups.update')
    ->middleware('auth');

Route::delete('accountgroups/{accountgroup}', [AccountGroupController::class, 'destroy'])
    ->name('accountgroups.destroy')
    ->middleware('auth');


