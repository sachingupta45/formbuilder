<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FormDataController;
use App\Http\Controllers\Admin\RoleController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {return view('admin.users.index'); })->name('dashboard');


    Route::middleware('auth')->group(function () {
    
        Route::resource('/role',RoleController::class);
        Route::resource('/form',FormDataController::class);
    });
});

require __DIR__.'/auth.php';