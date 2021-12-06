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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 募集APIグループ
Route::group(['prefix' => 'offer', 'as' => 'offer.'], function () {
    Route::get('single', 'OfferController@single')->name('single');
    Route::get('list', 'OfferController@list')->name('list');
    Route::post('post', 'OfferController@post')->name('post');
    Route::post('edit', 'OfferController@edit')->name('edit');
    Route::post('delete', 'OfferController@delete')->name('delete');
    Route::post('apply', 'OfferController@apply')->name('apply');
});

// 宣伝APIグループ
Route::group(['prefix' => 'promotion', 'as' => 'promotion.'], function () {
    Route::get('single', 'PromotionController@single')->name('single');
    Route::get('list', 'PromotionController@list')->name('list');
    Route::post('post', 'PromotionController@post')->name('post');
    Route::post('edit', 'PromotionController@edit')->name('edit');
    Route::post('delete', 'PromotionController@delete')->name('delete');
});

// 作品APIグループ
Route::group(['prefix' => 'work', 'as' => 'work.'], function () {
    Route::get('single', 'WorkController@single')->name('single');
    Route::get('list', 'WorkController@list')->name('list');
    Route::post('post', 'WorkController@post')->name('post');
    Route::post('edit', 'WorkController@edit')->name('edit');
    Route::post('delete', 'WorkController@delete')->name('delete');
});

// ユーザーAPIグル-プ
Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::post('regist', 'UserController@regist')->name('regist');
    Route::post('edit', 'UserController@edit')->name('edit');
    Route::get('whoami', 'UserController@whoami')->name('whoami');
    Route::post('regist-email', 'UserController@regist_email')->name('regist-email');
    Route::post('edit-email', 'UserController@regist_email')->name('edit-email');
    Route::get('offer-list', 'UserController@offer_list')->name('offer-list');
    Route::get('promotion-list', 'UserController@promotion_list')->name('promotion-list');
    Route::get('work-list', 'UserController@work_list')->name('work-list');
});

## その他　
Route::post('/login', 'OthersController@regist')->name('login');
Route::post('/logout', 'OthersController@edit')->name('logout');
Route::get('/tag-list', 'OthersController@tag_list')->name('tag-list');
Route::post('/contact', 'OthersController@contact')->name('contact');
