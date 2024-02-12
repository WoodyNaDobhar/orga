<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
	

Route::resource('accounts', App\Http\Controllers\API\AccountAPIController::class)
    ->except(['create', 'edit']);

Route::resource('archetypes', App\Http\Controllers\API\ArchetypeAPIController::class)
    ->except(['create', 'edit']);

Route::resource('attendances', App\Http\Controllers\API\AttendanceAPIController::class)
    ->except(['create', 'edit']);

Route::resource('awards', App\Http\Controllers\API\AwardAPIController::class)
    ->except(['create', 'edit']);

Route::resource('chapters', App\Http\Controllers\API\ChapterAPIController::class)
    ->except(['create', 'edit']);

Route::resource('chaptertypes', App\Http\Controllers\API\ChaptertypeAPIController::class)
    ->except(['create', 'edit']);

Route::resource('crats', App\Http\Controllers\API\CratAPIController::class)
    ->except(['create', 'edit']);

Route::resource('dues', App\Http\Controllers\API\DueAPIController::class)
    ->except(['create', 'edit']);

Route::resource('events', App\Http\Controllers\API\EventAPIController::class)
    ->except(['create', 'edit']);

Route::resource('guests', App\Http\Controllers\API\GuestAPIController::class)
    ->except(['create', 'edit']);

Route::resource('issuances', App\Http\Controllers\API\IssuanceAPIController::class)
    ->except(['create', 'edit']);

Route::resource('locations', App\Http\Controllers\API\LocationAPIController::class)
    ->except(['create', 'edit']);

Route::resource('meetups', App\Http\Controllers\API\MeetupAPIController::class)
    ->except(['create', 'edit']);

Route::resource('members', App\Http\Controllers\API\MemberAPIController::class)
    ->except(['create', 'edit']);

Route::resource('officers', App\Http\Controllers\API\OfficerAPIController::class)
    ->except(['create', 'edit']);

Route::resource('offices', App\Http\Controllers\API\OfficeAPIController::class)
    ->except(['create', 'edit']);

Route::resource('personas', App\Http\Controllers\API\PersonaAPIController::class)
    ->except(['create', 'edit']);

Route::resource('pronouns', App\Http\Controllers\API\PronounAPIController::class)
    ->except(['create', 'edit']);

Route::resource('realms', App\Http\Controllers\API\RealmAPIController::class)
    ->except(['create', 'edit']);

Route::resource('recommendations', App\Http\Controllers\API\RecommendationAPIController::class)
    ->except(['create', 'edit']);

Route::resource('reconciliations', App\Http\Controllers\API\ReconciliationAPIController::class)
    ->except(['create', 'edit']);

Route::resource('reigns', App\Http\Controllers\API\ReignAPIController::class)
    ->except(['create', 'edit']);

Route::resource('socials', App\Http\Controllers\API\SocialAPIController::class)
    ->except(['create', 'edit']);

Route::resource('splits', App\Http\Controllers\API\SplitAPIController::class)
    ->except(['create', 'edit']);

Route::resource('suspensions', App\Http\Controllers\API\SuspensionAPIController::class)
    ->except(['create', 'edit']);

Route::resource('titles', App\Http\Controllers\API\TitleAPIController::class)
    ->except(['create', 'edit']);

Route::resource('tournaments', App\Http\Controllers\API\TournamentAPIController::class)
    ->except(['create', 'edit']);

Route::resource('transactions', App\Http\Controllers\API\TransactionAPIController::class)
    ->except(['create', 'edit']);

Route::resource('units', App\Http\Controllers\API\UnitAPIController::class)
    ->except(['create', 'edit']);

Route::resource('users', App\Http\Controllers\API\UserAPIController::class)
    ->except(['create', 'edit']);

Route::resource('waivers', App\Http\Controllers\API\WaiverAPIController::class)
    ->except(['create', 'edit']);