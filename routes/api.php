<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

//Route::apiResource('main','API\apiController');
Route::get('migrate', function () {
//    Artisan::call('migrate');
//    Artisan::call('migrate:refresh');
    die('migrate complete');
});
Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});

Route::apiResource('bookInfoData', 'API\bookInfoController');

Route::apiResource('bookData', 'API\bookController');

Route::get('bookDataWithView/{id}/{device_id}', 'API\bookController@add_view')->name("bookDataWithView");

Route::apiResource('author', 'API\authorController');

Route::apiResource('homeData', 'API\HomeController');

Route::apiResource('publisher', 'API\publisherController');

Route::apiResource('category', 'API\categoryController');


Route::post('globalSearch/', 'API\searchController@global_search')->name("globalSearch");
Route::post('searchBook/', 'API\searchController@search_book')->name("searchBook");

Route::post('login', 'API\loginCotroller@login')->name("login");
Route::post('firstRun', 'API\loginCotroller@firstRun')->name("firstRun");
Route::post('topSearch/', 'API\searchController@top_search')->name("topSearch");

Route::group(['middleware' => 'auth:api'], function () {
});


