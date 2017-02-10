@foreach($articles as $article)
    <div class="row">
        <h1>{{$article->title}}</h1>
        <div class="col-md-12 text">{!! $article->text !!}</div>
        <div class="col-md-2 date">{{$article->created_at}}</div>
        <div class="col-md-offset-8 col-md-2 more"><a href="/article/{{$article->article_id}}">Read more...</a></div>
    </div>
@endforeach