<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Article;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

use App\Http\Requests;

class ArticleController extends Controller
{
    public function getArticles(Request $request)
    {
        $articles = Article::orderBy('article_id', 'DESC')->limit(20)->get();
        $articlesList = view('components.articles', array('articles' => $articles));
        $nav = view('components.nav', ['login' => (strlen($request->session()->get('user_id')[0]))? true:false]);
        return view('template', array('title' => 'Welcome to page', 'nav' => $nav, 'content' => $articlesList));
    }

    public function getArticle($article_id, $request){
        $article = Article::where('article_id', $article_id)->first();
        $articleTemplate = View('components.article', array('article' => $article));
        $nav = view('components.nav', ['login' => (strlen($request->session()->get('user_id')[0]))? true:false]);
        return view('template', array('title' => $article[0]['title'], 'nav' => $nav, 'content' => $articleTemplate));
    }

    public function createArticle($success = false, $error = false)
    {
        $content = view('admin.articleForm', array('success' => $success, 'error' => $error, 'article' => false));
        return view('admin.template', array('content' => $content));
    }

    public function editArticle($article_id, $success = false, $error = false)
    {
        $article = Article::find($article_id)->limit(1)->first();
        $content = view('admin.articleForm', array('success' => $success, 'error' => $error, 'article' => $article));
        return view('admin.template', array('content' => $content));
    }

    public function makeArticle(Request $request)
    {
        $data = $request->All();
        $validator = Validator::make($data, [
            'title' => 'required|max:255',
            'text' => 'required|min:5',
        ]);
        if(!$validator->fails()){
            Article::create($data);
            return $this->createArticle('Article created');
        }else{
            return $this->createArticle(null, 'Error. Check fields');
        }

    }

    public function updateArticle(Request $request)
    {
        $data = $request->All();
        $validator = Validator::make($data, [
            'article_id' => 'required|min:1',
            'title' => 'required|max:255',
            'text' => 'required|min:5',
        ]);
        if(!$validator->fails()){
            Article::where('article_id', $data['article_id'])->update(['title' => $data['title'], 'text' => $data['text']]);
            return $this->editArticle($request['article_id'], 'Article saved', null);
        }else{
            return $this->editArticle($request, null, 'Error. Check fields');
        }
    }

    public function removeArticle($article_id)
    {
        $article = Article::find($article_id);
        if($article){
            $article->delete();
        }
        return $this->articleList('Article deleted', null);
    }

    public function articleList($success = false, $error = false)
    {
        $articles = Article::orderBy('article_id', 'DESC')->limit(20)->get();
        $content = view('admin.articleList', array('success' => $success, 'error' => $error, 'articles' => $articles));
        return view('admin.template', array('content' => $content));
    }
}
