@extends('layouts.app')
@section('title_and_meta')
<title>Register Page | {{ config('app.name', 'Laravel') }}</title>
<meta name="description" content="Mari mendaftar di NovelBaru dan menjadi bagian dari komunitas terbesar NovelBaru" />

<!-- Social Meta Tags -->
<meta property="og:title" content="Register Page | {{ config('app.name', 'Laravel') }}"/>
<meta property="og:type" content="article"/>
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:description" content="Mari mendaftar di NovelBaru dan menjadi bagian dari komunitas terbesar NovelBaru">
<meta property="og:image" content="https://sumeramalik.files.wordpress.com/2015/01/577376_zabor_art_zakat_siluet_doma_oblaka_devushka_anime__2800x2000_www-gdefon-ru.jpg" />

<!-- Twitter Meta Cards -->
<meta name="twitter:card" content="summary" />
<meta name="twitter:url" content="{{ url()->current() }}" />
<meta name="twitter:title" content="Register Page | {{ config('app.name', 'Laravel') }}" />
<meta name="twitter:description" content="Mari mendaftar di NovelBaru dan menjadi bagian dari komunitas terbesar NovelBaru" />
<meta property="twitter:image" content="https://sumeramalik.files.wordpress.com/2015/01/577376_zabor_art_zakat_siluet_doma_oblaka_devushka_anime__2800x2000_www-gdefon-ru.jpg" /> 
@endsection
@section('content')
<div class="row">
    <div class="col-xs-12">
        <h1>Register</h1>
        <ol class="breadcrumb">
          <li><a href="{{ route('index') }}">Home</a></li>
          <li class="active">Register</li>
        </ol>
    </div>
</div>
<br>
<div class="row">
    <div class="col-xs-12">
        <form method="POST" action="{{ route('register.submit') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}" style="margin-right: 0; margin-left: 0">
                <label>Username</label>
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}" style="margin-right: 0; margin-left: 0">
                <label>E-Mail Address</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}" style="margin-right: 0; margin-left: 0">
                <label>Password</label>

                <input id="password" type="password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group" style="margin-right: 0; margin-left: 0">
                <label for="password-confirm">Confirm Password</label>

                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-sm">
                    Register
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
