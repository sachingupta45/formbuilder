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


Route::prefix('user')->group(function () {
    Route::get('/form/{form}', [App\Http\Controllers\User\FormController::class,'showForm'])->name('user.form');
    Route::post('/store', [App\Http\Controllers\User\FormController::class,'store'])->name('user.store');
    Route::get('/edit/{form}', [App\Http\Controllers\User\FormController::class, 'edit'])->name('user.form.edit');
    Route::post('/update/{form}', [App\Http\Controllers\User\FormController::class, 'update'])->name('user.form.update');


});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
   Route::resource('/role',RoleController::class);
   Route::resource('/form',FormDataController::class);
});




require __DIR__.'/auth.php';
