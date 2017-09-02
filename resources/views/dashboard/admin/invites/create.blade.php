@extends('layouts.dashboard')
@section('content')
<section class="content-header">
  <h1>
    Tambah Genre
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.home') }}"><i class="fa fa-dashboard"></i> Admin Dashboard</a></li>
    <li class="active"><a href="{{ route('admin.invite') }}"><i class="fa fa-envelope" aria-hidden="true"></i> Undang Admin</a></li>
    <li class="active">Undang Admin Baru</li>
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
					<h3 class="box-title">Undang Admin</h3>
				</div>
				<form role="form" method="POST" action="{{ route('admin.invite.submit') }}">
					{{ csrf_field() }}
					<div class="box-body">
						<div class="form-group">
							<label>Email Admin</label>
							<input type="email" name="email" class="form-control" required>
							<small>Pastikan email tersebut valid</small>
						</div>
					</div>
					<div class="box-footer">
						<div class="form-group">
							<input type="submit" class="btn btn-primary btn-block" value="Undang">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
@endsection

@section('plugin-js')
<script type="text/javascript">
	$("#alert").fadeTo(2000, 500).slideUp(500, function(){
	    $("#alert").slideUp(1000);
	});
</script>
@endsection