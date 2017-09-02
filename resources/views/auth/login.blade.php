@extends('layouts.app')
@section('title_and_meta')
<title>Login Page | {{ config('app.name', 'Laravel') }}</title>
<meta name="description" content="Login dan mari bergabung dengan yang lainnya di NovelBaru" />

<!-- Social Meta Tags -->
<meta property="og:title" content="Login Page | {{ config('app.name', 'Laravel') }}"/>
<meta property="og:type" content="article"/>
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:description" content="Login dan mari bergabung dengan yang lainnya di NovelBaru">
<meta property="og:image" content="https://sumeramalik.files.wordpress.com/2015/01/577376_zabor_art_zakat_siluet_doma_oblaka_devushka_anime__2800x2000_www-gdefon-ru.jpg" />

<!-- Twitter Meta Cards -->
<meta name="twitter:card" content="summary" />
<meta name="twitter:url" content="{{ url()->current() }}" />
<meta name="twitter:title" content="Login Page | {{ config('app.name', 'Laravel') }}" />
<meta name="twitter:description" content="Login dan mari bergabung dengan yang lainnya di NovelBaru" />
<meta property="twitter:image" content="https://sumeramalik.files.wordpress.com/2015/01/577376_zabor_art_zakat_siluet_doma_oblaka_devushka_anime__2800x2000_www-gdefon-ru.jpg" /> 
@endsection
@section('content')
@if(Session::get('Success'))
  <div class="row">
      <div id="alert" class="alert alert-info col-xs-12 text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <p>{{ Session::get('Success') }}</p>
      </div>
  </div>
@endif

@if(Session::get('Error'))
  <div class="row">
      <div id="alert" class="alert alert-danger col-xs-12 text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <p>{{ Session::get('Error') }}</p>
      </div>
  </div>
@endif

<div class="row">
    <div class="col-xs-12">
        <h1>Login</h1>
        <ol class="breadcrumb">
          <li><a href="{{ route('index') }}">Home</a></li>
          <li class="active">Login</li>
        </ol>
    </div>
</div>
<br>
<div class="row">
    <div class="col-xs-12">
        <form method="POST" action="{{ route('login.submit') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label>E-Mail Address</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label>Password</label>
                <input id="password" type="password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="checkbox" style="padding-left: 0">
                <label>
                    <input type="checkbox" data-toggle="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                    <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                </label>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    Login
                </button>

                <a class="btn btn-link pull-right" href="{{ route('password.request') }}">
                    Lupa Password
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
