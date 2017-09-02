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
@endsection

@section('content')
<section class="content-header">
  <h1>
    Dashboard
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.home') }}"><i class="fa fa-dashboard"></i> Admin Dashboard</a></li>
    <li class="active"><i class="fa fa-user" aria-hidden="true"></i> Rekrut Staff</li>
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
					<h3 class="box-title">Rekrut Staff</h3>
				</div>
				<form role="form" method="POST" action="{{ route('admin.staff.submit') }}">
					{{ csrf_field() }}
					<div class="box-body">
						<div class="form-group">
							<label>Pilih User</label>
							<select name="id" id="select1" class="form-control select2" required>
								<option value="" selected hidden></option>
								@foreach($users as $user)
								<option value="{{ $user->id }}">{{ $user->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="box-footer">
						<div class="form-group">
							<input type="submit" class="btn btn-primary btn-block" value="Rekrut">
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
	});
</script>
@endsection