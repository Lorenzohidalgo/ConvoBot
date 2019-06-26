<?php
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


Auth::routes();

Route::get('/', 'HomeController@index')->name('main-board');


Route::get('/users', 'UsersController@index')->name('users-main')->middleware(['auth', 'privilege.admin']);
Route::get('/users/create', 'UsersController@create')->name('users-create')->middleware(['auth', 'privilege.admin']);
Route::post('/users', 'UsersController@store')->name('users-store')->middleware(['auth', 'privilege.admin']);
Route::get('/users/{id}/edit', 'UsersController@edit')->name('users-edit')->middleware(['auth', 'privilege.admin']);
Route::post('/users/{id}', 'UsersController@update')->name('users-update')->middleware(['auth', 'privilege.admin']);
Route::delete('/users/{id}', 'UsersController@destroy')->name('users-delete')->middleware(['auth', 'privilege.admin']);
Route::get('/users/bot', 'BotUsersController@index')->name('users-bot')->middleware(['auth', 'privilege.admin']);
Route::get('profile', 'UsersController@viewProfile')->name('profile-view')->middleware(['auth']);
Route::get('profile/edit', 'UsersController@editProfile')->name('profile-edit')->middleware(['auth']);
Route::post('/profile/edit/{id}', 'UsersController@updateProfile')->name('profile-update')->middleware(['auth']);

Route::get('/teams', 'TeamController@index')->name('teams-main')->middleware(['auth']);
Route::get('/teams/{id}', 'TeamController@show')->name('teams-show')->middleware(['auth']);

Route::get('/teams/create', 'TeamController@index')->name('teams-create')->middleware(['auth', 'privilege.admin']);
Route::get('/teams/{id}/edit', 'TeamController@edit')->name('teams-edit')->middleware(['auth', 'privilege.admin']);
Route::post('/teams/{id}', 'TeamController@update')->name('teams-update')->middleware(['auth', 'privilege.admin']);
Route::get('/team/{id}/members', 'TeamController@updateMembersEdit')->name('teams-members')->middleware(['auth', 'privilege.admin']);
Route::delete('/teamdel/{id}/{teamid}', 'TeamController@Memberdestroy')->name('team-member-delete')->middleware(['auth', 'privilege.admin']);
Route::post('/teamadd/{teamid}', 'TeamController@storeNewMember')->name('team-member-add')->middleware(['auth', 'privilege.admin']);

Route::get('/convocations', 'ConvocationsController@index')->name('convo-main');
Route::get('/convocations/{id}', 'ConvocationsController@show')->name('convo-show');

Route::get('/statistics', 'StatisticsController@index')->name('statistics-main')->middleware(['auth']);
Route::get('/statistics/{id}', 'StatisticsController@show')->name('statistics-show')->middleware(['auth']);
