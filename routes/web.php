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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'HomeController@index')->name('root');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@about')->name('about');

Auth::routes();

// =======================================================================================================
Route::middleware('auth','CEO')->group(function(){ 
        
    Route::get('/ceo', 'CEO\UserController@index')->name('ceo');

    Route::get('/ceo/user', 'CEO\UserController@index');
    Route::get('/ceo/user/create', 'CEO\UserController@create');
    Route::post('/ceo/user', 'CEO\UserController@store');
    Route::get('/ceo/user/{id}', 'CEO\UserController@show');
    Route::get('/ceo/user/{id}/edit', 'CEO\UserController@edit');
    Route::patch('/ceo/user/{id}/edit', 'CEO\UserController@update');
    Route::patch('/ceo/user/{id}/reset', 'CEO\UserController@resetpassword');

    
    Route::get('/ceo/medicine', 'CEO\IncomeController@formmedicine');
    Route::post('/ceo/medicine', 'CEO\IncomeController@postmedicine');

    Route::get('/ceo/service', 'CEO\IncomeController@formincome');
    Route::post('/ceo/service', 'CEO\IncomeController@postincome');
    
    Route::get('/ceo/income/dentist', 'CEO\IncomeController@formincomedentist');
    Route::post('/ceo/income/dentist', 'CEO\IncomeController@postincomedentist');

});
// ===================================================================================================

Route::middleware('auth')->group(function(){

    Route::get('/akun', 'Akun\AccountController@index')->name('account');

    Route::get('/akun/password', 'Akun\AccountController@editpassword');
    Route::patch('/akun/password', 'Akun\AccountController@updatepassword');
    Route::get('/akun/name', 'Akun\AccountController@editname');
    Route::patch('/akun/name', 'Akun\AccountController@updatename'); 
    
});
// =======================================================================================================
Route::middleware('auth','admin')->group(function(){ 
        
    Route::get('/admin', 'Admin\UserController@index')->name('admin');

    Route::get('/admin/user', 'Admin\UserController@index');
    Route::get('/admin/user/create', 'Admin\UserController@create');
    Route::post('/admin/user', 'Admin\UserController@store');
    Route::get('/admin/user/{id}', 'Admin\UserController@show');
    Route::get('/admin/user/{id}/edit', 'Admin\UserController@edit');
    Route::patch('/admin/user/{id}/edit', 'Admin\UserController@update');
    Route::patch('/admin/user/{id}/reset', 'Admin\UserController@resetpassword');

    Route::get('/admin/diagnosa', 'Admin\DiagController@index');
    Route::post('/admin/diagnosa', 'Admin\DiagController@store');
    Route::get('/admin/diagnosa/{id}/edit', 'Admin\DiagController@edit');
    Route::patch('/admin/diagnosa/{id}/edit', 'Admin\DiagController@update');
    Route::delete('/admin/diagnosa/{id}', 'Admin\DiagController@destroy');

    Route::get('/admin/service', 'Admin\CostController@index');
    Route::get('/admin/service/create', 'Admin\CostController@create');
    Route::post('/admin/service', 'Admin\CostController@store');
    Route::get('/admin/service/{id}/edit', 'Admin\CostController@edit');
    Route::patch('/admin/service/{id}/edit', 'Admin\CostController@update');
    Route::delete('/admin/service/{id}', 'Admin\CostController@destroy');

});
// =======================================================================================================
Route::middleware('auth','pendaftaran')->group(function(){ 

    Route::get('/pendaftaran', 'Pendaftaran\CustomerController@index')->name('pendaftaran');

    Route::get('/pendaftaran/pasien', 'Pendaftaran\PatientController@index')->name('daftarpasien');
    Route::get('/pendaftaran/pasien/create', 'Pendaftaran\PatientController@create');
    Route::post('/pendaftaran/pasien', 'Pendaftaran\PatientController@store');
    Route::get('/pendaftaran/pasien/{id}', 'Pendaftaran\PatientController@show');
    Route::get('/pendaftaran/pasien/{id}/edit', 'Pendaftaran\PatientController@edit');
    Route::patch('/pendaftaran/pasien/{id}/edit', 'Pendaftaran\PatientController@update');
    Route::delete('/pendaftaran/pasien/{id}', 'Pendaftaran\PatientController@destroy');

    Route::post('/pendaftaran/customer', 'Pendaftaran\CustomerController@store');
    Route::delete('/pendaftaran/customer/{id}', 'Pendaftaran\CustomerController@destroy');
    Route::delete('/pendaftaran/truncate', 'Pendaftaran\CustomerController@truncate');

});

// =======================================================================================================
Route::middleware('auth','pemeriksaan')->group(function(){ 

    Route::get('/pemeriksaan', 'Pemeriksaan\CustomerController@index')->name('pemeriksaan');

    Route::get('/pemeriksaan/pasien', 'Pemeriksaan\CustomerController@index');
    Route::get('/pemeriksaan/pasien/{id}', 'Pemeriksaan\CustomerController@show');
    Route::get('/pemeriksaan/pasien/{id}/edit', 'Pemeriksaan\CustomerController@edit');
    Route::patch('/pemeriksaan/pasien/{id}/edit', 'Pemeriksaan\CustomerController@update');
    Route::delete('/pemeriksaan/pasien/{id}', 'Pemeriksaan\CustomerController@destroy');

});
// =======================================================================================================
Route::middleware('auth','dentist')->group(function(){ 

    Route::get('/dentist', 'Dentist\DentalrecordController@index')->name('dentist');

    Route::get('/dentist/pasien', 'Dentist\DentalrecordController@index');
    Route::get('/dentist/pasien/create/{id}', 'Dentist\DentalrecordController@create');
    Route::post('/dentist/pasien', 'Dentist\DentalrecordController@store');
    Route::get('/dentist/pasien/{id}', 'Dentist\DentalrecordController@show');
    Route::get('/dentist/pasien/{id}/edit', 'Dentist\DentalrecordController@edit');
    Route::patch('/dentist/pasien/{id}/edit', 'Dentist\DentalrecordController@update');
    Route::delete('/dentist/pasien/{id}', 'Dentist\DentalrecordController@destroy');
    
    Route::get('/dentist/dentaltreatment/create/{id}', 'Dentist\DentaltreatmentController@create');
    Route::post('/dentist/dentaltreatment', 'Dentist\DentaltreatmentController@store');
    Route::get('/dentist/dentaltreatment/{id}/edit', 'Dentist\DentaltreatmentController@edit');
    Route::patch('/dentist/dentaltreatment/{id}/edit', 'Dentist\DentaltreatmentController@update');
    Route::delete('/dentist/dentaltreatment/{id}', 'Dentist\DentaltreatmentController@destroy');
    
    Route::get('/dentist/income', 'Dentist\IncomeController@create');
    Route::post('/dentist/income', 'Dentist\IncomeController@store');
    
    Route::get('/dentalrecord', 'Dentalrecord\DentalrecordController@index');
    Route::get('/dentalrecord/{id}', 'Dentalrecord\DentalrecordController@show');
    Route::get('/dentalrecord/{id}/edit', 'Dentalrecord\DentalrecordController@edit');
    Route::patch('/dentalrecord/{id}/edit', 'Dentalrecord\DentalrecordController@update');
    Route::delete('/dentalrecord/{id}', 'Dentalrecord\DentalrecordController@destroy');
    
    // Route::get('/dentalrecord/{id}', 'Dentist\DentalrecordController@records');

    Route::get('/dentist/cost', 'Dentist\CostController@index');
});
// =======================================================================================================
Route::middleware('auth','apotek')->group(function(){ 

    Route::get('/apotek', 'Apotek\MedicinerecordController@index')->name('apotek');

    Route::get('/apotek/pasien', 'Apotek\MedicinerecordController@index');
    Route::get('/apotek/pasien/create/{id}', 'Apotek\MedicinerecordController@create');
    Route::post('/apotek/pasien', 'Apotek\MedicinerecordController@store');
    Route::get('/apotek/pasien/{id}', 'Apotek\MedicinerecordController@show');
    Route::get('/apotek/pasien/{id}/edit', 'Apotek\MedicinerecordController@edit');
    Route::patch('/apotek/pasien/{id}/edit', 'Apotek\MedicinerecordController@update');
    Route::delete('/apotek/pasien/{id}', 'Apotek\MedicinerecordController@destroy');
    Route::get('/apotek/pasien/add/{id}', 'Apotek\MedicinerecordController@add');
    Route::post('/apotek/pasien/add', 'Apotek\MedicinerecordController@addstore');


    Route::get('/apotek/obat', 'Apotek\MedicineController@index');
    Route::get('/apotek/obat/create', 'Apotek\MedicineController@create');
    Route::post('/apotek/obat', 'Apotek\MedicineController@store');
    Route::get('/apotek/obat/{id}/edit', 'Apotek\MedicineController@edit');
    Route::patch('/apotek/obat/{id}/edit', 'Apotek\MedicineController@update');
    Route::delete('/apotek/obat/{id}', 'Apotek\MedicineController@destroy');
});
// =======================================================================================================
Route::middleware('auth','kasir')->group(function(){ 

    Route::get('/kasir', 'Kasir\CashierController@index')->name('kasir');

    Route::get('/kasir/pasien', 'Kasir\CashierController@index');
    Route::get('/kasir/pasien/{id}', 'Kasir\CashierController@show');
    Route::get('/kasir/pasien/{id}/edit', 'Kasir\CashierController@edit');
    Route::patch('/kasir/pasien/{id}/edit', 'Kasir\CashierController@update');
});
// =======================================================================================================