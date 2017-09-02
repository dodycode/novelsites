@extends('layouts.app')
@section('title_and_meta')
<title>Fan Translations | {{ config('app.name', 'Laravel') }}</title>
<meta name="description" content="Daftar Fan Translation yang terdaftar di NovelBaru" />

<!-- Social Meta Tags -->
<meta property="og:title" content="Fan Translations | {{ config('app.name', 'Laravel') }}"/>
<meta property="og:type" content="article"/>
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:description" content="Daftar Fan Translations yang terdaftar di NovelBaru">
<meta property="og:image" content="https://sumeramalik.files.wordpress.com/2015/01/577376_zabor_art_zakat_siluet_doma_oblaka_devushka_anime__2800x2000_www-gdefon-ru.jpg" />

<!-- Twitter Meta Cards -->
<meta name="twitter:card" content="summary" />
<meta name="twitter:url" content="{{ url()->current() }}" />
<meta name="twitter:title" content="Fan Translations | {{ config('app.name', 'Laravel') }}" />
<meta name="twitter:description" content="Daftar Fan Translations yang terdaftar di NovelBaru" />
<meta property="twitter:image" content="https://sumeramalik.files.wordpress.com/2015/01/577376_zabor_art_zakat_siluet_doma_oblaka_devushka_anime__2800x2000_www-gdefon-ru.jpg" /> 
@endsection
@section('content')
<div class="row">
	<div class="col-xs-12">
		<h2>Fan Translations</h2>
		<div class="row">
			<div class="col-lg-6 col-xs-12 col-md-12">
				<div class="btn-group btn-group-sm pull-left mobile-center">
					<a href="{{ route('index.novel.ft', ['orderby' => 'likes', 'order' => $order]) }}" class="btn btn-default <?php if($orderby == 'likes'){echo "active";} ?>">
						<span class="fa fa-thumbs-o-up"></span>
						Jumlah Like
					</a>
					<a href="{{ route('index.novel.ft', ['orderby' => 'releases', 'order' => $order]) }}" class="btn btn-default <?php if($orderby == 'releases'){echo "active";} ?>">
						<span class="fa fa-book"></span>
						Rilisan
					</a>
					<a href="{{ route('index.novel.ft', ['orderby' => 'tanggal', 'order' => $order]) }}" class="btn btn-default <?php if($orderby == 'tanggal' || $orderby == 'created_at'){echo "active";} ?>">
						<span class="glyphicon glyphicon-calendar"></span>
						Tanggal Ditambahkan
					</a>
				</div>
				<div class="hidden-lg">
				    <br>
				</div>
			</div>
			<div class="col-lg-6 col-xs-12 col-md-12">
				<div class="btn-group btn-group-sm pull-right mobile-center">
					<a href="{{ route('index.novel.ft', ['orderby' => $orderby, 'order' => 'asc']) }}" class="btn btn-default <?php if($order == 'asc'){echo "active";} ?>">
						<i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
						Ascending
					</a>
					<a href="{{ route('index.novel.ft', ['orderby' => $orderby, 'order' => 'desc']) }}" class="btn btn-default <?php if($order == 'desc'){echo "active";} ?>">
						<i class="fa fa-sort-amount-desc" aria-hidden="true"></i>
						Descending
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
@if(count($ft) > 0)
<div class="row" id="no-more-tables">
    <div class="col-xs-12">
    	<br>
        <table class="table table-striped table-curved table-hover cf">
            <thead class="cf">
                <tr>
                    <th width="60%">Fan Translation</th>
                    <th width="20%">Total Rilisan</th>
                    <th width="20%">Jumlah Like</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ft as $data)
                <tr>
                	<td data-title="Fan Translation"><a href="{{ route('index.ft.detail', ['slug' => $data->slug]) }}">{{ $data->nama_ft }}</a></td>
                	<td data-title="Total Rilisan">{{ count($data->chapters) }} Chapters</td>
                	<td data-title="Jumlah Like">{{ count($data->likes) }} Likes</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-center">
            {{ $ft->links() }}
        </div>
    </div>
</div>
@else
<div class="row">
	<div class="col-xs-12">
		<br>
		<div class="alert alert-info col-xs-12 text-center">
	        <p>Belum ada satupun FT yang didaftarkan</p>
	    </div>
	</div>
</div>
@endif
@endsection