<h1>Articles list</h1>
@if($success)
    <div class="alert alert-success">{{$success}}</div>
@endif
@if($error)
    <div class="alert alert-danger">{{$error}}</div>
@endif
<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Title</th>
        <th>Created at</th>
        <th>Updated at</th>
        <th>Action</th>
    </tr>
    @foreach($articles as $article)
        <tr>
            <td>{{$article['article_id']}}</td>
            <td>{{$article['title']}}</td>
            <td>{{$article['created_at']}}</td>
            <td>{{$article['updated_at']}}</td>
            <td><a href="/admin/article/edit/{{$article['article_id']}}" class="btn btn-default">Edit</a> <a href="/admin/article/remove/{{$article['article_id']}}" class="btn btn-danger">Delete</a></td>
        </tr>
    @endforeach
</table>