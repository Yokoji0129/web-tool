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
Route::get('/search/{id}', 'App\Http\Controllers\MainController@search_id');//対象idが存在しなければtrueを存在すればfalseを返します
Route::post('/post', 'App\Http\Controllers\MainController@add_account');
Route::post('/login', 'App\Http\Controllers\MainController@login');//ログイン機能passwordが一致すればokを一致しなければnoを返す
Route::get('/returndiary', 'App\Http\Controllers\MainController@return_diary');//ログイン状態にあるセッションの日記情報を返す
Route::post('/diaryadd', 'App\Http\Controllers\MainController@add_diary');//日記情報追加用

//以下のルートはテスト用
Route::get('/test/diary/{name}/{color}', 'App\Http\Controllers\MainController@test_add_diarydata');//日記情報追加のテスト、ファイル情報は受け付けない
Route::get('/account/login/{id}/{password}', 'App\Http\Controllers\MainController@testlogin');//getでログインできるかのお試し
Route::get('/account/{id}/{password}', 'App\Http\Controllers\MainController@make_account');//テストアカウント作成
Route::get('/re', 'App\Http\Controllers\MainController@session');//requestを覗く

// Route::get('/{any}', function () {
//     return view('app');
// })->where('any', '.*');
