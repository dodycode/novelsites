@extends('layouts.app')
@section('title_and_meta')
    <title> 404 Not Found | {{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="Alamat tidak ditemukan" />

    <!-- Social Meta Tags -->
    <meta property="og:title" content="404 Not Found | {{ config('app.name', 'Laravel') }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:description" content="Alamat tidak ditemukan">
    <meta property="og:image" content="https://sumeramalik.files.wordpress.com/2015/01/577376_zabor_art_zakat_siluet_doma_oblaka_devushka_anime__2800x2000_www-gdefon-ru.jpg" />

    <!-- Twitter Meta Cards -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:url" content="{{ url()->current() }}" />
    <meta name="twitter:title" content="404 Not Found | {{ config('app.name', 'Laravel') }}" />
    <meta name="twitter:description" content="Alamat tidak ditemukan" />
    <meta property="twitter:image" content="https://sumeramalik.files.wordpress.com/2015/01/577376_zabor_art_zakat_siluet_doma_oblaka_devushka_anime__2800x2000_www-gdefon-ru.jpg" /> 
@endsection
@section('content')
<div class="row">
	<div class="col-xs-12 text-center">
		<h1>404</h1>
		<p>Alamat yang kamu cari tidak ditemukan :(</p>
	</div>
</div>
@endsection