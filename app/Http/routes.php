<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'ArticleController@getArticles');
Route::get('/admin', 'Admin\AdminController@index');
Route::get('/auth', 'Auth\AuthController@index');
Route::get('/register', 'Auth\AuthController@register');
Route::get('/article/{article_id}', function($article_id){
    $article = new \App\Http\Controllers\ArticleController();
    return $article->getArticle($article_id);
});

Route::post('/auth', 'Auth\AuthController@loginUser');
Route::post('/register', 'Auth\AuthController@createUser');
