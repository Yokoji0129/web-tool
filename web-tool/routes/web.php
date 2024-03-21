<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', 'App\Http\Controllers\MainController@startpage');
Route::get('/account/data', 'App\Http\Controllers\MainController@all_account_data');
Route::get('/account/new', 'App\Http\Controllers\MainController@make_account');
// Route::get('/{any}', function () {
//     return view('app');
// })->where('any', '.*');
