<?php

use App\Http\Controllers\SearchController;


if (env('APP_ENV') === 'production') {
    URL::forceSchema('https');
}

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
Route::get('/', function () {
    return redirect('/home');
});
Route::get('/home', 'HomeController@showHome');



// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm');
Route::post('/login/admin', 'Auth\LoginController@adminLogin');


Route::get('forgotPassword','Auth\LoginController@resetPasswordForm');
Route::post('resetPassword', 'UserController@resetPasswordLink');
Route::get('password/reset/{token}','UserController@showResetForm')->name('reset.password.form');
Route::post('resetPasswordConfirm', 'UserController@resetPasswordConfirm');




// profile
Route::get('profile/{id}', 'UserController@show')->name('profileUser');;
Route::get('profile/edit/{id}', 'UserController@showEdit');
Route::get('profile/wallet/{id}', 'UserController@showWallet');
Route::get('profile/upgrade/{id}', 'UserController@showUpgrade');
Route::get('profile/picture/{id}', 'UserController@showPicture');
Route::get('profile/auctions/{id}/{pageNr}', 'UserController@showUserAuctions');
Route::get('profile/bids/{id}/{pageNr}', 'UserController@showUserBids');
Route::get('profile/following/{id}/{pageNr}', 'UserController@showUserFollowed');
Route::get('profile/notifications/{id}/{pageNr}','UserController@showNotifications');
Route::get('profile/delete/{id}','UserController@showDelete');
Route::post('api/wallet', 'UserController@addFunds');
Route::post('edit', 'UserController@editProfile');
Route::post('upgrade', 'UserController@becomeAuctioneer');
Route::post('delete', 'UserController@deleteAccount');
Route::post('pictureProfile', 'UserController@updatePicture');
Route::post('api/markRead','UserController@markRead');
Route::post('api/markAllRead','UserController@markAllRead');

//admin

Route::get('profileAdmin/{id}', 'AdminController@show')->name('profileAdmin');
Route::get('profileAdmin/edit/{id}', 'AdminController@showEdit');
Route::get('profileAdmin/picture/{id}', 'AdminController@showPicture');
Route::post('editAdmin', 'AdminController@editProfile');
Route::post('pictureAdminProfile', 'AdminController@updatePicture');
Route::get('profile/block/{id}','UserController@showBlock');
Route::post('block', 'UserController@blockAccount');
Route::get('/users/blocked/{pageNr}','UserController@blockList');
Route::get('profile/unblock/{id}','UserController@showUnblock');
Route::post('unblock', 'UserController@unblockAccount');


// Search
Route::get('search/auction', 'SearchController@viewSearchFull');
Route::get('search/auctionM', 'SearchController@viewSearchExact');
Route::get('search/user', 'SearchController@viewSearchUser');
Route::get('search', 'SearchController@viewSearchPage');

//bid (API)
Route::post('api/bid', 'BidController@create');


//auction

Route::get('auction/{id}', 'AuctionController@show');
Route::get('auctions/{pageNr}', 'AuctionController@showAuctionsPage');
Route::get('profile/auctionCreate/{id}', 'UserController@showAuctionCreate');
Route::post('auctionCreate', 'UserController@createAuction');
Route::get('auctionEdit/{id}', 'AuctionController@showAuctionEdit');
Route::get('auctionStatus/{id}', 'AuctionController@showAuctionStatus');
Route::post('auctionEdit', 'AuctionController@editAuction');
Route::post('auctionStatus', 'AuctionController@statusAuction');
Route::post('auctionCancel', 'AuctionController@deleteAuction');
Route::post('api/auctionFollow','UserController@followAuction');
Route::post('api/auctionUnFollow','UserController@unfollowAuction');
Route::post('api/getAuction','AuctionController@getAuctionAPI'); //to be used by js clock, to know if it should send requests to set the auction to ending
Route::post('api/closeAuction','AuctionController@closeAuctionAPI');
Route::post('api/endingAuction','AuctionController@endingAuctionAPI');


//users

Route::get('users/{pageNr}', 'UserController@showUsersPage');


// Static Pages

Route::get('/aboutUs', 'HomeController@showAboutUs');
Route::get('/contacts', 'HomeController@showContacts');
Route::get('/features', 'HomeController@showFeatures');