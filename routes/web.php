<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\FormDataController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RolePermissionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test');
});

Route::get('/dashboard', function () {
    return view('admin.users.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
   Route::resource('/role',RoleController::class);
   Route::resource('/form',FormDataController::class);
});

Route::middleware('auth')->prefix('roles')->name('admin.roles.')->group(function () {
    Route::get('/', [RolePermissionController::class, 'roleIndex'])->middleware(['permission:role-view'])->name('index');
    Route::get('/create/{role?}', [RolePermissionController::class, 'createOrUpdate'])->middleware(['permission:role-add', 'permission:role-edit'])->name('createOrUpdate');
    Route::post('/store/{role?}', [RolePermissionController::class, 'storeRole'])->middleware(['permission:role-add', 'permission:role-edit'])->name('store');
    Route::delete('/{role}', [RolePermissionController::class, 'destroy'])->middleware(['permission:role-delete'])->name('destroy');
});


require __DIR__.'/auth.php';
