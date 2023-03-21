<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\QuotationController;
use Illuminate\Support\Facades\Auth;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin',function(){
    return view('admin');
})->name('admin')->middleware('admin');

Route::get('/owner',function(){
    return view('owner');
})->name('owner')->middleware('owner');

Route::get('/customer',function(){
    return view('customer');
})->name('customer')->middleware('customer');


Route::resource('prescriptions', PrescriptionController::class);

Route::resource('quotations', QuotationController::class);

Route::get('quotations/getPrice/{id}', [QuotationController::class, 'getPrice']);
