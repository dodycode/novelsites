@extends('layouts.dashboard')
@section('content')
<section class="content-header">
  <h1>
   	Daftar Permintaan Pemasangan FT
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li class="active"><i class="fa fa-users" aria-hidden="true"></i> Permintaan Pemasangan FT</li>
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
  				<h3 class="box-title">Daftar FT</h3>
  				<br>
  				<small>Berikut adalah daftar Fan Translation yang ingin di daftarkan pada website ini</small>
  			</div>
  			<div class="box-body table-bordered table-responsive">
        @if(count($fantranslations) > 0)
  				<table class="table table-hover">
  					<thead>
  						<th style="width: 50%">Fan Translation</th>
  						<th style="width: 50%">Action</th>
  					</thead>
  					<tbody>
  						@foreach($fantranslations as $ft)
  						<tr>
  							<td>{{ $ft->nama_ft }}</td>
  							<td>
  								<button role="links" class="btn btn-success btn-sm" data-href="{{ route('home.listrequest.accept', ['namaft' => $ft->nama_ft]) }}" data-toggle="modal" data-target="#modal1">
  									Terima Permintaan
  								</button>

                  <button role="links" class="btn btn-danger btn-sm" data-href="{{ route('home.listrequest.decline', ['namaft' => $ft->nama_ft]) }}" data-toggle="modal" data-target="#modal1">
                    Tolak Permintaan
                  </button>

                  <a href="{{ $ft->url }}" class="btn btn-primary btn-sm">Kunjungi FT</a>
  							</td>
  						</tr>
  						@endforeach
  					</tbody>
  				</table>
          @else
          <div class="alert alert-success text-center">
            <p>Tidak ada permintaan untuk saat ini</p>
          </div>
          @endif
  			</div>
  			<div class="box-footer clearfix text-center">
         {{ $fantranslations->links() }}
        </div>
  		</div>
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
	  		Yakin?
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