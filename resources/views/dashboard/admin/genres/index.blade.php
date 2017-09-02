@extends('layouts.dashboard')
@section('content')
<section class="content-header">
  <h1>
   	Daftar Genre Novel
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard" aria-hidden="true"></i>Admin Dashboard</a></li>
    <li class="active"><i class="fa fa-list-alt" aria-hidden="true"></i> Manage Genre Novel</li>
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
    				<h3 class="box-title">Genre Novel</h3>
    				<br>
    				<small>Berikut genre novel yang dapat dipilih pada website ini</small>
    			</div>
    			<div class="box-body table-bordered table-responsive">
    				<table class="table table-hover">
    					<thead>
    						<th style="width: 50%">Genre</th>
    						<th style="width: 50%">Action</th>
    					</thead>
    					<tbody>
    						@foreach($genres as $genre)
    						<tr>
    							<td>{{ $genre->nama_genre }}</td>
    							<td>
    								<a href="{{ route('admin.genre.edit', ['id' => $genre->id]) }}" class="btn btn-primary btn-sm">
									  <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah Nama
									</a>
									<button role="links" class="btn btn-danger btn-sm" data-href="{{ route('admin.genre.delete', ['id' => $genre->id]) }}" data-toggle="modal" data-target="#modal1">
										<i class="fa fa-trash-o" aria-hidden="true"></i> Hapus Genre
									</button>
    							</td>
    						</tr>
    						@endforeach
    					</tbody>
    				</table>
    			</div>
    			<div class="box-footer clearfix text-center">
	            	{{ $genres->links() }}
	          	</div>
    		</div>
    	</div>
    </div>
    <div class="row">
    	<div class="col-xs-12">
    		<a href="{{ route('admin.genre.add') }}" class="btn btn-primary btn-lg pull-right">Tambah Genre</a>
    	</div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
      	</div>
	  	<div class="modal-body">
	  		Yakin ingin menghapus data ini?	
	  	</div>
	  	<div class="modal-footer">
	    	<button type="button" class="btn btn-danger" data-dismiss="modal">Gak jadi</button>
	    	<a role="button" class="btn btn-success btn-ok">Iya</a>
	  	</div>
    </div>
  </div>
</div>
@endsection

@section('plugin-js')
<script type="text/javascript">
	$('#modal1').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>

<script type="text/javascript">
	$("#alert").fadeTo(2000, 500).slideUp(500, function(){
	    $("#alert").slideUp(1000);
	});
</script>
@endsection