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

Auth::routes([
	'register' => false, // Registration Routes...
]);

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
	Route::get('/team/create', 'TeamController@create');
	Route::post('/team/store', 'TeamController@store');
/* Team Settings */

/* App Settings */
	Route::get('/appsettings', 'AppsettingsController@index')->name('appsettings.index');
	Route::get('/appsettings/edit', 'AppsettingsController@edit')->name('appsettings.edit');
	Route::patch('/appsettings/update', 'AppsettingsController@update')->name('appsettings.update');

/* App Settings */