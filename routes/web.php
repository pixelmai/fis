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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/* Account Settings */
	Route::get('/account', 'AccountsController@index')->name('account.index');
	Route::get('/account/edit', 'AccountsController@edit')->name('account.edit');
	Route::patch('/account/update', 'AccountsController@update');
	Route::get('/account/password', 'AccountsController@changePassword');
	Route::patch('/account/password', 'AccountsController@updatePassword')->name('update.password');
/* Account Settings */


/* Team Settings */
	Route::get('/team', 'TeamController@index')->name('team.index');
	Route::get('/team/profile/{user}', 'TeamController@profile')->name('team.profile');
	Route::get('/team/edit/{user}', 'TeamController@edit')->name('team.edit');
	Route::patch('/team/update/{user}', 'TeamController@update');
	Route::get('/team/activate/{user}', 'TeamController@activate')->name('team.activate');
	Route::get('/team/deactivate/{user}', 'TeamController@deactivate')->name('team.deactivate');
/* Team Settings */


