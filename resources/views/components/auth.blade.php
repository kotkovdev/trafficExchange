<form action="/auth" method="post" class="col-md-offset-4 col-md-4">
    <h2>Sign In</h2>
    @if($error)
        <div class="alert alert-danger">{{$error}}</div>
    @endif
    <div class="form-group">
        <input type="text" name="email" class="form-control" placeholder="example@domain.com">
    </div>
    <div class="form-group">
        <input type="password" name="password" class="form-control" placeholder="yourpassword">
    </div>
    {{ csrf_field() }}
    <div class="col-md-9"><a href="/register">Create account</a></div>
    <div class="col-md-3"><button class="btn btn-success" type="submit">Login</button></div>
</form>