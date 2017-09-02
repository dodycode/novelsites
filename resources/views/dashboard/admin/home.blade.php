@extends('layouts.dashboard')

@section('content')
 <!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Dashboard
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Admin Dashboard</a></li>
    <li class="active">Welcome Page</li>
  </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
    <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Welcome</h3>
        </div>
        <div class="box-body">
          Selamat datang Admin {{ Auth::user()->name }}!
        </div>
      </div>
</section>
@endsection
