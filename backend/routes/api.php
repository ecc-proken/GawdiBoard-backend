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

// 認証が必要なAPI
Route::group(['middleware' => ['auth:sanctum']], function () {
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
        Route::post('post', 'WorkController@post')->name('post');
        Route::post('edit', 'WorkController@edit')->name('edit');
        Route::post('delete', 'WorkController@delete')->name('delete');
    });

    // ユーザーAPIグル-プ
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::post('regist', 'UserController@regist')->name('regist');
        Route::post('edit', 'UserController@edit')->name('edit');
        Route::get('whoami', 'UserController@whoami')->name('whoami');
        Route::get('single', 'UserController@single')->name('single');
        Route::post('regist-email', 'UserController@registEmail')->name('regist-email');
        Route::post('edit-email', 'UserController@registEmail')->name('edit-email');
        Route::get('offer-list', 'UserController@offerList')->name('offer-list');
        Route::get('applied-offer-list', 'UserController@appliedOfferList')->name('applied-offer-list');
        Route::get('promotion-list', 'UserController@promotionList')->name('promotion-list');
        Route::get('work-list', 'UserController@workList')->name('work-list');
    });

    // チャットAPIグル-プ
    Route::group(['prefix' => 'chat', 'as' => 'chat.'], function () {
        Route::post('offer-list', 'ChatController@offerList')->name('offer-list');
        Route::post('list', 'ChatController@list')->name('list');
        Route::post('post', 'ChatController@post')->name('post');
        Route::post('delete', 'ChatController@delete')->name('delete');
    });

    // その他
    Route::post('/contact', 'OthersController@contact')->name('contact');
    Route::post('/file-upload', 'OthersController@fileUpload')->name('file-upload');
});

// 作品APIグループ
Route::group(['prefix' => 'work', 'as' => 'work.'], function () {
    Route::get('single', 'WorkController@single')->name('single');
    Route::get('list', 'WorkController@list')->name('list');
});

// その他
Route::get('/tag-list', 'OthersController@tagList')->name('tag-list');
