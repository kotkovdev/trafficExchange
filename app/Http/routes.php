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

use Illuminate\Http\Request;

Route::get('/', 'ArticleController@getArticles');
Route::get('/admin', 'Admin\AdminController@index');
Route::get('/admin/statistic', 'StatisticController@getStatistic');
Route::get('/admin/article/create', 'ArticleController@createArticle');
Route::get('/admin/article/list', 'ArticleController@articleList');
Route::get('/admin/article/edit/{article_id}', function($article_id){
    $article = new \App\Http\Controllers\ArticleController();
    return $article->editArticle($article_id);
});
Route::get('/admin/article/remove/{article_id}', function($article_id){
    $article = new \App\Http\Controllers\ArticleController();
    return $article->removeArticle($article_id);
});
Route::get('/auth', function(Request $request){
    $auth = new \App\Http\Controllers\Auth\AuthController();
    return $auth->index(null, $request);
});
Route::get('/register', function(Request $request){
    $auth = new \App\Http\Controllers\Auth\AuthController();
    return $auth->register(null, $request);
});
Route::get('/article/{article_id}', function($article_id, Request $request){
    $article = new \App\Http\Controllers\ArticleController();
    return $article->getArticle($article_id, $request);
});
Route::get('/logout', 'Auth\AuthController@logout');

Route::post('/statistic', 'StatisticController@addClient');
Route::post('/auth', 'Auth\AuthController@loginUser');
Route::post('/register', 'Auth\AuthController@createUser');
Route::post('/admin/article/makeArticle', 'ArticleController@makeArticle');
Route::post('/admin/article/updateArticle', 'ArticleController@updateArticle');
