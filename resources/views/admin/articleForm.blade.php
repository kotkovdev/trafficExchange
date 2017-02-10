@if($success)
    <div class="alert alert-success">{{$success}}</div>
@endif
@if($error)
    <div class="alert alert-danger">{{$error}}</div>
@endif
@if($article)
    <h1>Edit article {{$article['title']}}</h1>
@else
    <h1>Create new article</h1>
@endif
<form action="@if($article) /admin/article/updateArticle @else /admin/article/makeArticle @endif" method="post" class="form-group">
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control" placeholder="Article title" value="@if($article){{$article['title']}}@endif">
    </div>
    <div class="form-group">
        <label>Title</label>
        <textarea class="form-control" name="text" rows="10">@if($article){{$article['text']}}@endif</textarea>
    </div>
    <div class="form-group">
        {{csrf_field()}}
        @if($article)
            <input type="hidden" name="article_id" value="{{$article['article_id']}}">
            <button class="btn btn-success" type="submit">Update article</button>
        @else
            <button class="btn btn-success" type="submit">Create article</button>
        @endif
    </div>

</form>