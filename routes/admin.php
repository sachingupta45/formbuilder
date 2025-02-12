<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FormDataController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\App;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth','verified'])->group(function () {
    Route::get('/dashboard', function () {return view('admin.users.index'); })->name('dashboard');


    Route::middleware(['auth'])->group(function () {

        Route::resource('/role',RoleController::class);
        Route::resource('/form',FormDataController::class);

        Route::get('/logout1', function () {
            Auth::logout();
            return redirect('/');
        });
    });

    Route::middleware(['auth'])->prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RolePermissionController::class, 'roleIndex'])->middleware(['permission:role-view'])->name('index');
        Route::get('/create/{role?}', [RolePermissionController::class, 'createOrUpdate'])->middleware(['permission:role-add', 'permission:role-edit'])->name('createOrUpdate');
        Route::post('/store/{role?}', [RolePermissionController::class, 'storeRole'])->middleware(['permission:role-add', 'permission:role-edit'])->name('store');
        Route::delete('/{role}', [RolePermissionController::class, 'destroy'])->middleware(['permission:role-delete'])->name('destroy');
    });

        // User Management
        Route::middleware(['auth'])->prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->middleware(['permission:user-view'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->middleware(['permission:user-add'])->name('create');
            Route::post('/', [UserController::class, 'store'])->middleware(['permission:user-add'])->name('store');
            Route::get('/{id}/show', [UserController::class, 'show'])->middleware(['permission:user-view'])->name('show');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->middleware(['permission:user-edit'])->name('edit');
            Route::put('/{id}', [UserController::class, 'update'])->middleware(['permission:user-edit'])->name('update');
            Route::delete('/{id}/delete', [UserController::class, 'destroy'])->middleware(['permission:user-delete'])->name('destroy');
            Route::delete('/{user}/remove-profile-pic', [UserController::class, 'removeProfilePic'])->middleware(['permission:user-edit'])->name('remove_profile_pic');
            Route::post('/status/{user}', [UserController::class, 'updateStatus'])->middleware(['permission:user-edit'])->name('status');
        });
});

require __DIR__.'/auth.php';
