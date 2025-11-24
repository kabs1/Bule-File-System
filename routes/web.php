<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\SettingController; // Explicitly import SettingController

// Main Page Route
Route::get('/', function () {
    return redirect()->route('login');
});



// locale
Route::get('/lang/{locale}', [LanguageController::class, 'swap']);
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [Page2::class, 'index'])->name('dashboard');

    Route::get('/roles', [RoleController::class, 'index'])->name('roles');
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions');
    Route::get('/users', [UserController::class, 'index'])->name('users');

    // User Management Routes
    Route::get('/app/users/list', [UserController::class, 'list'])->name('users.list');
    Route::post('/app/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/app/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/app/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::delete('/app/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Role Management Routes
    Route::get('/app/roles/list', [RoleController::class, 'list'])->name('roles.list');
    Route::post('/app/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/app/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
    Route::put('/app/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/app/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    // Permission Management Routes
    Route::get('/app/permissions/list', [PermissionController::class, 'list'])->name('permissions.list');
    Route::post('/app/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/app/permissions/{permission}', [PermissionController::class, 'show'])->name('permissions.show');
    Route::put('/app/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/app/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    // Branch Management Routes
    Route::get('/app/branches', [BranchController::class, 'index'])->name('branches.index');
    Route::post('/app/branches', [BranchController::class, 'store'])->name('branches.store');
    Route::get('/app/branches/{branch}', [BranchController::class, 'show'])->name('branches.show');
    Route::put('/app/branches/{branch}', [BranchController::class, 'update'])->name('branches.update');
    Route::delete('/app/branches/{branch}', [BranchController::class, 'destroy'])->name('branches.destroy');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Currency Management Routes
    Route::resource('currencies', App\Http\Controllers\CurrencyController::class);

    // Measure Unit Management Routes
    Route::resource('measure-units', App\Http\Controllers\MeasureUnitController::class);
});
