@extends('layouts.dashboard')
@section('content')
<section class="content-header">
  <h1>
    Dashboard
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active"><i class="fa fa-users" aria-hidden="true"></i> Add Fan Translation</li>
  </ol>
</section>

<section class="content container-fluid">
  <div class="row">
    <div class="col-lg-10 col-lg-offset-1 col-xs-12 alert alert-success alert-dismissible text-justify" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <p>Semua Fan Translation yang ditambahkan akan melewati proses verifikasi terlebih dahulu, jadi pastikan Alamat / URL yang kamu masukkan valid / bisa di akses</p>
      <br>
      <p>Jika Fan Translation kamu sesuai dengan persyaratan, maka akan kami terima dan FT kamu akan terdaftar disini. Namun jika sebaliknya, maka akan kami tolak.</p>
      <br>
      <p>Belum tahu apa saja persyaratan dari NovelBaru? Silahkan <a data-toggle="modal" href="#modal">Klik Disini</a></p>
      <br><br>
      <p><b>Important Note</b>: Saat request di terima ataupun ditolak, pemberitahuan akan dikirimkan ke email akun yang digunakan pada saat mendaftarkan FT</p>
    </div>
  </div>
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
				<form role="form" method="POST" action="{{ route('home.ft.submit') }}">
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
<div id="modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Persyaratan NovelBaru</h4>
      </div>
      <div class="modal-body text-justify">
        <ol id="ol">
        	<li>Fans Translation yang didaftarkan harus memakai terjemahan manual, tidak diperkenankan memakai Machine Translator (MTL)</li>
        	<br>
        	<li>Fans Translation tidak boleh terlibat drama apapun, bila pernah terlibat apalagi dalam drama besar, maka akan kami crosscheck terlebih dahulu.</li>
        	<br>
        	<li>Fans Translation yang sangat gemar apalagi terang-terangan menagih donasi pada reader tidak diperkenankan bergabung bersama NovelBaru.</li>
        	<br>
        	<li>Semua novel yang didaftarkan merupakan hasil terjemahan ssndiri, dan bukan hasil copy-paste (copas) dari Fans Translation lain.</li>
        	<br>
        	<li>Dilarang membuat keributan bahkan sampai menyinggung SARA.</li>
        	<br>
        	<li>Feel Free and Welcome to NovelBaru.</li>
        </ol>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$("#alert").fadeTo(2000, 500).slideUp(500, function(){
	    $("#alert").slideUp(1000);
	});
</script>
@endsection