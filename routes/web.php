<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PasswordController;

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
    return Redirect::to('/login');
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::resource('client', ClientController::class);
Route::get('client/{id}/edit', 'ClientController@edit')->name('client.edit');
Route::put('client/{id}', 'ClientController@update')->name('client.update');
Route::delete('client/{id}', 'ClientController@destroy')->name('client.destroy');
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/config', [AdminController::class, 'index'])->name('admin.config');
});
Route::middleware(['auth'])->get('/home', function () {
    return view('home');
})->name('home');
Route::middleware(['auth', 'is_resident_or_admin'])->get('/clients/residentiels', [ClientsController::class, 'residentiels'])->name('clients.residentiels');
Route::middleware(['auth', 'is_affaires_or_admin'])
    ->get('/clients/affaires', [ClientsController::class, 'affaires'])
    ->name('clients.affaires');
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users/store', [AdminUserController::class, 'store'])->name('admin.users.store');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/password/change', [PasswordController::class, 'showChangeForm'])->name('password.change.form');
    Route::post('/password/change', [PasswordController::class, 'change'])->name('password.change');
});
Route::middleware(['auth', 'is_admin'])->get('/admin/logs', function () {
    $logs = \App\Models\SecurityLog::with('user')->orderByDesc('created_at')->get();
    return view('admin.logs', compact('logs'));
})->name('admin.logs');

