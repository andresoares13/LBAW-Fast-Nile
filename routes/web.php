<?php

use App\Http\Controllers\BidController;
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
// Home
Route::get('/', 'AuctionController@list');


// Cards
Route::get('home', 'AuctionController@list');
Route::get('auction/{id}', 'AuctionController@show');

// API
Route::put('api/cards', 'AuctionController@create');
Route::delete('api/cards/{card_id}', 'AuctionController@delete');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');
Route::put('api/bid', 'BidController@create');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// profile
Route::get('profile/{id}', 'UserController@show');
Route::get('profile/edit/{id}', 'UserController@showEdit');
Route::get('profile/wallet/{id}', 'UserController@showWallet');
Route::get('profile/upgrade/{id}', 'UserController@showUpgrade');
Route::get('profile/picture/{id}', 'UserController@showPicture');
Route::post('wallet', 'UserController@addFunds');
Route::post('edit', 'UserController@editProfile');
Route::post('upgrade', 'UserController@becomeAuctioneer');
Route::post('pictureProfile', 'UserController@updatePicture');

// Search
Route::get('search/{query}', 'UserController@show');

//bid
Route::post('bid', 'BidController@create');