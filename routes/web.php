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
 
  Route::resource('/paymenttypes','PaymentMethodController');
  #========================================


  Route::resource('/vendors','VendorController');
  Route::get('vendors/destroy/{id}', 'VendorController@destroy');

  Route::resource('/receivedpayments','ReceivedPaymentController');
  Route::get('receivedpayments/destroy/{id}', 'ReceivedPaymentController@destroy');
  
  Route::resource('/donepayments','DonePaymentController');
  Route::get('donepayments/destroy/{id}', 'DonePaymentController@destroy');

  Route::resource('/cmodels','CModelController');
  Route::get('cmodels/destroy/{id}', 'CModelController@destroy');

  Route::resource('/vmodels','VModelController');
  Route::get('vmodels/destroy/{id}', 'VModelController@destroy');
 #========================================

  Route::resource('/companies','CompanyController');
  Route::get('companies/destroy/{id}', 'CompanyController@destroy');
 #========================================

  Route::resource('/invoices','InvoiceController');
  Route::get('/invoices/{invoice}/print','InvoiceController@print')->name('invoices.print');
  Route::get('/invoices/{invoice}/download','InvoiceController@download')->name('invoices.download');
  Route::put('/invoices/{invoice}/change-model','InvoiceController@change_model')->name('invoices.change-model');
  Route::get('invoices/destroy/{id}', 'InvoiceController@destroy');
  Route::get('invoices/lock/{id}', 'InvoiceController@lock');
  Route::get('invoices/{invoice}/add_items','InvoiceController@add_item')->name('invoices.add_items');
  Route::post('invoices/{invoice}/add_items','InvoiceController@store_item')->name('invoices.store_items');
  Route::post('invoices/{invoice}/{item}/update_item','InvoiceController@update_item')->name('invoices.update_item');
  Route::get('invoices/{invoice}/{item}/delete_item','InvoiceController@delete_item')->name('invoices.delete_item');
  Route::get('invoices/{invoice}/{item}/edit_item','InvoiceController@edit_item')->name('invoices.edit_item');
 #========================================

  Route::resource('/vinvoics','VInvoiceController');
  Route::get('/vinvoics/{vinvoic}/print','VInvoiceController@print')->name('vinvoics.print');
  Route::get('/vinvoics/{vinvoic}/download','VInvoiceController@download')->name('vinvoics.download');
  Route::put('/vinvoics/{vinvoic}/change-model','VInvoiceController@change_model')->name('vinvoics.change-model');
  
  Route::get('vinvoics/destroy/{id}', 'VInvoiceController@destroy');
  Route::get('vinvoics/lock/{id}', 'VInvoiceController@lock');
  Route::get('vinvoics/{vinvoic}/add_items','VInvoiceController@add_item')->name('vinvoics.add_items');
  Route::post('vinvoics/{vinvoic}/add_items','VInvoiceController@store_item')->name('vinvoics.store_items');
  Route::post('vinvoics/{vinvoic}/{item}/update_item','VInvoiceController@update_item')->name('vinvoics.update_item');
  Route::get('vinvoics/{vinvoic}/{item}/delete_item','VInvoiceController@delete_item')->name('vinvoics.delete_item');
  Route::get('vinvoics/{vinvoic}/{item}/edit_item','VInvoiceController@edit_item')->name('vinvoics.edit_item');
 #========================================

  Route::resource('/items','ItemController');
  Route::get('items/destroy/{id}', 'ItemController@destroy');
 #========================================

  Route::resource('/vitems','VItemController');
  Route::get('vitems/destroy/{id}', 'VItemController@destroy');
 #========================================

  Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});