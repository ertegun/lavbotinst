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

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('add', 'CarController@create');
// Route::post('add', 'CarController@store');
// Route::get('car', 'CarController@index');
// Route::get('edit/{id}', 'CarController@edit');
// Route::post('edit/{id}', 'CarController@update');
// Route::delete('{id}', 'CarController@destroy');

// Route::get('add','CarController@create');
// Route::post('add','CarController@store');

// Route::get('messageedit/{id}','MessageController@edit');
// Route::get('/','MessageController@index');

Route::get('rb', 'MessageController@runBot');
Route::get('mdb','MessageController@getMessagesFromDB');


Route::get('p/{uid}', 'MessageController@messages');
// Route::get('c/{item_id}', 'MessageController@comments');
// Route::get('gibn/{username}', 'MessageController@getInfoByName');


// Route::get('post/{id}','MessageController@message');

// Route::post('edit/{id}','CarController@update');
// Route::delete('{id}','CarController@destroy');

Route::get('/', 'MessageController@runBot');
Route::get('s', 'MessageController@sendMessage');

// Route::get('getInbox', 'MessageController@getInbox');

// Route::get('/', function () {
//   return View::make('pages.home');
// });
Route::get('about', function () {
  $messages=8888;
  return View::make('pages.about',compact('messages'));
});
Route::get('projects', function () {
  return View::make('pages.projects');
});
Route::get('contact', function () {
  return View::make('pages.contact');
});
