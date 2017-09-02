@extends('layouts.dashboard')
@section('content')
<section class="content-header">
  <h1>
   	Daftar Genre Novel
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>Admin Dashboard</a></li>
    <li class="active"><i class="fa fa-envelope" aria-hidden="true"></i> Undang Admin</li>
  </ol>
</section>

<section class="content container-fluid">
	@if(Session::get('Success'))
      <div class="row">
          <div id="alert" class="alert alert-success col-lg-10 col-lg-offset-1 col-xs-12 text-center" role="alert">
            {{ Session::get('Success') }}
          </div>
      </div>
    @endif

    @if(Session::get('Error'))
      <div class="row">
          <div id="alert" class="alert alert-danger col-lg-10 col-lg-offset-1 col-xs-12 text-center" role="alert">
            {{ Session::get('Error') }}
          </div>
      </div>
    @endif

    <div class="row">
    	<div class="col-xs-12">
    		<div class="box">
    			<div class="box-header with-border">
    				<h3 class="box-title">Daftar Calon Admin</h3>
    				<br>
    				<small>Berikut adalah daftar admin yang belum menerima invite / undangan di emailnya</small>
    			</div>
    			<div class="box-body table-bordered table-responsive">
          @if(count($invites) > 0)
    				<table class="table table-hover">
    					<thead>
    						<th>Email</th>
    					</thead>
    					<tbody>
    						@foreach($invites as $invite)
    						<tr>
    							<td>{{ $invite->email }}</td>
    						</tr>
    						@endforeach
    					</tbody>
    				</table>
    			</div>
    			<div class="box-footer clearfix text-center">
          	{{ $invites->links() }}
        	</div>
        @else
        <div class="alert alert-success text-center">
          <p>Tidak ada satupun daftar undangan admin yang masih menunggu saat ini</p>
        </div>
        @endif
    		</div>
    	</div>
    </div>
    <div class="row">
    	<div class="col-xs-12">
    		<a href="{{ route('admin.invite.add') }}" class="btn btn-primary btn-lg" style="margin-left: 16px">Undang Admin Baru</a>
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