<?php

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

Route::get('phpmyinfo', function () {
	phpinfo();
})->name('phpmyinfo');

Route::get('/{any}', function () {
	return view('index');
})->where('any', '.*');

Route::get('/email/verify/{id}/{hash}', function () {
	return view('index');
})->name('verification.verify');
