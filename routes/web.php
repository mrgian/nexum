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

//Rotta per la home
Route::get('/', function () {
    return view('welcome');
})->name('home');

//Rotte per il login
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');

//Rotta per il logout
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

//Rotte per la registrazione
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::post('registerStaff', 'AdminController@registerStaff')->name('registerStaff');

//Rotte per il profilo
Route::get('user/{username}', 'UserController@index')->name('user');
Route::get('edit', 'UserController@showEditForm')->name('edit');
Route::post('edit', 'UserController@edit');

//Rotte per il blog
Route::get('blog/{blogname}', 'BlogController@index')->name('blog');
Route::post('blog/{blogname}/post', 'BlogController@newPost')->name('newPost');
Route::post('blog/{blogname}/edit/{postid}', 'BlogController@editPost')->name('editPost')->middleware('editPost');
Route::post('blog/{blogname}/delete/{postid}', 'BlogController@deletePost')->name('deletePost')->middleware('editPost');

//Rotte per la creazione di un blog
Route::get('newBlog', 'BlogController@showNewBlogForm')->name('newBlog');
Route::post('newBlog', 'BlogController@newBlog');

//Rotte per le richieste di amicizia
Route::post('sendFriendRequest', 'FriendsController@sendFriendRequest')->name('sendFriendRequest')->middleware('sendFriendRequest');
Route::get('friends', 'FriendsController@index')->name('friends');
Route::post('removeFriend', 'FriendsController@removeFriend')->name('removeFriend');
Route::post('acceptFriendRequest', 'FriendsController@acceptFriendRequest')->name('acceptFriendRequest');
Route::post('refuseFriendRequest', 'FriendsController@refuseFriendRequest')->name('refuseFriendRequest');

// Rotte per l'amministrazione
Route::get('admin', 'AdminController@index')->name('admin');
Route::get('staff', 'StaffController@index')->name('staff');
Route::get('userlist', 'StaffController@userList')->name('userlist');
Route::get('bloglist', 'StaffController@blogList')->name('bloglist');
Route::post('blog/{blogname}/deleteblog', 'StaffController@deleteBlog')->name('deleteBlog');
Route::post('blog/{blogname}/staffdeletepost/{postid}', 'StaffController@deletePost')->name('staffDeletePost');

Route::get('managestaff', 'AdminController@manageStaff')->name('managestaff');
Route::post('removeStaff', 'AdminController@removeStaff')->name('removeStaff');

Route::get('info', 'AdminController@info')->name('info');
Route::get('user/{username}/friendlist', 'AdminController@friendList')->name('friendlist');

// Rotte per i messaggi
Route::get('messages', 'UserController@getMessages')->name('messages');

// Rotte per la ricerca
Route::get('search', 'UserController@search')->name('search');