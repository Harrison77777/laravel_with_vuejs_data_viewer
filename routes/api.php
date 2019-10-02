<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api'], function(){
    route::get('all/customers', 'CustomerController@allCustomers')->name('all.customers');
    route::get('customer/details/{customerId}', 'CustomerController@customerDetails')->name('customer.details');
    route::post('add/customer', 'CustomerController@addCustomer')->name('add.customer');
    route::put('update/customer/{customerId}', 'CustomerController@updateCustomer')->name('update.customer');
    route::delete('delete/customer/{customerId}', 'CustomerController@deleteCustomer')->name('delete.customer');
    route::get('search/customer/{fieldName}/{query}', 'CustomerController@searchCustomer')->name('search.customer');
});