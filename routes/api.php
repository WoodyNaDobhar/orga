<?php

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

//logged in
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
	
	Route::post('sendInvite', 'BaseAPIController@sendInvite');
	Route::post('logout', 'BaseAPIController@logout');
	Route::post('image', 'BaseAPIController@image');
	
	Route::get('accounts', 'AccountAPIController@index');
	Route::post('accounts', 'AccountAPIController@store');
	Route::get('accounts/{id}', 'AccountAPIController@show');
	Route::put('accounts/{id}', 'AccountAPIController@update');
	Route::delete('accounts/{id}', 'AccountAPIController@destroy');
	
	Route::post('archetypes', 'ArchetypeAPIController@store');
	Route::put('archetypes/{id}', 'ArchetypeAPIController@update');
	Route::delete('archetypes/{id}', 'ArchetypeAPIController@destroy');
	
	Route::post('attendances', 'AttendanceAPIController@store');
	Route::put('attendances/{id}', 'AttendanceAPIController@update');
	Route::delete('attendances/{id}', 'AttendanceAPIController@destroy');
	
	Route::post('awards', 'AwardAPIController@store');
	Route::put('awards/{id}', 'AwardAPIController@update');
	Route::delete('awards/{id}', 'AwardAPIController@destroy');
	
	Route::post('chapters', 'ChapterAPIController@store');
	Route::put('chapters/{id}', 'ChapterAPIController@update');
	Route::delete('chapters/{id}', 'ChapterAPIController@destroy');
	
	Route::post('chaptertypes', 'ChaptertypeAPIController@store');
	Route::put('chaptertypes/{id}', 'ChaptertypeAPIController@update');
	Route::delete('chaptertypes/{id}', 'ChaptertypeAPIController@destroy');
	
	Route::post('crats', 'CratAPIController@store');
	Route::put('crats/{id}', 'CratAPIController@update');
	Route::delete('crats/{id}', 'CratAPIController@destroy');
	
	Route::post('dues', 'DueAPIController@store');
	Route::put('dues/{id}', 'DueAPIController@update');
	Route::delete('dues/{id}', 'DueAPIController@destroy');
	
	Route::post('events', 'EventAPIController@store');
	Route::put('events/{id}', 'EventAPIController@update');
	Route::delete('events/{id}', 'EventAPIController@destroy');
	
	Route::post('guests', 'GuestAPIController@store');
	Route::put('guests/{id}', 'GuestAPIController@update');
	Route::delete('guests/{id}', 'GuestAPIController@destroy');
	
	Route::post('issuances', 'IssuanceAPIController@store');
	Route::put('issuances/{id}', 'IssuanceAPIController@update');
	Route::delete('issuances/{id}', 'IssuanceAPIController@destroy');
	
	Route::post('locations', 'LocationAPIController@store');
	Route::put('locations/{id}', 'LocationAPIController@update');
	Route::delete('locations/{id}', 'LocationAPIController@destroy');
	
	Route::post('meetups', 'MeetupAPIController@store');
	Route::put('meetups/{id}', 'MeetupAPIController@update');
	Route::delete('meetups/{id}', 'MeetupAPIController@destroy');
	
	Route::post('members', 'MemberAPIController@store');
	Route::put('members/{id}', 'MemberAPIController@update');
	Route::delete('members/{id}', 'MemberAPIController@destroy');
	
	Route::post('officers', 'OfficerAPIController@store');
	Route::put('officers/{id}', 'OfficerAPIController@update');
	Route::delete('officers/{id}', 'OfficerAPIController@destroy');
	
	Route::post('offices', 'OfficeAPIController@store');
	Route::put('offices/{id}', 'OfficeAPIController@update');
	Route::delete('offices/{id}', 'OfficeAPIController@destroy');
	
	Route::post('personas', 'PersonaAPIController@store');
	Route::put('personas/{id}', 'PersonaAPIController@update');
	Route::delete('personas/{id}', 'PersonaAPIController@destroy');
	
	Route::post('pronouns', 'PronounAPIController@store');
	Route::put('pronouns/{id}', 'PronounAPIController@update');
	Route::delete('pronouns/{id}', 'PronounAPIController@destroy');
	
	Route::post('realms', 'RealmAPIController@store');
	Route::put('realms/{id}', 'RealmAPIController@update');
	Route::delete('realms/{id}', 'RealmAPIController@destroy');
	
	Route::post('recommendations', 'RecommendationAPIController@store');
	Route::put('recommendations/{id}', 'RecommendationAPIController@update');
	Route::delete('recommendations/{id}', 'RecommendationAPIController@destroy');
	
	Route::post('reconciliations', 'ReconciliationAPIController@store');
	Route::put('reconciliations/{id}', 'ReconciliationAPIController@update');
	Route::delete('reconciliations/{id}', 'ReconciliationAPIController@destroy');
	
	Route::post('reigns', 'ReignAPIController@store');
	Route::put('reigns/{id}', 'ReignAPIController@update');
	Route::delete('reigns/{id}', 'ReignAPIController@destroy');
	
	Route::post('socials', 'SocialAPIController@store');
	Route::put('socials/{id}', 'SocialAPIController@update');
	Route::delete('socials/{id}', 'SocialAPIController@destroy');
	
	Route::get('splits', 'SplitAPIController@index');
	Route::post('splits', 'SplitAPIController@store');
	Route::get('splits/{id}', 'SplitAPIController@show');
	Route::put('splits/{id}', 'SplitAPIController@update');
	Route::delete('splits/{id}', 'SplitAPIController@destroy');
	
	Route::post('suspensions', 'SuspensionAPIController@store');
	Route::put('suspensions/{id}', 'SuspensionAPIController@update');
	Route::delete('suspensions/{id}', 'SuspensionAPIController@destroy');
	
	Route::post('titles', 'TitleAPIController@store');
	Route::put('titles/{id}', 'TitleAPIController@update');
	Route::delete('titles/{id}', 'TitleAPIController@destroy');
	
	Route::post('tournaments', 'TournamentAPIController@store');
	Route::put('tournaments/{id}', 'TournamentAPIController@update');
	Route::delete('tournaments/{id}', 'TournamentAPIController@destroy');
	
	Route::get('transactions', 'TransactionAPIController@index');
	Route::post('transactions', 'TransactionAPIController@store');
	Route::get('transactions/{id}', 'TransactionAPIController@show');
	Route::put('transactions/{id}', 'TransactionAPIController@update');
	Route::delete('transactions/{id}', 'TransactionAPIController@destroy');
	
	Route::post('units', 'UnitAPIController@store');
	Route::put('units/{id}', 'UnitAPIController@update');
	Route::delete('units/{id}', 'UnitAPIController@destroy');
	
	Route::post('users', 'UserAPIController@store');
	Route::put('users/{id}', 'UserAPIController@update');
	Route::delete('users/{id}', 'UserAPIController@destroy');
	
	Route::get('waivers', 'WaiverAPIController@index');
	Route::post('waivers', 'WaiverAPIController@store');
	Route::get('waivers/{id}', 'WaiverAPIController@show');
	Route::put('waivers/{id}', 'WaiverAPIController@update');
	Route::delete('waivers/{id}', 'WaiverAPIController@destroy');
});
	
Route::get('images', 'BaseAPIController@images');
Route::post('login', 'BaseAPIController@login');
Route::middleware(['throttle:1,5'])->group(function () {
	Route::post('forgot', 'BaseAPIController@forgot');
});
Route::middleware(['throttle:1,1'])->group(function () {
	Route::post('check', 'BaseAPIController@check');
});
Route::post('reset', 'BaseAPIController@reset');
Route::post('update', 'BaseAPIController@updatePassword');
Route::post('register', 'BaseAPIController@register');
Route::post('search', 'BaseAPIController@search');

Route::get('archetypes', 'ArchetypeAPIController@index');
Route::get('archetypes/{id}', 'ArchetypeAPIController@show');
Route::get('attendances', 'AttendanceAPIController@index');
Route::get('attendances/{id}', 'AttendanceAPIController@show');
Route::get('awards', 'AwardAPIController@index');
Route::get('awards/{id}', 'AwardAPIController@show');
Route::get('chapters', 'ChapterAPIController@index');
Route::get('chapters/{id}', 'ChapterAPIController@show');
Route::get('chaptertypes', 'ChaptertypeAPIController@index');
Route::get('chaptertypes/{id}', 'ChaptertypeAPIController@show');
Route::get('crats', 'CratAPIController@index');
Route::get('crats/{id}', 'CratAPIController@show');
Route::get('dues', 'DueAPIController@index');
Route::get('dues/{id}', 'DueAPIController@show');
Route::get('events', 'EventAPIController@index');
Route::get('events/{id}', 'EventAPIController@show');
Route::get('guests', 'GuestAPIController@index');
Route::get('guests/{id}', 'GuestAPIController@show');
Route::get('issuances', 'IssuanceAPIController@index');
Route::get('issuances/{id}', 'IssuanceAPIController@show');
Route::get('locations', 'LocationAPIController@index');
Route::get('locations/{id}', 'LocationAPIController@show');
Route::get('meetups', 'MeetupAPIController@index');
Route::get('meetups/{id}', 'MeetupAPIController@show');
Route::get('members', 'MemberAPIController@index');
Route::get('members/{id}', 'MemberAPIController@show');
Route::get('officers', 'OfficerAPIController@index');
Route::get('officers/{id}', 'OfficerAPIController@show');
Route::get('offices', 'OfficeAPIController@index');
Route::get('offices/{id}', 'OfficeAPIController@show');
Route::get('personas', 'PersonaAPIController@index');
Route::get('personas/{id}', 'PersonaAPIController@show');
Route::get('pronouns', 'PronounAPIController@index');
Route::get('pronouns/{id}', 'PronounAPIController@show');
Route::get('realms', 'RealmAPIController@index');
Route::get('realms/{id}', 'RealmAPIController@show');
Route::get('recommendations', 'RecommendationAPIController@index');
Route::get('recommendations/{id}', 'RecommendationAPIController@show');
Route::get('reconciliations', 'ReconciliationAPIController@index');
Route::get('reconciliations/{id}', 'ReconciliationAPIController@show');
Route::get('reigns', 'ReignAPIController@index');
Route::get('reigns/{id}', 'ReignAPIController@show');
Route::get('socials', 'SocialAPIController@index');
Route::get('socials/{id}', 'SocialAPIController@show');
Route::get('suspensions', 'SuspensionAPIController@index');
Route::get('suspensions/{id}', 'SuspensionAPIController@show');
Route::get('titles', 'TitleAPIController@index');
Route::get('titles/{id}', 'TitleAPIController@show');
Route::get('tournaments', 'TournamentAPIController@index');
Route::get('tournaments/{id}', 'TournamentAPIController@show');
Route::get('units', 'UnitAPIController@index');
Route::get('units/{id}', 'UnitAPIController@show');
Route::get('users', 'UserAPIController@index');
Route::get('users/{id}', 'UserAPIController@show');