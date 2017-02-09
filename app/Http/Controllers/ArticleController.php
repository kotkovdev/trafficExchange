<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;

use App\Http\Requests;

class ArticleController extends Controller
{
    public function getArticles(Request $request)
    {
        $articles = Article::orderBy('article_id', 'DESC')->limit(20)->get();
        $articlesList = view('components.articles', array('articles' => $articles));
        return view('template', array('title' => 'Welcome to page', 'content' => $articlesList));
    }

    public function getArticle($article_id){
        $article = Article::find($article_id)->limit(1)->get();
        $articleTemplate = View('components.article', array('article' => $article[0]));
        return view('template', array('title' => $article[0]['title'], 'content' => $articleTemplate));
    }
}
