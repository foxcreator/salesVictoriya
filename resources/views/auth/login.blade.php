@extends('new_design.layouts.app')

@section('content')
    <div class="hold-transition login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="{{ route('home') }}" class="h1"><b>BSV</b>CRM</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Войдите в свой кабинет</p>

                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror" name="password" required
                                   autocomplete="current-password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" name="remember"
                                           id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember">
                                        Запомнить меня
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Войти</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                {{--            <div class="social-auth-links text-center mt-2 mb-3">--}}
                {{--                <a href="#" class="btn btn-block btn-primary">--}}
                {{--                    <i class="fab fa-facebook mr-2"></i> Sign in using Facebook--}}
                {{--                </a>--}}
                {{--                <a href="#" class="btn btn-block btn-danger">--}}
                {{--                    <i class="fab fa-google-plus mr-2"></i> Sign in using Google+--}}
                {{--                </a>--}}
                {{--            </div>--}}
                <!-- /.social-auth-links -->

                    <p class="mb-1">
                        @if (Route::has('password.request'))
                            <a href="forgot-password.html">Забыли пароль</a>
                        @endif

                    </p>
                    <p class="mb-0">
                        <a href="{{ route('login') }}" class="text-center">Регистрация</a>
                    </p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
