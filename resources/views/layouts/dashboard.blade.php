<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/css/skins/skin-blue.min.css">

  <style type="text/css">
    .navbar-nav>.notifications-menu>.dropdown-menu, .navbar-nav>.messages-menu>.dropdown-menu, .navbar-nav>.tasks-menu>.dropdown-menu{
      width: 754px;
    }

    .modal-body ol li{
      font-size: 18px
    }

    @media only screen and (max-width: 800px)
    {
      .modal-body #ol{
        margin-left: -26px;
      }

      .modal-body #ol li{
        font-size: 14px;
      }
    }
  </style>

  @section('plugin')
  @show

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <a href="{{ route('index') }}" class="logo">
      <span class="logo-mini"><b>NB</b></span>
      <span class="logo-lg"><b>Novel</b>Baru</span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
      <a id="push-btn" href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            @if(Auth::guard('web')->check())
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              @if(Auth::user()->userpp !== null)
              <img src="{{ asset('images/user-picture/'.Auth::user()->userpp) }}" class="user-image" alt="User Image">
              @else
              <img src="{{ asset('images/user-picture/user.png') }}" class="user-image" alt="User Image">
              @endif
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                @if(Auth::user()->userpp !== null)
                <img src="{{ asset('images/user-picture/'.Auth::user()->userpp) }}" class="img-circle" alt="User Image">
                @else
                <img src="{{ asset('images/user-picture/user.png') }}" class="img-circle" alt="User Image">
                @endif

                <p>
                  {{ Auth::user()->name }}
                  <small>Member since {{ Auth::user()->created_at->format('j F, Y') }}</small>
                </p>
              </li>
              @else
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('images/user-picture/user.png') }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="{{ asset('images/user-picture/user.png') }}" class="img-circle" alt="User Image">

                <p>
                  {{ Auth::user()->name }}
                  <small>Member since blablabla</small>
                </p>
              </li>
              @endif
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  @if(Auth::guard('web')->check())
                  <a href="{{ route('home.profil') }}" class="btn btn-default btn-flat">Profile</a>
                  @else
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                  @endif
                </div>
                <div class="pull-right">
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">
                        Sign Out
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <aside class="main-sidebar">
    <div class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('images/user-picture/user.png') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
      @if(Auth::guard('web')->check())
        <li class="header">Fitur Utama</li>
        <li><a href="{{ route('home.chapter') }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span>Tambah Chapter</span></a></li>
        <li><a href="{{ route('home.novel') }}"><i class="fa fa-book" aria-hidden="true"></i> <span>Tambah Novel</span></a></li>
        <li><a href="{{ route('home.ft') }}"><i class="fa fa-plus" aria-hidden="true"></i> <span>Tambah Fan Translation</span></a></li>
        @if(Auth::user()->is_staff == 1)
        <li class="header">Staff Tools</li>
        <li><a href="{{ route('home.listrequest') }}"><i class="fa fa-check-square-o" aria-hidden="true"></i> Permintaan Pemasangan FT</a></li>
        @endif

        <li class="header">User Tools</li>
        <li><a href="{{ route('home.profil') }}"><i class="fa fa-user" aria-hidden="true"></i> <span>Lihat Profil</span></a></li>
      @endif

      @if(Auth::guard('admin')->check())
      <li class="header">Fitur Utama</li>
      <li><a href="{{ route('admin.novel') }}"><i class="fa fa-book" aria-hidden="true"></i> <span>Manage Novels</span></a></li>
      <li><a href="{{ route('admin.chapter') }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span>Manage Chapters</span></a></li>
      <li><a href="{{ route('admin.ft') }}"><i class="fa fa-users" aria-hidden="true"></i> <span>Manage Fan Translations</span></a></li>
      <li><a href="{{ route('admin.genre') }}"><i class="fa fa-list-alt" aria-hidden="true"></i> <span>Manage Genre Novel</span></a></li>
      <li><a href="{{ route('admin.tipenovel') }}"><i class="fa fa-list-alt" aria-hidden="true"></i> <span>Manage Tipe Novel</span></a></li>
      <li class="header">Admin Tools</li>
      <li><a href="{{ route('admin.requestjoin') }}"><i class="fa fa-users" aria-hidden="true"></i> <span>Permintaan Pemasangan FT</span></a></li>
      <li><a href="{{ route('admin.staff') }}"><i class="fa fa-user" aria-hidden="true"></i> <span>Rekrut Staff</span></a></a></li>
      <li><a href="{{ route('admin.invite') }}"><i class="fa fa-envelope" aria-hidden="true"></i> <span>Rekrut Admin</span></a></li>
      @endif
      </ul>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <div class="content-wrapper">
     @yield('content')
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- Default to the left -->
    <strong>Copyright &copy; 2017 <a href="/">NovelBaru</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->
<script src="{{ asset('js/vendor/jquery.min.js') }}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="{{ asset('js/app.min.js') }}"></script>
<script type="text/javascript">
if ($(window).width() < 800) {
  $("#push-btn").on('click', function(){
      $('.sidebar-mini').toggleClass('sidebar-open');
  });
}
else {
   $("#push-btn").on('click', function(){
      $('.sidebar-mini').toggleClass('sidebar-collapse');
  });
}
</script>
@section('plugin-js')
@show
</body>
</html>