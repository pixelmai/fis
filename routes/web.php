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


  //Services
  Route::get('/categories/services', 'ServcatsController@index')->name('services.index');
  Route::get('/categories/services/create', 'ServcatsController@create');
  Route::post('/categories/services/store', 'ServcatsController@store');
  Route::get('/categories/services/edit/{tid}', 'ServcatsController@edit');
  Route::patch('/categories/services/update/{tid}', 'ServcatsController@update');
  Route::get('/categories/services/deactivate/{tid}', 'ServcatsController@deactivate');
  Route::get('/categories/services/activate/{tid}', 'ServcatsController@activate');

  //Registrations
  Route::get('/categories/registrations', 'RegcatsController@index')->name('registrations.index');

  Route::get('/categories/registrations', 'RegcatsController@index')->name('registrations.index');
  Route::get('/categories/registrations/create', 'RegcatsController@create');
  Route::post('/categories/registrations/store', 'RegcatsController@store');
  Route::get('/categories/registrations/edit/{tid}', 'RegcatsController@edit');
  Route::patch('/categories/registrations/update/{tid}', 'RegcatsController@update');
  Route::get('/categories/registrations/deactivate/{tid}', 'RegcatsController@deactivate');
  Route::get('/categories/registrations/activate/{tid}', 'RegcatsController@activate');


  Route::get('/categories/registrations/msmecreate', 'RegcatsController@msmecreate');
  Route::post('/categories/registrations/msmestore', 'RegcatsController@msmestore');
  Route::get('/categories/registrations/msmeedit/{tid}', 'RegcatsController@msmeedit');
  Route::patch('/categories/registrations/msmeupdate/{tid}', 'RegcatsController@msmeupdate');
  Route::get('/categories/registrations/msmedeactivate/{tid}', 'RegcatsController@msmedeactivate');
  Route::get('/categories/registrations/msmeactivate/{tid}', 'RegcatsController@msmeactivate');


/* App Settings */

/* Clients */
  Route::get('/clients', 'ClientsController@index');
  Route::get('/clients/create', 'ClientsController@create');
  Route::post('/clients/create', 'ClientsController@store');
  Route::get('/clients/edit/{id}', 'ClientsController@edit');
  Route::patch('/clients/edit/{id}', 'ClientsController@update');
  Route::get('/clients/view/{id}', 'ClientsController@view');
  Route::get('/clients/destroy/{id}', 'ClientsController@destroy');
  Route::get('/clients/autocomplete', 'ClientsController@autocomplete')->name('clientsauto');
  Route::get('/clients/invoiceautocomplete', 'ClientsController@invoiceautocomplete')->name('clientinvoiceauto');


  Route::get('/clients/deactivate/{id}', 'ClientsController@deactivate');
  Route::get('/clients/activate/{id}', 'ClientsController@activate');
  Route::get('/clients/massdeac', 'ClientsController@massdeac');
  Route::get('/clients/massacti', 'ClientsController@massacti');

  Route::post('/clients/modalStore', 'ClientsController@modalStore');
/* Clients */


/* Companies */
  Route::get('/companies', 'CompaniesController@index');
  Route::get('/companies/create', 'CompaniesController@create');
  Route::post('/companies/create', 'CompaniesController@store');
  Route::post('/companies/modalStore', 'CompaniesController@modalStore');
  Route::get('/companies/edit/{id}', 'CompaniesController@edit');
  Route::patch('/companies/edit/{id}', 'CompaniesController@update');
  Route::get('/companies/view/{id}', 'CompaniesController@view');
  Route::get('/companies/destroy/{id}', 'CompaniesController@destroy');
  Route::get('/companies/massrem', 'CompaniesController@massrem');
  Route::get('/companies/autocomplete', 'CompaniesController@autocomplete')->name('companiesauto');
  Route::get('/companies/invoiceautocomplete', 'CompaniesController@invoiceautocomplete')->name('companyinvoiceauto');
/* Companies */


/* Projects */
  Route::get('/projects', 'ProjectsController@index'); 
  Route::get('/projects/create', 'ProjectsController@create');
  Route::post('/projects/create', 'ProjectsController@store');
  Route::post('/projects/modalStore', 'ProjectsController@modalStore');
  Route::get('/projects/edit/{id}', 'ProjectsController@edit');
  Route::patch('/projects/edit/{id}', 'ProjectsController@update');
  Route::get('/projects/view/{id}', 'ProjectsController@view');
  Route::get('/projects/destroy/{id}', 'ProjectsController@destroy');
  Route::post('/projects/status', 'ProjectsController@status');
/* Projects */


/* Suppliers */
  Route::get('/suppliers', 'SuppliersController@index'); 
  Route::get('/suppliers/create', 'SuppliersController@create');
  Route::post('/suppliers/create', 'SuppliersController@store');
  Route::get('/suppliers/edit/{id}', 'SuppliersController@edit');
  Route::patch('/suppliers/edit/{id}', 'SuppliersController@update');
  Route::get('/suppliers/view/{id}', 'SuppliersController@view');
  Route::get('/suppliers/destroy/{id}', 'SuppliersController@destroy');
  Route::get('/suppliers/autocomplete', 'SuppliersController@autocomplete')->name('suppliersauto');

  Route::get('/suppliers/deactivate/{id}', 'SuppliersController@deactivate');
  Route::get('/suppliers/activate/{id}', 'SuppliersController@activate');
  Route::get('/suppliers/massdeac', 'SuppliersController@massdeac');
  Route::get('/suppliers/massacti', 'SuppliersController@massacti');
  
/* Suppliers */

/* Tools */
  Route::get('/tools', 'ToolsController@index'); 
  Route::get('/tools/create', 'ToolsController@create');
  Route::post('/tools/create', 'ToolsController@store');
  Route::get('/tools/edit/{id}', 'ToolsController@edit');
  Route::patch('/tools/edit/{id}', 'ToolsController@update');
  Route::get('/tools/view/{id}', 'ToolsController@view');
  Route::get('/tools/destroy/{id}', 'ToolsController@destroy');
  Route::post('/tools/status', 'ToolsController@status');
  Route::post('/tools/status/edit', 'ToolsController@statusedit');
  Route::get('/tools/status/destroy/{id}', 'ToolsController@statusdestroy');

  Route::get('/tools/deactivate/{id}', 'ToolsController@deactivate');
  Route::get('/tools/activate/{id}', 'ToolsController@activate');

/* Tools */


/* Machines */
  Route::get('/machines', 'MachinesController@index');
  Route::get('/machines/create', 'MachinesController@create');
  Route::post('/machines/create', 'MachinesController@store');
  Route::get('/machines/edit/{id}', 'MachinesController@edit');
  Route::patch('/machines/edit/{id}', 'MachinesController@update');
  Route::get('/machines/view/{id}', 'MachinesController@view');
  Route::get('/machines/destroy/{id}', 'MachinesController@destroy');
  Route::post('/machines/status', 'MachinesController@status');
  Route::post('/machines/status/edit', 'MachinesController@statusedit');
  Route::get('/machines/status/destroy/{id}', 'MachinesController@statusdestroy');

  Route::get('/machines/deactivate/{id}', 'MachinesController@deactivate');
  Route::get('/machines/activate/{id}', 'MachinesController@activate');
  Route::get('/machines/autocomplete', 'MachinesController@autocomplete')->name('machinesauto');

/* Machines */



/* Services */
  Route::get('/services', 'ServicesController@index'); 
  Route::get('/services/create', 'ServicesController@create');
  Route::post('/services/create', 'ServicesController@store');
  Route::get('/services/edit/{id}', 'ServicesController@edit');
  Route::patch('/services/edit/{id}', 'ServicesController@update');
  Route::get('/services/view/{id}', 'ServicesController@view');
  Route::get('/services/destroy/{id}', 'ServicesController@destroy');


  Route::get('/services/deactivate/{id}', 'ServicesController@deactivate');
  Route::get('/services/activate/{id}', 'ServicesController@activate');
/* Services */


/* Invoices */
  Route::get('/invoices', 'InvoicesController@index'); 
  Route::get('/invoices/create', 'InvoicesController@create');
  Route::post('/invoices/create', 'InvoicesController@store');
  Route::get('/invoices/edit/{id}', 'InvoicesController@edit');
  Route::patch('/invoices/edit/{id}', 'InvoicesController@update');
  Route::get('/invoices/view/{id}', 'InvoicesController@view');
  Route::get('/invoices/destroy/{id}', 'InvoicesController@destroy');


  Route::get('/invoices/deactivate/{id}', 'InvoicesController@deactivate');
  Route::get('/invoices/activate/{id}', 'InvoicesController@activate');
/* Invoices */


  Route::get('/clientsList', 'ClientsController@dblist');
  Route::get('/companiesList', 'CompaniesController@dblist');


