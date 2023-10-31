<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');
Route::middleware(['verified'])->group(function () {
    Route::resource('archetypes', App\Http\Controllers\ArchetypeController::class);
    Route::resource('attendances', App\Http\Controllers\AttendanceController::class);
    Route::resource('awards', App\Http\Controllers\AwardController::class);
    Route::resource('configurations', App\Http\Controllers\ConfigurationController::class);
    Route::resource('dues', App\Http\Controllers\DueController::class);
    Route::resource('events', App\Http\Controllers\EventController::class);
    Route::resource('issuances', App\Http\Controllers\IssuanceController::class);
    Route::resource('kingdoms', App\Http\Controllers\KingdomController::class);
    Route::resource('kingdom-offices', App\Http\Controllers\KingdomOfficeController::class);
    Route::resource('kingdom-titles', App\Http\Controllers\KingdomTitleController::class);
    Route::resource('locations', App\Http\Controllers\LocationController::class);
    Route::resource('meetups', App\Http\Controllers\MeetupController::class);
    Route::resource('members', App\Http\Controllers\MemberController::class);
    Route::resource('officers', App\Http\Controllers\OfficerController::class);
    Route::resource('offices', App\Http\Controllers\OfficeController::class);
    Route::resource('parkranks', App\Http\Controllers\ParkrankController::class);
    Route::resource('parks', App\Http\Controllers\ParkController::class);
    Route::resource('pronouns', App\Http\Controllers\PronounController::class);
    Route::resource('recommendations', App\Http\Controllers\RecommendationController::class);
    Route::resource('reconciliations', App\Http\Controllers\ReconciliationController::class);
    Route::resource('splits', App\Http\Controllers\SplitController::class);
    Route::resource('suspensions', App\Http\Controllers\SuspensionController::class);
    Route::resource('titles', App\Http\Controllers\TitleController::class);
    Route::resource('tournaments', App\Http\Controllers\TournamentController::class);
    Route::resource('transactions', App\Http\Controllers\TransactionController::class);
    Route::resource('units', App\Http\Controllers\UnitController::class);
    Route::resource('users', App\Http\Controllers\UserController::class);
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();



Route::get('phpmyinfo', function () {
    phpinfo(); 
})->name('phpmyinfo');
Route::resource('personas', App\Http\Controllers\PersonaController::class);