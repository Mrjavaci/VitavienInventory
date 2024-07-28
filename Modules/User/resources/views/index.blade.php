@extends("adminlte3.layouts.login")

@pushOnce('css')
    <style></style>
@endpushonce
@section('title', "Vitavien")
@section("content")

    <div class="login-box">
        <div class="login-logo">
            <a href="/"><b>Vitavien</b>Inventory</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in</p>
                @if(isset($error)) <p class="login-box-msg">{{$error}}</p>@endif
                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                    @csrf
                </form>


            </div>
            <!-- /.login-card-body -->
        </div>
    </div>

@endsection

@pushOnce('scripts')
    <script></script>
@endpushonce
