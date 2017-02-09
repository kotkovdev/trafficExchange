<form action="/register" method="post" class="col-md-offset-4 col-md-4">
    <h2>Sign Up</h2>
    @if($error)
        <div class="alert alert-danger">{{$error}}</div>
    @endif
    <div class="form-group">
        <input type="text" name="name" class="form-control" placeholder="Your name">
    </div>
    <div class="form-group">
        <input type="text" name="email" class="form-control" placeholder="Your email">
    </div>
    <div class="form-group">
        <input type="password" name="password" class="form-control" placeholder="Your password">
    </div>
    <div class="form-group">
        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
    </div>
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-md-8">Have account? <a href="/auth">Login</a></div>
        <div class="col-md-3 col-md-offset-1"><button class="btn btn-success" type="submit">Register</button></div>
    </div>
</form>