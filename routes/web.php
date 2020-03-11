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
Route::get('/bootapp', 'BootappController@index')->name('bootapp');

Auth::routes([
  'register' => false, // Registration Routes...
]);

Route::get('/home', 'HomeController@index')->name('home');


/* Account Settings */
  Route::get('/account', 'AccountsController@index')->name('account.index');
  Route::get('/account/edit', 'AccountsController@edit');
  Route::patch('/account/update', 'AccountsController@update');
  Route::get('/account/password', 'AccountsController@changePassword');
  Route::patch('/account/password', 'AccountsController@updatePassword');
/* Account Settings */


/* Team Settings */
  Route::get('/team', 'TeamController@index')->name('team.index');
  Route::get('/team/profile/{user}', 'TeamController@profile')->name('team.profile');
  Route::get('/team/edit/{user}', 'TeamController@edit');
  Route::patch('/team/update/{user}', 'TeamController@update');
  Route::get('/team/activate/{user}', 'TeamController@activate');
  Route::get('/team/deactivate/{user}', 'TeamController@deactivate');
  Route::get('/team/create', 'TeamController@create');
  Route::post('/team/store', 'TeamController@store');
/* Team Settings */

/* App Settings */
  Route::get('/appsettings', 'AppsettingsController@index')->name('appsettings.index');
  Route::get('/appsettings/edit', 'AppsettingsController@edit');
  Route::patch('/appsettings/update', 'AppsettingsController@update');



  Route::get('/categories', 'AppsettingsController@categories')->name('categories.index');

  //Sectors
  Route::get('/categories/sectors', 'SectorsController@index')->name('sectors.index');
  Route::get('/categories/sectors/create', 'SectorsController@create');
  Route::post('/categories/sectors/store', 'SectorsController@store');
  Route::get('/categories/sectors/edit/{tid}', 'SectorsController@edit');
  Route::patch('/categories/sectors/update/{tid}', 'SectorsController@update');
  Route::get('/categories/sectors/deactivate/{tid}', 'SectorsController@deactivate');
  Route::get('/categories/sectors/activate/{tid}', 'SectorsController@activate');

  //Partners
  Route::get('/categories/partners', 'PartnersController@index')->name('partners.index');
  Route::get('/categories/partners/create', 'PartnersController@create');
  Route::post('/categories/partners/store', 'PartnersController@store');
  Route::get('/categories/partners/edit/{tid}', 'PartnersController@edit');
  Route::patch('/categories/partners/update/{tid}', 'PartnersController@update');
  Route::get('/categories/partners/deactivate/{tid}', 'PartnersController@deactivate');
  Route::get('/categories/partners/activate/{tid}', 'PartnersController@activate');

/* App Settings */