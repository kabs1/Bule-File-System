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
use App\Http\Controllers\BackupController; // Import BackupController
use App\Http\Controllers\ActivityLogController; // Import ActivityLogController

// Main Page Route
Route::get('/', function () {
    return redirect()->route('login');
});



// locale
Route::get('/lang/{locale}', [LanguageController::class, 'swap']);
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [Page2::class, 'index'])->name('dashboard');

    Route::get('/roles', [RoleController::class, 'index'])->middleware('can:view role')->name('roles');
    Route::get('/permissions', [PermissionController::class, 'index'])->middleware('can:view permission')->name('permissions');
    Route::get('/users', [UserController::class, 'index'])->name('users');

    // User Management Routes
    Route::get('/app/users/list', [UserController::class, 'list'])->name('users.list');
    Route::post('/app/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/app/users/{user}', [UserController::class, 'show'])->name('users.show'); // Added route for fetching single user
    Route::put('/app/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/app/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit'); // This route is not currently used by JS for fetching, but kept for consistency
    Route::delete('/app/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::put('/app/users/{user}/suspend', [UserController::class, 'suspend'])->name('users.suspend');
    Route::put('/app/users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');

    // Customer Management Routes
    Route::group(['prefix' => 'app'], function () {
        Route::get('customers/list', [App\Http\Controllers\CustomerController::class, 'list'])->name('customers.list');
        Route::resource('customers', App\Http\Controllers\CustomerController::class);
        Route::put('customers/{customer}/suspend', [App\Http\Controllers\CustomerController::class, 'suspend'])->name('customers.suspend');
        Route::put('customers/{customer}/activate', [App\Http\Controllers\CustomerController::class, 'activate'])->name('customers.activate');
    });

    // Role Management Routes
    Route::get('/app/roles/list', [RoleController::class, 'list'])->name('roles.list');
    Route::post('/app/roles', [RoleController::class, 'store'])->middleware('can:create role')->name('roles.store');
    Route::get('/app/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
    Route::put('/app/roles/{role}', [RoleController::class, 'update'])->middleware('can:update role')->name('roles.update');
    Route::delete('/app/roles/{role}', [RoleController::class, 'destroy'])->middleware('can:delete role')->name('roles.destroy');

    // Permission Management Routes
    Route::get('/app/permissions/list', [PermissionController::class, 'list'])->name('permissions.list');
    Route::post('/app/permissions', [PermissionController::class, 'store'])->middleware('can:create permission')->name('permissions.store');
    Route::get('/app/permissions/{permission}', [PermissionController::class, 'show'])->name('permissions.show');
    Route::put('/app/permissions/{permission}', [PermissionController::class, 'update'])->middleware('can:update permission')->name('permissions.update');
    Route::delete('/app/permissions/{permission}', [PermissionController::class, 'destroy'])->middleware('can:delete permission')->name('permissions.destroy');

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
    Route::get('/app/currencies/list', [App\Http\Controllers\CurrencyController::class, 'list'])->name('currencies.list');

    // Measure Unit Management Routes
    Route::resource('measure-units', App\Http\Controllers\MeasureUnitController::class);
    Route::get('/app/measure-units/list', [App\Http\Controllers\MeasureUnitController::class, 'list'])->name('measure-units.list');

    // Customer Management Routes (already moved above)
    // Route::resource('customers', App\Http\Controllers\CustomerController::class);
    // Route::get('/app/customers/list', [App\Http\Controllers\CustomerController::class, 'list'])->name('customers.list');

    // Backup Management Routes
    Route::group(['prefix' => 'backups', 'as' => 'backups.'], function () {
        Route::get('/', [BackupController::class, 'index'])->name('index');
        Route::get('/list', [BackupController::class, 'list'])->name('list');
        Route::post('/create', [BackupController::class, 'create'])->name('create');
        Route::get('/download/{disk}/{path}', [BackupController::class, 'download'])->name('download')->where('path', '.*');
        Route::delete('/delete/{disk}/{path}', [BackupController::class, 'delete'])->name('delete')->where('path', '.*');
    });

    // Activity Log Routes
    Route::group(['prefix' => 'activity-log', 'as' => 'activity-log.'], function () {
        Route::get('/', [ActivityLogController::class, 'index'])->name('index');
        Route::get('/list', [ActivityLogController::class, 'list'])->name('list');
        Route::delete('/delete/{id}', [ActivityLogController::class, 'destroy'])->name('delete');
    });
});
