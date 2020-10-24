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

Route::get('/', 'TicketController@run');
Route::get('/ticket', 'TicketController@run');
Route::get('/ticket/add', 'TicketController@add');
Route::get('/ticket/delete', 'TicketController@delete');

Route::get('/monitor', 'MonitorController@run');
Route::get('/monitor/delete', 'MonitorController@delete');
