@extends('layouts.dashboard')
@section('content')
<section class="content-header">
  <h1>
    Dashboard
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Admin Dashboard</a></li>
    <li class="active"><i class="fa fa-users" aria-hidden="true"></i> Manage Fan Translation</li>
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
					<h3 class="box-title">Tambah Fan Translation</h3>
				</div>
				<form role="form" method="POST" action="{{ route('admin.ft.submit') }}">
					{{ csrf_field() }}
					<div class="box-body">
						<div class="form-group">
							<label>Nama Fan Translation</label>
							<input type="text" name="nama_ft" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Alamat Website Fan Translation</label>
							<input type="url" name="url" class="form-control" placeholder="misal: http://btl.com" required>
							<small>Sertakan alamat lengkap hingga http atau https nya jika menggunakan https</small>
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
<script type="text/javascript">
	$("#alert").fadeTo(2000, 500).slideUp(500, function(){
	    $("#alert").slideUp(1000);
	});
</script>
@endsection