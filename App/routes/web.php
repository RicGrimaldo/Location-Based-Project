<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListFilesController;
use App\Http\Controllers\UbicationsController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/Welcome', 'App\Http\Controllers\UserController@index')->name('welcome');

Auth::routes();

Route::controller(ListFilesController::class)->prefix('Files')->group(function(){
    Route::delete('/{file}', 'destroy')->name('files.destroy');
    Route::get('/', 'index')->name('files');
    Route::get('/create', 'create')->name('files.create');
    Route::post('/', 'store')->name('files.store');
    
});

Route::get('/', [UbicationsController::class, 'index'])->name('ubications');
Route::controller(UbicationsController::class)->prefix('Ubications')->group(function () {
    Route::delete('/{ubication}', 'destroy')->name('ubications.destroy');
    Route::post('/', 'store')->name('ubications.store');
    Route::get('/list', 'list')->name('ubications.list');
    Route::post('/compare', 'compare')->name('ubications.compare');
});

Route::group(['middleware' => 'auth'], function() {
    Route::get('/changePassword',[HomeController::class, 'showChangePasswordGet'])->name('changePasswordGet');
    Route::post('/changePassword',[HomeController::class, 'changePasswordPost'])->name('changePasswordPost');
});