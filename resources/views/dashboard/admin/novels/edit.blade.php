@extends('layouts.dashboard')
@section('plugin')
	<style type="text/css">
		[class^='select2'] {
		  border-radius: 0px !important;
		  box-shadow: none !important;
		  border-color: #d2d6de !important;
		}
		@media screen and (max-width: 767px) {
		    .select2 {
		        width: 100% !important;
		    }
		}
	</style>
	<script src="https://cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script>
@endsection

@section('content')
<section class="content-header">
  <h1>
    Dashboard
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Admin Dashboard</a></li>
    <li class="active"><i class="fa fa-book" aria-hidden="true"></i> Manage Novel</li>
  </ol>
</section>

<section class="content container-fluid">
	<div class="row">
		@if(Session::get('Error'))
          <div class="row">
              <div id="alert" class="alert alert-danger col-lg-10 col-lg-offset-1 col-xs-12 text-center" role="alert">
                {{ Session::get('Error') }}
              </div>
          </div>
        @endif
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Edit Novel</h3>
				</div>
				<form role="form" method="POST" action="{{ route('admin.novel.storeEdit', ['id' => $novel->id]) }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="box-body">
						<div class="form-group">
	                    	<label>Gambar Cover</label>
	                    	<br>
	                    	@if($novel->cover_novel !== null)
	                    	<img src="{{ asset('images/novel-picture/'.$novel->cover_novel) }}" id="showgambar" style="max-width: 300px; max-height: 300px;"/>
	                    	@else
	                    	<img src="{{ asset('images/novel-picture/noimg.jpg') }}" id="showgambar" style="max-width: 300px; max-height: 300px;"/>
	                    	@endif
	                  	</div>
	                  	<div class="form-group">
	                    	<input id="gambar_post" name="cover_novel" type="file" />
	                    	<small>Lewatkan saja jika tidak ada perubahan pada cover</small>
	                  	</div>
						<div class="form-group">
							<label>Judul Novel</label>
							<input type="text" name="judul_novel" value="{{ $novel->judul_novel }}" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Deksripsi Novel</label>
							<textarea id="desc" name="desc_novel" class="form-control" style="resize: none; height: 300px" required>{!! $novel->desc_novel !!}</textarea>
						</div>
						<div class="form-group">
							<label>Tipe Novel</label>
							<select id="select1" class="form-control select2" name="id_tipe_novel" required>
								@foreach($typesnovel as $tipe)
								<option <?php if($novel->id_tipe_novel == $tipe->id){echo "selected";} ?> value="{{ $tipe->id }}">{{ $tipe->nama_tipe }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label>Author Novel</label>
							<input type="text" name="author_novel" value="{{ $novel->author_novel }}" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Original Publisher</label>
							<input type="text" name="raw_ft" class="form-control" value="{{ $novel->raw_ft }}" placeholder="Kosongkan saja jika tidak ada">
						</div>
						<div class="form-group">
							<label>Alamat Website Original Publisher</label>
							<input type="url" name="url_raw_ft" class="form-control" value="{{ $novel->url_raw_ft }}" placeholder="Kosongkan saja jika tidak ada">
							<small>Sertakan alamat lengkap hingga http atau https nya jika menggunakan https</small>
						</div>
						<div class="form-group">
							<label>English Publisher</label>
							<input type="text" name="raw_eng_ft" class="form-control" value="{{ $novel->raw_eng_ft }}" placeholder="Kosongkan saja jika tidak ada">
						</div>
						<div class="form-group">
							<label>Alamat Website English Publisher</label>
							<input type="url" name="url_raw_eng_ft" value="{{ $novel->url_raw_eng_ft }}" class="form-control" placeholder="Kosongkan jika tidak ada">
							<small>Sertakan alamat lengkap hingga http atau https nya jika menggunakan https</small>
						</div>
					</div>
					<div class="box-footer">
						<div class="form-group">
							<input type="submit" class="btn btn-primary btn-block" value="Edit">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
@endsection

@section('plugin-js')
<div id="modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Hah?</h4>
      </div>
      <div class="modal-body">
        <p>Tolong diisi dulu deskripsi novelnya :)</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">
	$("#alert").fadeTo(2000, 500).slideUp(500, function(){
	    $("#alert").slideUp(500);
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
	  $("#select1").select2({
	  	 placeholder: "Silahkan Dipilih",
	  	 theme: "bootstrap"
	  });
	  $("#select2").select2({
	  	 placeholder: "Silahkan Dipilih",
	  	 theme: "bootstrap"
	  });
	});
</script>

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

<script type="text/javascript">
	CKEDITOR.replace('desc');
	 $("form").submit(function(e) {
        var messageLength = CKEDITOR.instances['desc'].getData().replace(/<[^>]*>/gi,'').length;
        if(!messageLength) {
            $('#modal').modal('show');
            e.preventDefault();
        }
    });
</script>
@endsection