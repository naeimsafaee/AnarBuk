<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('test/{name}/{lname?}',function (Request $request){
//    return 'hello ' . $request->lname;
//})->name('test');
//
//Route::get('about',function(){
//    return redirect()->route('test',['ali','reza']);
//});
//
//Route::group(['middleware' => 'main'], function() {
//    Route::get('testm/{name}',function (Request $request){
//       return $request->name;
//    });
//});

//Route::get('test/{name}/{lname?}','API\MainController@index')->name('test');

Route::get('main/where','API\apiController@whereTest');

//Route::apiResource('main','API\apiController');

