<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Admin Routes
// Route::middleware(['auth', 'verified'])-> prefix('admin')->group(function () {

    //index
    Route::get('', [AdminController::class, 'index']);

    //   /member
    Route:: prefix('member')->group(function () {

        Route::get('show', [MemberController::class, 'index']);
        // Route::get('add', [MemberController::class, 'create']);
        // Route::post('save', [MemberController::class, 'store'])->name('member.save');
    
        // Route::get('edit/{id}', [MemberController::class, 'edit'])->name('member.edit');
        // Route::post('update/{id}', [MemberController::class, 'update'])->name('member.update');
    });


// });



require __DIR__.'/auth.php';

