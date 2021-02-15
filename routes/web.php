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

Route::get('/', function () {
    return view('welcome');
})->name('/');



Auth::routes();
Route::middleware(['auth','accepted'])->group(function() {
 #========================================

  Route::resource('/clients','ClientController');
  Route::get('clients/destroy/{id}', 'ClientController@destroy');
 #========================================

  Route::resource('/banks','BankController');
  Route::get('banks/destroy/{id}', 'BankController@destroy');
 
 #========================================
  Route::get('/currencies', 'BankController@index_currency')->name('currencies.index');
  Route::post('/currencies', 'BankController@store_currency')->name('currencies.store');
  Route::get('/currencies/{currency}/delete', 'BankController@delete_currency')->name('currencies.delete');
  Route::get('/currencies/{currency}/edit', 'BankController@edit_currency')->name('currencies.edit');
  Route::put('/currencies/{currency}/update', 'BankController@update_currency')->name('currencies.update');
 #========================================


  Route::resource('/vendors','VendorController');
  Route::get('vendors/destroy/{id}', 'VendorController@destroy');
 #========================================

  Route::resource('/companies','CompanyController');
  Route::get('companies/destroy/{id}', 'CompanyController@destroy');
 #========================================

  Route::resource('/invoices','InvoiceController');
  Route::get('/invoices/{invoice}/print','InvoiceController@print')->name('invoices.print');
  Route::get('invoices/destroy/{id}', 'InvoiceController@destroy');
  Route::get('invoices/{invoice}/add_items','InvoiceController@add_item')->name('invoices.add_items');
  Route::post('invoices/{invoice}/add_items','InvoiceController@store_item')->name('invoices.store_items');
  Route::post('invoices/{invoice}/{item}/update_item','InvoiceController@update_item')->name('invoices.update_item');
  Route::get('invoices/{invoice}/{item}/delete_item','InvoiceController@delete_item')->name('invoices.delete_item');
  Route::get('invoices/{invoice}/{item}/edit_item','InvoiceController@edit_item')->name('invoices.edit_item');
 #========================================

  Route::resource('/vinvoices','VInvoiceController');
  Route::get('/vinvoices/{vinvoice}/print','VInvoiceController@print')->name('vinvoices.print');
  Route::get('vinvoices/destroy/{id}', 'VInvoiceController@destroy');
  Route::get('vinvoices/{vinvoice}/add_items','VInvoiceController@add_item')->name('vinvoices.add_items');
  Route::post('vinvoices/{vinvoice}/add_items','VInvoiceController@store_item')->name('vinvoices.store_items');
  Route::post('vinvoices/{vinvoice}/{item}/update_item','VInvoiceController@update_item')->name('vinvoices.update_item');
  Route::get('vinvoices/{vinvoice}/{item}/delete_item','VInvoiceController@delete_item')->name('vinvoices.delete_item');
  Route::get('vinvoices/{vinvoice}/{item}/edit_item','VInvoiceController@edit_item')->name('vinvoices.edit_item');
 #========================================

  Route::resource('/items','ItemController');
  Route::get('items/destroy/{id}', 'ItemController@destroy');
 #========================================

  Route::resource('/vitems','VItemController');
  Route::get('vitems/destroy/{id}', 'VItemController@destroy');
 #========================================

  Route::resource('/pitems','PaymentItemController');
  Route::get('pitems/destroy/{id}', 'PaymentItemController@destroy');
 #========================================

  Route::resource('/ritems','ReceiveItemController');
  Route::get('ritems/destroy/{id}', 'ReceiveItemController@destroy');
 #========================================

  Route::resource('/payment_p','PaymentPItemController');
  Route::get('payment_p/destroy/{id}', 'PaymentPItemController@destroy');
 #========================================

  Route::resource('/payment_r','PaymentRItemController');
  Route::get('payment_r/destroy/{id}', 'PaymentRItemController@destroy');

 #========================================

  Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});