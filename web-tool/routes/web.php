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

Route::get('/', 'App\Http\Controllers\MainController@startpage');//ログイン
Route::get('/newAccount', 'App\Http\Controllers\MainController@startpage');//アカウント新規作成
Route::get('/accountName', 'App\Http\Controllers\MainController@startpage');//アカウント名作成
Route::get('/diaryBooksList', 'App\Http\Controllers\MainController@startpage');//日記本一覧
Route::get('/diary', 'App\Http\Controllers\MainController@startpage');//日記ページ
Route::get('/account/data', 'App\Http\Controllers\MainController@all_account_data');//全てのアカウントデータ取得
Route::get('/account/{id}/{password}', 'App\Http\Controllers\MainController@make_account');//テストアカウント作成
Route::post('/post', 'App\Http\Controllers\MainController@add_account');
Route::post('/account/login', 'App\Http\Controllers\MainController@login');//製作途中
// Route::get('/{any}', function () {
//     return view('app');
// })->where('any', '.*');
