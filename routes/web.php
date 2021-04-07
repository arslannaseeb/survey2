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

Route::get('/', function () {
    return redirect('/survey/list');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'survey','middleware' => ['web', 'auth']], function () {
    /***
     * Survey listing
     */
    Route::get('/list', [ 'as' => 'survey-list', 'uses' => 'SurveyController@index']);
    /***
     * Fill survey form
     */
    Route::get('/fill-form/{id}', ['as' => 'fill-form', 'uses' => 'SurveyController@fillForm']);

    /***
     * View filled survey form
     */
    Route::get('/view-form/{id}', ['as' => 'view-form', 'uses' => 'SurveyController@viewForm']);

    /***
     * Save form
    */
    Route::post('save-form', ['as' => 'save-form', 'uses' => 'SurveyController@saveForm']);
});



