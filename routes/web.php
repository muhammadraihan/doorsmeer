<?php

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
    // check if user is auth then redirect to dashboard page
    if(Auth::check()) {
        return redirect()->route('backoffice.dashboard');
    }
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'backoffice', 'middleware' => ['auth']], function() {
    // backoffice route
    Route::get('/', 'DashboardController@index');
    Route::get('dashboard','DashboardController@dashboard')->name('backoffice.dashboard');
    Route::get('logs','ActivityController@index')->name('logs');
    Route::resource('users','UserController');
    Route::resource('permissions', 'PermissionController');
    Route::resource('roles', 'RoleController');
    Route::resource('package', 'PackageController');
    Route::resource('vehicle', 'VehicleController');
    Route::resource('unit', 'UnitController');
    Route::resource('item', 'ItemController');
    Route::resource('stock', 'StockController');
    Route::resource('stock_request', 'StockRequestController');
    Route::resource('expenses', 'ExpensesController');
    Route::resource('washjob', 'WashJobController');
    Route::resource('washtransaction', 'WashTransactionController');
    Route::get('vehiclename', 'WashJobController@vehicleName')->name('get.vehicleName');
    Route::get('packageprice', 'WashTransactionController@pricePackage')->name('get.pricePackage');
    Route::get('packageitem', 'WashTransactionController@priceItem')->name('get.priceItem');



    // user Profile
    Route::get('profile', 'UserController@profile')->name('profile');
    Route::patch('profile/{user}/update','UserController@ProfileUpdate')->name('profile.update');
    Route::patch('profile/{user}/password','UserController@ChangePassword')->name('profile.password');
});