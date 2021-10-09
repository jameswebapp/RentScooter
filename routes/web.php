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
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
  Route::get('/', 'AdminAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'AdminAuth\LoginController@login');
  Route::post('/logout', 'AdminAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'AdminAuth\RegisterController@register');

  Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/verify', 'HomeController@verify');
Route::get('/check_verify', 'HomeController@check_verify');
Route::post('/id_verify', 'HomeController@id_verify');
Route::post('/clicked_stripe_url', 'HomeController@clicked_stripe_url');
Route::get('/scooters', 'HomeController@scooters');
Route::post('/create_checkout', 'HomeController@create_checkout');
Route::get('/checkout_success/{id}', 'Auth\ApiController@checkout_success');
Route::get('/signsuccess/{email}', 'Auth\ApiController@signsuccess');
Route::get('/send_billing/{id}', 'Auth\ApiController@send_billing');
Route::get('/start_track/{id}', 'Auth\ApiController@start_track');
Route::get('/rent_scooter/{id}', 'HomeController@rent_scooter');


Route::get('/webhook', 'Auth\ApiController@webhook');




Route::post('/create_webhook', 'HomeController@create_webhook');
Route::get('/stripe', 'HomeController@stripe');
Route::get('/refresh', 'HomeController@refresh');
