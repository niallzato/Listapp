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

//Route::get('/', function () {
//    return view('welcome');
//});
//
//
//Route::get('login', function () {
//    return view('welcome');
//})->name('login');
//
Route::group(['middleware' => 'auth'], function(){

    Route::get('/lists', function () {
        return view('lists');
    })->name('lists');

    //Route::any('/lists', 'PageController@renderLists');

    Route::any('/list/{name?}', 'ListController@renderList');

    //list api
    Route::get('/getlists', 'ListController@getLists');
    Route::any('/add', 'ListController@add');
    Route::get('/get', 'ListController@getItem');
    Route::any('/del/{id?}', 'ListController@deleteItem');
    Route::any('/delete', 'ListController@deleteList');
});


Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
