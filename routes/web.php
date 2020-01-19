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

Route::get('/', 'PastbookController@index');
Route::get('/facebook/callback', 'PastbookController@callback');
Route::middleware(['auth'])->group(function () {
    Route::get('/success', 'PastbookController@success');
});

