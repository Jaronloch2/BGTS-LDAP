<?php

/*
|--------------------------------------------------------------------------
| Module Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for the module.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

use App\Modules\bgtsldap\Http\Controllers\bgtsldapController;
Route::group(['prefix' => 'bgtsldap'], function() {
	Route::get('', function() {dd('This is the Bgtsldap module index page.');});
	Route::get('/', function() {dd('This is the Bgtsldap module index page.');});
	Route::get('domains', 'bgtsldapController@domains');
	Route::get('loginform', 'bgtsldapController@loginform');
	Route::get('logoutform', 'bgtsldapController@logoutform');

	Route::get('syncsession/{bgtsldapUser}', function($bgtsldapUser, bgtsldapController $bgtsldapCtrl){
		return $bgtsldapCtrl->syncsession($bgtsldapUser);
	});

	Route::post('register', 'bgtsldapController@register');
	Route::post('login', 'bgtsldapController@login');
	Route::get('logout', 'bgtsldapController@logout');
	
	Route::post('forgetkey', 'bgtsldapController@forgetkey');
	
	Route::post('uploadPicture', 'bgtsldapController@uploadPicture');
	
	Route::resource('user','bgtsldapUserController');
});
