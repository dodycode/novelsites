@extends('layouts.app')
@section('title_and_meta')
<title>{{ $ft->nama_ft }} | {{ config('app.name', 'Laravel') }}</title>
<meta name="description" content="Detail Fan Translation yang terdaftar di NovelBaru" />

<!-- Social Meta Tags -->
<meta property="og:title" content="{{ $ft->nama_ft }} | {{ config('app.name', 'Laravel') }}"/>
<meta property="og:type" content="article"/>
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:description" content="Detail Fan Translation yang terdaftar di NovelBaru">
<meta property="og:image" content="https://sumeramalik.files.wordpress.com/2015/01/577376_zabor_art_zakat_siluet_doma_oblaka_devushka_anime__2800x2000_www-gdefon-ru.jpg" />

<!-- Twitter Meta Cards -->
<meta name="twitter:card" content="summary" />
<meta name="twitter:url" content="{{ url()->current() }}" />
<meta name="twitter:title" content="{{ $ft->nama_ft }} | {{ config('app.name', 'Laravel') }}" />
<meta name="twitter:description" content="Detail Fan Translation yang terdaftar di NovelBaru" />
<meta property="twitter:image" content="https://sumeramalik.files.wordpress.com/2015/01/577376_zabor_art_zakat_siluet_doma_oblaka_devushka_anime__2800x2000_www-gdefon-ru.jpg" /> 
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
	<div class="col-xs-12">
		<h2>{{ $ft->nama_ft }}</h2>
		<hr>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<table class="table table-striped table-curved table-hover" style="margin-bottom: 10px">
			<thead>
				<th>FT Info</th>
				<th>&nbsp;</th>
			</thead>
			<tbody>
				<tr>
					<td>Nama FT</td>
					<td>{{ $ft->nama_ft }}</td>
				</tr>
				<tr>
					<td>Website</td>
					<td><a href="{{ $ft->url }}" target="_blank">Link</a></td>
				</tr>
				<tr>
					<td>Telah Merilis</td>
					<td>{{ count($ft->chapters) }} Chapter</td>
				</tr>
			</tbody>
		</table>
		@if($cekLike < 1)
		<button class="btn btn-sm pull-right btn-primary" data-toggle="modal" data-href="{{ route('index.ft.like.add', ['slug' => $ft->slug]) }}" data-target="#modal"><span class="fa fa-thumbs-o-up"></span> Like</button>
		@else
		<button class="btn btn-sm pull-right btn-danger" data-toggle="modal" data-href="{{ route('index.ft.like.remove', ['slug' => $ft->slug]) }}" data-target="#modal"><span class="fa fa-thumbs-up"></span> Hapus Like</button>
		@endif
	</div>
</div>
<hr>
<div class="row" id="no-more-tables">
	<div class="col-xs-12">
		<h4>Daftar Rilisan</h4>
		@if(count($chapters) > 0)
		<table class="table table-striped table-curved table-hover cf">
            <thead class="cf">
                <tr>
                    <th width="50%">Title</th>
                    <th width="10%">Release</th>
                    <th width="20%">Dirilis Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($chapters as $chapter)
                <tr>
                    <td data-title="Title"><a href="{{ route('index.novel', ['slug' => $chapter->novels->slug_novel]) }}">{{ $chapter->novels->judul_novel }}</a></td>
                    <td data-title="Release"><a href="{{ $chapter->url }}">{{ $chapter->chapter }}</a></td>
                    <?php 
                        $datebefore = strtotime($chapter->tanggal);
                    ?>
                    <td data-title="Dirilis Tanggal">{{ $date = date('j F Y', $datebefore) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-center">
        	{{ $chapters->links() }}
        </div>
        @else
        <div class="alert alert-info">
        	FT ini belum pernah menginput apapun pada website ini
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
        <p>Kamu yakin?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Gak jadi</button>
        <a role="button" class="btn btn-success btn-ok btn-sm">Iya</a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $("#alert").fadeTo(2000, 500).slideUp(500, function(){
      $("#alert").slideUp(2500);
  });
</script>

<script type="text/javascript">
    $('#modal').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>
@endsection