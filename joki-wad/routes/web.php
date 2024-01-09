<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\billetController;

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

// Route::get('/', function () {
//     return view('dashboard');
// });

// login
Route::get('/', [loginController::class, 'index'])->name('login');
Route::post('/login', [loginController::class, 'login']);
Route::post('logout', [loginController::class, 'logout'])->name('logout');

// route group for dashboard
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [billetController::class, 'dashboard'])->name('dashboard');
    Route::get('/billet', [billetController::class, 'index'])->name('billet.index');
    Route::get('/billet/create', [billetController::class, 'create'])->name('billet.create');
    Route::post('/billet/store', [billetController::class, 'store'])->name('billet.store');
    Route::get('/billet/{id}/edit', [billetController::class, 'edit'])->name('billet.edit');
    Route::put('/billet/{id}', [billetController::class, 'update'])->name('billet.update');
    Route::delete('/billet/{id}', [billetController::class, 'destroy'])->name('billet.delete');
    Route::get('/logout', [loginController::class, 'logout'])->name('logout');
});


