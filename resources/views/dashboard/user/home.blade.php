@extends('layouts.dashboard')
@section('content')
 <!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Dashboard
  </h1>
  <ol class="breadcrumb">
    <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
  </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
    @if(Session::get('Success'))
      <div class="row">
          <div class="alert alert-info col-lg-10 col-lg-offset-1 col-xs-12 text-center" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3>{{ Session::get('Success') }}</h3>
          </div>
      </div>
    @endif
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Welcome</h3>
            </div>
            <div class="box-body">
              Selamat datang {{ Auth::user()->name }}!
            </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 col-xs-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Statistik Member</h3>
          </div>
          <div class="box-body table-bordered table-responsive">
            <table class="table table-hover">
              <thead>
                <th style="width: 100px">Stat</th>
                <th class="text-center" style="width: 100px">Count</th>
              </thead>
              <tbody>
                <tr>
                  <td>Added Chapters</td>
                  <td class="text-center"><span class="badge bg-light-blue">{{ $chapter }}</span></td>
                </tr>
                <tr>
                  <td>Added Novels</td>
                  <td class="text-center"><span class="badge bg-light-blue">{{ $novel }}</span></td>
                </tr>
                <tr>
                  <td>Added Fan Translation</td>
                  <td class="text-center"><span class="badge bg-light-blue">{{ $ft }}</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-xs-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Latest Activities</h3>
          </div>
          @if(count($logs) > 0)
          <div class="box-body table-bordered table-responsive">
            <table class="table table-hover">
              <thead>
                <th style="width: 100px">Date</th>
                <th style="width: 100px">Action</th>
              </thead>
              <tbody>
                @foreach($logs as $log)
                <tr>
                  <td>{{ $log->created_at->format('j F Y') }}</td>
                  <td>{!! $log->action !!}</td>                  
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="box-footer clearfix text-center">
            {{ $logs->links() }}
          </div>
          @else
          <div class="box-body">
            Belum ada kegiatan terakhir yang dilakukan.
          </div>
          @endif
        </div>
      </div>
    </div>
</section>
@endsection
