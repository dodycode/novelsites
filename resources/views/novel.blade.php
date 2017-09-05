@extends('layouts.app')

@section('title_and_meta')
	<?php
		$kontenMeta = $novel->desc_novel;
		$kontenMeta = strip_tags(str_replace("&nbsp;","",$kontenMeta));
	?>

    <title>{{ $novel->judul_novel }} | {{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="{{ $kontenMeta }}" />

    <!-- Social Meta Tags -->
    <meta property="og:title" content="{{ $novel->judul_novel }} | {{ config('app.name', 'Laravel') }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:description" content="{{ $kontenMeta }}">
    @if(File::exists(public_path().'/images/novel-picture/'.$novel->slug_novel.'-200.jpg'))
	<meta property="og:image" content="{{ asset('images/novel-picture/'.$novel->slug_novel.'-200.jpg') }}" />
	@else
	<meta property="og:image" content="https://sumeramalik.files.wordpress.com/2015/01/577376_zabor_art_zakat_siluet_doma_oblaka_devushka_anime__2800x2000_www-gdefon-ru.jpg" />
	@endif

    <!-- Twitter Meta Cards -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:url" content="{{ url()->current() }}" />
    <meta name="twitter:title" content="{{ $novel->judul_novel }} | {{ config('app.name', 'Laravel') }}" />
    <meta name="twitter:description" content="{{ $kontenMeta }}" />
    @if(File::exists(public_path().'/images/novel-picture/'.$novel->slug_novel.'-200.jpg'))
	<meta name="twitter:image" content="{{ asset('images/novel-picture/'.$novel->slug_novel.'-200.jpg') }}" />
	@else
	<meta name="twitter:image" content="https://sumeramalik.files.wordpress.com/2015/01/577376_zabor_art_zakat_siluet_doma_oblaka_devushka_anime__2800x2000_www-gdefon-ru.jpg" />
	@endif
@endsection

@section('plugin')
<script src="{{ asset('textboxio/textboxio.js') }}"></script>
@endsection

@section('content')
@if(Session::get('Success'))
  <div class="row">
      <div id="alert" class="alert alert-info col-lg-10 col-lg-offset-1 col-xs-12 text-center" role="alert">
      	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <p>{{ Session::get('Success') }}</p>
      </div>
  </div>
@endif

<div class="row">
	<div class="col-lg-3 col-md-12 col-xs-12 text-center">
		@if(File::exists(public_path().'/images/novel-picture/'.$novel->slug_novel.'-200.jpg'))
		<img src="{{ asset('images/novel-picture/'.$novel->slug_novel.'-200.jpg') }}" class="img-rounded img-responsive center-block" alt="{{ $novel->judul_novel }}">
		@else
		<img src="{{ asset('images/novel-picture/noimg.jpg') }}" style="width: 200px; height: auto" class="img-rounded img-responsive center-block">
		@endif
		<div class="hidden-lg">
			<br>
		</div>
	</div>
	<div class="col-lg-9 col-md-12 col-xs-12">
		<h4 style="margin-top: 0">{{ $novel->judul_novel }}</h4>
		<div class="description">
			{!! $novel->desc_novel !!}
		</div>
		@if($totalvote > 0)
		<br>
		<div class="progress progress-xs">
		    <div class="progress-bar progress-bar-success" role="progressbar" style="width:{{ $persentaseamazing }}%">
		      Luar Biasa ({{ $jumlahamazing }} Votes)
		    </div>
		    <div class="progress-bar progress-bar-warning" role="progressbar" style="width:{{ $persentaseneutral }}%">
		      Biasa Aja ({{ $jumlahneutral }} Votes)
		    </div>
		    <div class="progress-bar progress-bar-danger" role="progressbar" style="width:{{ $persentasebad }}%">
		      Buruk ({{ $jumlahbad }} Votes)
		    </div>
		  </div>
		@endif
	</div>
</div>
<hr>
<div class="row">
	<div class="col-lg-3 col-md-4 col-xs-12">
		<div class="panel panel-default panel-inverse">
			<div class="panel-heading">
				Novel Information
			</div>
			<div class="panel-body">
				<dl>
					<dt>Tipe Novel</dt>
					<dd><a href="{{ route('index.filter', ['filtertipe' => 'tipenovel', 'slug' => $novel->namatipe->slug]) }}">{{ $novel->namatipe->nama_tipe }}</a></dd>
				</dl>
				<dl>
					<dt>Genre</dt>
					<ul class="list-inline" style="margin-bottom: 0">
						@foreach($novel->genres as $genre)
						<li><a href="{{ route('index.filter', ['filtertipe' => 'genres', 'slug' => $genre->slug]) }}">{{ $genre->nama_genre }}</a></li>
						@endforeach
					</ul>
				</dl>
				<dl>
					<dt>Tags</dt>
					<ul class="list-inline" style="margin-bottom: 0">
						@foreach($novel->tags as $tag)
						<li><a href="{{ route('index.filter', ['filtertipe' => 'tags', 'slug' => $tag->slug]) }}">{{ $tag->nama_tag }}</a></li>
						@endforeach
					</ul>
				</dl>
				<dl>
					<dt>Author</dt>
					<dd><a href="{{ route('index.filter', ['filtertipe' => 'author', 'slug' => $novel->author_novel]) }}">{{ $novel->author_novel }}</a></dd>
				</dl>
				<dl>
					<dt>Original Publisher</dt>
					<dd>
						@if($novel->raw_ft !== null)
							@if($novel->url_raw_ft !== null)
							<a href="{{ $novel->url_raw_ft }}">{{ $novel->raw_ft }}</a>
							@else
							{{ $novel->raw_ft }}
							@endif
						@else
						N/A
						@endif
					</dd>
				</dl>
				<dl>
					<dt>English Publisher</dt>
					<dd>
						@if($novel->raw_eng_ft !== null)
							@if($novel->url_raw_eng_ft !== null)
							<a href="{{ $novel->url_raw_eng_ft }}">{{ $novel->raw_eng_ft }}</a>
							@else
							{{ $novel->raw_eng_ft }}
							@endif
						@else
						N/A
						@endif
					</dd>
				</dl>
			</div>
		</div>
		<div class="panel panel-default panel-inverse">
			<div class="panel-heading">
				Favorites
				<span class="badge pull-right">{{ $favoritcount }}</span>
			</div>
			<div class="panel-body">
				@if(!isset($favorite))
				<button class="btn btn-success btn-block btn-sm" data-toggle="modal" data-href="{{ route('index.novel.favorit.add', ['slug' => $novel->slug_novel]) }}" data-target="#modal">Tambahkan ke Favorite list</button>
				@else
				<button class="btn btn-danger btn-block btn-sm" data-toggle="modal" data-href="{{ route('index.novel.favorit.remove', ['slug' => $novel->slug_novel]) }}" data-target="#modal">Hapus dari Favorite List</button>
				@endif
			</div>
		</div>
		<div class="panel panel-default panel-inverse">
			<div class="panel-heading">
				Beri Rating
				<span class="badge pull-right">{{ $totalvote }}</span>
			</div>
			<div class="panel-body text-center">
				@if(!isset($cekuser))
				<div class="btn-group">
				  <button type="button" class="btn btn-danger btn-outline btn-sm" data-toggle="modal" data-href="{{ route('index.novel.rate.bad', ['slug' => $novel->slug_novel]) }}" data-target="#modal">Buruk</button>
				  <button type="button" class="btn btn-primary btn-outline btn-sm" data-toggle="modal" data-href="{{ route('index.novel.rate.neutral', ['slug' => $novel->slug_novel]) }}" data-target="#modal">Biasa Saja</button>
				  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-href="{{ route('index.novel.rate.amazing', ['slug' => $novel->slug_novel]) }}" data-target="#modal">Luar Biasa</button>
				</div>
				@else
					@if($cekuser->buruk !== 0)
					<div class="alert" style="background-color: #2C3E50; color: #fff;">Kamu telah memberi rating 'Buruk' pada novel ini</div>
					@endif
					@if($cekuser->biasa !== 0)
					<div class="alert" style="background-color: #2C3E50; color: #fff;">Kamu telah memberi rating 'Biasa' pada novel ini</div>
					@endif
					@if($cekuser->luarbiasa !== 0)
					<div class="alert" style="background-color: #2C3E50; color: #fff;">Kamu telah memberi rating 'Luar Biasa' pada novel ini</div>
					@endif
				@endif
			</div>
		</div>
	</div>
	<div class="col-lg-9 col-md-8 col-xs-12" id="no-more-tables">
		@if(count($chapters) > 0)
		<h5>Latest Releases</h5>
		<table class="table table-striped table-curved table-hover cf">
			<thead class="cf" style="background-color: #2C3E50; color: #fff;">
				<th>Date</th>
				<th>Fan Translation</th>
				<th>Chapter</th>
			</thead>
			<tbody>
				@foreach($chapters as $chapter)
				<tr>
					<?php 
                        $datebefore = strtotime($chapter->tanggal);
                    ?>
                    <td data-title="Date">{{ $date = date('j F Y', $datebefore) }}</td>
					<td data-title="Fan Translation"><a href="{{ route('index.ft.detail', ['slug' => $chapter->ft->slug]) }}">{{ $chapter->ft->nama_ft }}</a></td>
					<td data-title="Chapter"><a href="{{ $chapter->url }}">{{ $chapter->chapter }}</a></td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<div class="text-center">
			{{$chapters->links()}}
		</div>
		@else
		<div class="alert alert-danger text-center" role="alert">
	        <p>Novel ini belum ada satupun rilisan</p>
	     </div>
		@endif
		<hr>
		<a href="#review">Tulis Review</a>
		<span class="pull-right">
			@if(count($comments) > 0)
			{{ count($comments) }} Review
			@else
			Tidak ada Review
			@endif
		</span>
		<hr>
		@if(count($comments) > 0)
		@foreach($comments as $comment)
		<!-- Left-aligned -->
		<div class="media">
		  <div class="media-left">
		  	@if($comment->namaUser->userpp !== null)
		  	<img src="{{ asset('images/user-picture/'.$comment->namaUser->userpp) }}" class="media-object img-circle" style="width:48px; height: auto">
		  	@else
		    <img src="{{ asset('images/user-picture/user.png') }}" class="media-object img-circle" style="width:48px; height: auto">
		    @endif
		  </div>
		  <div class="media-body">
		    <h6 class="media-heading" style="margin-top: 10px">{{ $comment->namaUser->name }} <small style="font-size: 14px !important">{{ $comment->created_at->format('j F, Y') }}</small></h6>
		    @if($comment->ch !== null)
		    <small><b>Status: {{ $comment->ch }}</b></small>
		    @else
		    <small><b>Status: N\A</b></small>
		    @endif
		    <br>
		  </div>
		  <br>
	    <div class="comment-text">
	    	{!! $comment->comment !!}
	    </div>
	    @if(Auth::id() == $comment->id_user)
	    <div class="btn-group pull-right">
		  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-{{ $comment->id }}"><span class="fa fa-pencil"></span></button>
		  <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-href="{{ route('index.novel.comment.delete', ['id' => $comment->id]) }}" data-target="#modal"><span class="fa fa-trash"></span></button>
		</div>
	    @endif
		</div>
		<hr>

		<!-- Modal Edit -->
		<div id="modal-{{ $comment->id }}" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Edit Komentar</h4>
		      </div>
		      <form action="{{ route('index.novel.comment.edit', ['id' => $comment->id]) }}" method="POST">
		      {{ csrf_field() }}
		      	<div class="modal-body">
		        	<textarea id="comment-{{ $comment->id }}" name="comment" class="form-control comment-editor" style="resize: none">{!! $comment->comment !!}</textarea>
			    </div>
			    <div class="modal-footer">
			       <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Gak jadi</button>
			       <input type="submit" class="btn btn-success btn-ok btn-sm" value="Simpan">
			    </div>
		      </form>
		    </div>
		  </div>
		</div>

		<script type="text/javascript">
			var editor = textboxio.replace('#comment-{{ $comment->id }}');
		</script>
		@endforeach
		@else
		<div class="alert alert-info">
			Belum ada review tentang novel ini
		</div>
		@endif
		@if(Auth::guest())
		<div class="alert alert-success">
			Ingin membuat review tentang novel ini? Silahkan <a href="{{ route('login') }}">Login</a> atau <a href="{{ route('register') }}">Mendaftar</a> terlebih dahulu
		</div>
		@else
		<br>
		<div id="review">
			<div class="panel panel-primary">
			  <div class="panel-heading">Buat Review</div>
			  <div class="panel-body">
			  	<form method="POST" action="{{ route('index.novel.comment', ['slug' => $novel->slug_novel]) }}">
			  	  {{ csrf_field() }}
				  <div class="form-group">
				    <label>Sudah baca sampai sejauh mana</label>
				    <select name="ch" data-target="select" class="form-control select select-inverse select-block mbl" style="margin-bottom: 0">
				      <option hidden selected></option>
					  @foreach($chapters as $chapter)
					  <option value="{{ $chapter->chapter }}">{{ $chapter->chapter }}</option>
					  @endforeach
					</select>
				    <small>Lewatkan saja kalau tidak ingin diisi</small>
				  </div>
				  <div class="form-group">
				    <label>Tulis Review</label>
				    <textarea id="comment" name="comment" class="form-control comment-editor" style="resize: none"></textarea>
				  </div>
				  <button type="submit" class="btn btn-primary btn-sm pull-right">Post Review</button>
				</form>
			  </div>
			</div>
		</div>
		@endif
	</div>
</div>
@endsection

@section('plugin-js')
<!-- Modal -->
<div id="modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
   <div class="modal-content">
  	<div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal">&times;</button>
    	<h4 class="modal-title">Konfirmasi Dulu</h4>
  	</div>
    <div class="modal-body">
        <p>Kamu Yakin?</p>	
	</div>
	<div class="modal-footer">
	    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Gak jadi</button>
	    <a role="button" class="btn btn-success btn-ok btn-sm">Iya</a>
	</div>
   </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
@if(!Auth::guest())
<script type="text/javascript">
	$(document).ready(function() {
	  $(".select").select2({
	  	placeholder: "Silahkan Dipilih"
	  });
	  textboxio.replace('#comment');
	});
</script>
@endif

<script type="text/javascript">
  $("#alert").fadeTo(2000, 500).slideUp(500, function(){
      $("#alert").slideUp(2500);
  });

  $('p').each(function() {
     var $this = $(this);
     if($this.html().replace(/\s|&nbsp;/g, '').length == 0)
        $this.remove();
    });
</script>

<script type="text/javascript">
    $('#modal').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>
@endsection