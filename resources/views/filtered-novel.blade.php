@extends('layouts.app')
@section('title_and_meta')
    <title> {{ $judulPage }} | {{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="Daftar Novel yang terdaftar di NovelBaru" />

    <!-- Social Meta Tags -->
    <meta property="og:title" content="{{ $judulPage }} | {{ config('app.name', 'Laravel') }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:description" content="Daftar Novel yang terdaftar di NovelBaru">
    <meta property="og:image" content="https://sumeramalik.files.wordpress.com/2015/01/577376_zabor_art_zakat_siluet_doma_oblaka_devushka_anime__2800x2000_www-gdefon-ru.jpg" />

    <!-- Twitter Meta Cards -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:url" content="{{ url()->current() }}" />
    <meta name="twitter:title" content="{{ $judulPage }} | {{ config('app.name', 'Laravel') }}" />
    <meta name="twitter:description" content="Daftar Novel yang terdaftar di NovelBaru" />
    <meta property="twitter:image" content="https://sumeramalik.files.wordpress.com/2015/01/577376_zabor_art_zakat_siluet_doma_oblaka_devushka_anime__2800x2000_www-gdefon-ru.jpg" /> 
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<h2>{{ $judulPage }}</h2>
		<div class="row">
			<div class="col-lg-6 col-xs-12 col-md-12">
				<div class="btn-group btn-group-sm pull-left mobile-center">
					<a href="{{ route('index.filter', ['filtertipe' => $filtertipe, 'slug' => $slugPage, 'orderby' => 'favorites', 'order' => $order]) }}" class="btn btn-default <?php if($orderby == 'favorites'){echo "active";} ?>">
						<span class="glyphicon glyphicon-heart"></span>
						Jumlah Favorite
					</a>
					<a href="{{ route('index.filter', ['filtertipe' => $filtertipe, 'slug' => $slugPage, 'orderby' => 'judul', 'order' => $order]) }}" class="btn btn-default <?php if($orderby == 'judul'){echo "active";} ?>">Judul Novel</a>
					<a href="{{ route('index.filter', ['filtertipe' => $filtertipe, 'slug' => $slugPage,'orderby' => 'tanggal', 'order' => $order]) }}" class="btn btn-default <?php if($orderby == 'tanggal' || $orderby == 'created_at'){echo "active";} ?>">
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
					<a href="{{ route('index.filter', ['filtertipe' => $filtertipe, 'slug' => $slugPage, 'orderby' => $orderby, 'order' => 'asc']) }}" class="btn btn-default <?php if($order == 'asc'){echo "active";} ?>">
						<i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
						Ascending
					</a>
					<a href="{{ route('index.filter', ['filtertipe' => $filtertipe, 'slug' => $slugPage ,'orderby' => $orderby, 'order' => 'desc']) }}" class="btn btn-default <?php if($order == 'desc'){echo "active";} ?>">
						<i class="fa fa-sort-amount-desc" aria-hidden="true"></i>
						Descending
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
<hr>
@if(count($collections) > 0)
	@foreach($collections as $data)
	@if($loop->first)
	<div class="row">
	@endif

	<div class="col-lg-6 col-md-12 col-xs-12">
		<div class="row">
			<div class="col-lg-4 col-xs-12 col-md-12">
				<a href="{{ route('index.novel', ['slug' => $data->slug_novel]) }}">
	               	@if(File::exists(public_path().'/images/novel-picture/'.$data->slug_novel.'-200.jpg'))
					<img src="{{ asset('images/novel-picture/'.$data->slug_novel.'-200.jpg') }}" class="img-rounded img-responsive center-block" alt="{{ $data->judul_novel }}">
					@else
					<img src="{{ asset('images/novel-picture/noimg.jpg') }}" style="width: 200px; height: auto" class="img-rounded img-responsive center-block">
					@endif
	            </a>
			</div>
			<div class="col-lg-8 col-xs-12 col-md-12 text-center">
				<h4 class="media-title">
	                <a href="{{ route('index.novel', ['slug' => $data->slug_novel]) }}">{{ $data->judul_novel }}</a>
	            </h4>
	            <div class="label-section">
	                @if($data->author_novel !== null)
	                <span class="label label-primary">{{ $data->author_novel }}</span>
	                @endif
	                <span class="label label-danger">
	                    <span class="glyphicon glyphicon-heart"></span>
	                    {{ count($data->favorites) }}
	                </span>
	                <span class="label label-info">
	                    <span class="glyphicon glyphicon-calendar"></span>
	                    {{ $data->created_at->format('j F, Y') }}
	                </span>
	            </div>

	            <?php
	                $totalvote = App\Rating::where('id_novel', $data->id)->count();
	                $jumlahbad = App\Rating::where('id_novel', $data->id)->where('buruk', 1)->count();
	                $jumlahneutral = App\Rating::where('id_novel', $data->id)->where('biasa', 1)->count();
	                $jumlahamazing = App\Rating::where('id_novel', $data->id)->where('luarbiasa', 1)->count();
	                if ($totalvote > 0) {
	                    if ($jumlahbad > 0) {
	                        $persentasebad = floor(($jumlahbad / $totalvote) * 100);
	                    }

	                    if ($jumlahneutral > 0) {
	                        $persentaseneutral = floor(($jumlahneutral / $totalvote) * 100);
	                    }

	                    if ($jumlahamazing > 0) {
	                        $persentaseamazing = floor(($jumlahamazing / $totalvote) * 100);
	                    }
	                }
	            ?>
	            @if($totalvote > 0)     
	            <div class="progress progress-xs">
	                <div class="progress-bar progress-bar-success" role="progressbar" style="width:{{ $persentaseamazing }}%">
	                  @if($jumlahamazing > 0)
	                    Luar Biasa ({{ $jumlahamazing }} Votes)
	                  @endif
	                </div>
	                <div class="progress-bar progress-bar-warning" role="progressbar" style="width:{{ $persentaseneutral }}%">
	                  @if($jumlahneutral > 0)   
	                    Biasa Aja ({{ $jumlahneutral }} Votes)
	                  @endif
	                </div>
	                <div class="progress-bar progress-bar-danger" role="progressbar" style="width:{{ $persentasebad }}%">
	                  @if($jumlahbad > 0)
	                    Buruk ({{ $jumlahbad }} Votes)
	                  @endif
	                </div>
	            </div>
	            @else
	            <div class="alert alert-info text-center">
	                <p style="font-size: 14px">Belum ada rating</p>
	            </div>
	            @endif
	            <div>
	            	<p style="font-size: 12px !important; text-align: justify;">
	            		<?php
			                //tinymce sub-string in grid view list
			                $konten = $data->desc_novel;
			               	$konten = strip_tags(str_replace("&nbsp;","",$konten));
			                $panjangkata = 200;
			                if (mb_strlen($konten,'UTF-8')>$panjangkata)
			                {
			                   $konten = mb_substr($konten, 0, $panjangkata-3, 'UTF-8').'...';
			                };
			                echo "$konten";
			            ?>
	            	</p>
	            	<a href="{{ route('index.novel', ['slug' => $data->slug_novel]) }}" class="btn btn-block btn-success pull-right">Read More</a>
	            	<div class="hidden-lg">
	            		<br><br>
	            	</div>
	            </div>
			</div>
		</div>
	</div>

	@if($loop->iteration % 2 == 0 && !$loop->last)
	</div>
	<br>
	<hr style="margin-top: 0">
	<div class="row">
	@endif

	@if($loop->last)
	</div>
	<br>
	<hr style="margin-top: 0">
	@endif
	@endforeach
	<div class="text-center">
		{{ $collections->links() }}
	</div>
@endif
@endsection