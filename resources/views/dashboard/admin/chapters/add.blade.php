@extends('layouts.dashboard')
@section('plugin')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/css/pikaday.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/pikaday.min.js"></script>

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
@endsection

@section('content')
<section class="content-header">
  <h1>
    Dashboard
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Admin Dashboard</a></li>
    <li class="active"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Manage Chapter</li>
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
					<h3 class="box-title">Tambah Chapter</h3>
				</div>
				<form role="form" method="POST" action="{{ route('admin.chapter.submit') }}">
					{{ csrf_field() }}
					<div class="box-body">
						<div class="form-group">
							<label>Pilih Novel</label>
							<select name="id_novel" id="select1" class="form-control select2" required>
								<option value="" selected hidden></option>
								@foreach($novels as $novel)
								<option value="{{ $novel->id }}">{{ $novel->judul_novel }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label>Chapter</label>
							<input type="text" class="form-control" name="chapter" maxlength="20" required>
							<small>Misal: <b>ch1</b> (untuk chapter 1) atau v1ch1 (untuk volume 1 chapter 1)</small>
						</div>
						<div class="form-group">
							<label>Fan Translation yang Mengerjakan</label>
							<select name="id_ft" id="select2" class="form-control select2" required>
								<option value="" selected hidden></option>
								@foreach($fantranslations as $ft)
								<option value="{{ $ft->id }}">{{ $ft->nama_ft }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label>Link to Chapter</label>
							<input type="url" name="url" class="form-control" required>
							<small>Sertakan alamat lengkap hingga http atau https nya jika menggunakan https</small>
						</div>
						<div class="form-group">
							<label>Release Date</label>
							<input type="text" id="datepicker" class="form-control" name="tanggal">
							<small><b>Pilih tanggal jika chapter direlease kemarin atau bukan hari ini, tapi jika di release hari ini, lewatkan saja bagian ini</b></small>
						</div>
					</div>
					<div class="box-footer">
						<div class="form-group">
							<input type="submit" class="btn btn-primary btn-block" value="Tambahkan">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
@endsection

@section('plugin-js')
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

<script type="text/javascript">
  $(document).ready(function(){
    var date_picker = new Pikaday(
    {
        field: document.getElementById('datepicker'),
        maxDate: new Date()
    });
  });
</script>
@endsection