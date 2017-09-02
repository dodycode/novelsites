@extends('layouts.dashboard')
@section('content')
<section class="content-header">
  <h1>
    {{ Auth::user()->name }}
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active"><i class="fa fa-user" aria-hidden="true"></i> Profil</li>
  </ol>
</section>

<section class="content container-fluid">
<div class="row">
	<div class="col-lg-4 col-md-4 col-xs-12">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Profile Data</h3>
			</div>
			<div class="box-body">
				<p class="text-center">
					@if(Auth::user()->userpp !== null)
	            	<img src="{{ asset('images/user-picture/'.Auth::user()->userpp) }}" class="img-circle" style="width: auto; height: 250px;"/>
	            	@else
	            	<img src="{{ asset('images/user-picture/user.png') }}" class="img-circle" style="width: auto; height: 250px;"/>
	            	@endif
				</p>
				<p class="text-center">
					<button class="btn btn-lg btn-success" data-toggle="modal" data-target="#modal">Ubah Foto</button>
				</p>
				<div class="form-group">
					<label>Email</label>
					<br>
					<span>{{ Auth::user()->email }}</span>
				</div>
				<div class="form-group">
					<label>Mendaftar Sejak</label>
					<br>
					<span>{{ Auth::user()->created_at->format('j F, Y') }}</span>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-8 col-md-8 col-xs-12">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Daftar Novel Favorit</h3>
			</div>
			<div class="box-body">
				@if(count($novels) > 0)
				<ul class="list-group" style="margin: 0">
					@foreach($novels as $novel)
					<li class="list-group-item">
						<a href="{{ route('index.novel', ['slug' => $novel->novels->slug_novel]) }}">
							{{ $novel->novels->judul_novel }}
						</a>
					</li>
					@endforeach
				</ul>
				@else
				<div class="alert alert-info text-center">
					<p>Belum ada satupun novel yang ditambahkan</p>
				</div>
				@endif
			</div>
		</div>
	</div>
	<div class="col-lg-8 col-md-8 col-xs-12">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Memberi Rating</h3>
			</div>
			<div class="box-body">
				@if(count($ratings) > 0)
				<ul class="list-group" style="margin: 0">
					@foreach($ratings as $rating)
					<li class="list-group-item">
						@if($rating->buruk == 1)
						<span class="badge" style="background-color: #dd4b39; border-color: #d73925;">Buruk</span>
						@elseif($rating->biasa == 1)
						<span class="badge" style="background-color: #3c8dbc; border-color: #367fa9;">Biasa</span>
						@elseif($rating->luarbiasa == 1)
						<span class="badge" style="background-color: rgb(0, 166, 90); border-color: rgb(0, 141, 76);">Luar Biasa</span>
						@endif
						<a href="{{ route('index.novel', ['slug' => $rating->novels->slug_novel]) }}">{{ $rating->novels->judul_novel }}</a>
					</li>
					@endforeach
				</ul>
				@else
				<div class="alert alert-info text-center">
					<p>Belum ada satupun novel yang diberi rating</p>
				</div>
				@endif
			</div>
			@if(count($ratings) > 0)
			<div class="box-footer">
				<div class="text-center">
					{{ $ratings->links() }}
				</div>
			</div>
			@endif
		</div>
	</div>
</div>
</section>
@endsection
@section('plugin-js')
<!-- Modal -->
<div id="modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ubah Foto</h4>
      </div>
      <form method="POST" action="{{ route('home.profil.pp') }}" enctype="multipart/form-data">
      	{{ csrf_field() }}
      	<div class="modal-body text-center">
    		<div class="form-group">
        		@if(Auth::user()->userpp !== null)
        		<img src="{{ asset('images/user-picture/'.Auth::user()->userpp) }}" class="img-circle" id="showgambar" style="width: 300px; height: 300px;"/>
        		@else
        		<img src="{{ asset('images/user-picture/user.png') }}" class="img-circle" id="showgambar" style="width: 300px; height: 300px;"/>
        		@endif
      		</div>
      		<div class="form-group">
        		<input id="gambar_post" class="form-control" name="userpp" type="file" required />
      		</div>
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        	<button type="submit" class="btn btn-success">Simpan Perubahan</button>
      	</div>
      </form>
    </div>
  </div>
</div>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#showgambar').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#gambar_post").change(function () {
        readURL(this);
    });
</script>
@endsection