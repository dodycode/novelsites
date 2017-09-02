<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- META SEO -->
    <meta name="author" content="NovelBaru Corporation" />
    <meta name="keywords" content="NovelBaru, Novel Baru, FT" />
    @yield('title_and_meta')

    <!-- Styles -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="{{ asset('css/flat-ui.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css">
        dd{
            line-height: 2
        }

        dl{
            margin-bottom: 20px;
        }

        thead{
            background-color: #34495e;
            color: #fff;
        }

        .panel-inverse .panel-heading{
            background-color: #34495e;
            color: #fff;
        }

        .panel-inverse{
            border: none;
            margin-bottom: 60px;
        }

        .panel-inverse .panel-body{
            background-color: #f9f9f9;
        }

        .badge{
            padding: 7px 7px;
        }

        .table-curved {
            border-collapse: collapse;
        }
        .table-curved {
            border-radius: 6px;
            border-left:0px;
        }
        .table-curved th {
            border-top: none;
        }
        .table-curved th:first-child {
            border-radius: 6px 0 0 0;
        }
        .table-curved th:last-child {
            border-radius: 0 6px 0 0;
        }
        .table-curved th:only-child{
            border-radius: 6px 6px 0 0;
        }

        .description p span{
            font-style: inherit !important;
            font-family: inherit !important;
            font-size: 18px !important;
            margin: 0 0 8px;
        }

        .description p{
            text-align: justify !important;
        }

        .btn{
            transition: all .5s;
        }

        label{
            font-weight: 700 !important;
        }

        small{
            font-size: 80% !important;
        }

        .navbar-nav>li>.dropdown-menu{
            border-radius: 0;
            margin-top: 0;
        }

        .navbar-collapse .navbar-nav.navbar-right:last-child>.dropdown:last-child>a{
            border-radius: 0;
        }

        .media-title{
            font-size: 18px;
            font-weight: 300;
            margin-bottom: 0px;
            margin-top: 0;
        }

        .label-section{
            font-size: 12px;
            display: inline-table;
        }

        .btn-xs, .btn-group-xs>.btn{
            padding: 5px 9px;
        }

        .progress.progress-xs{
            height: 20px;
        }

        .progress.progress-xs .progress-bar{
            line-height: 18px;
        }

        .checkbox label:after{
            content: '';
            display: table;
            clear: both;
        }

        .checkbox .cr{
            position: relative;
            display: inline-block;
            border: 1px solid #a9a9a9;
            border-radius: .25em;
            width: 1.3em;
            height: 1.3em;
            float: left;
            margin-right: .5em;
        }

        .checkbox .cr .cr-icon{
            position: absolute;
            font-size: .8em;
            line-height: 0;
            top: 50%;
            left: 20%;
        }

        .checkbox label input[type="checkbox"]{
            display: none;
        }

        .checkbox label input[type="checkbox"] + .cr > .cr-icon{
            transform: scale(3) rotateZ(-20deg);
            opacity: 0;
            transition: all .3s ease-in;
        }

        .checkbox label input[type="checkbox"]:checked + .cr > .cr-icon{
            transform: scale(1) rotateZ(0deg);
            opacity: 1;
        }

        .checkbox label input[type="checkbox"]:disabled + .cr{
            opacity: .5;
        }

        #modal .modal-dialog .modal-content .modal-body ol li{
            font-size: 18px
        }

        .comment-text{
            text-align: justify;
        }

        .comment-text p{
            font-size: 16px;
        }

        .fr-box.fr-basic .fr-element p {
            font-size: 16px;
        }

        .comment-editor{
            height: 300px !important;
        }

        @media only screen and (max-width: 800px) {
            h2{
                font-size: 35px;
            }

            .description p span{
                font-size: 16px !important;
            }

            .center-block.img-responsive{
                margin-top: 25px;
            }

            .pull-right.mobile-center, .pull-left.mobile-center{
                float: inherit !important;
                margin-bottom: 20px;  
            }

            .btn-sm, .btn-group-sm>.btn{
                font-size: 10px;
            }

            /* Force table to not be like tables anymore */
            #no-more-tables table, 
            #no-more-tables thead, 
            #no-more-tables tbody, 
            #no-more-tables th, 
            #no-more-tables td, 
            #no-more-tables tr { 
                display: block; 
            }
         
            /* Hide table headers (but not display: none;, for accessibility) */
            #no-more-tables thead tr { 
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
         
            #no-more-tables tr { border: 1px solid #ccc; }
         
            #no-more-tables td { 
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee; 
                position: relative;
                padding-left: 50%; 
                white-space: normal;
                text-align:left;
            }
         
            #no-more-tables td:before { 
                /* Now like a table header */
                position: absolute;
                /* Top/left values mimic padding */
                top: 6px;
                left: 6px;
                width: 45%; 
                padding-right: 10px; 
                white-space: nowrap;
                text-align:left;
                font-weight: bold;
            }
         
            /*
            Label the data
            */
            #no-more-tables td:before { content: attr(data-title); }

            .media-title{
                margin-top: 15px;
            }

            .konten-novel{
                text-align: center;
            }
        }

        @media only screen and (max-width: 320px){
            .btn-sm, .btn-group-sm>.btn{
                font-size: 8px;
            }
        }

        @media only screen and (max-width: 300px){
            .btn-sm, .btn-group-sm>.btn{
                font-size: 7px;
            }
        }
    </style>
    @section('plugin')
    @show
</head>
<body>
    <div id="app">
        <header>
            <div class="navbar navbar-inverse navbar-lg navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <!-- Branding Image -->
                        <a class="navbar-brand" href="{{ route('index') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>
                    <div class="navbar-collapse collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav hidden-lg">
                            <li><a href="http://forum.novelbaru.online">Forum</a></li>
                            <li><a href="{{ route('index.novel.list') }}">Novels Listing</a></li>
                            <li><a href="#">Novel Finder</a></li>
                            <li><a href="#">Fan Translations</a></li>
                        </ul>

                        <form class="navbar-form navbar-left" action="#" role="search">
                          <div class="form-group">
                            <div class="input-group">
                              <input class="form-control" id="navbarInput-01" type="search" placeholder="Search">
                              <span class="input-group-btn">
                                <button type="submit" class="btn"><span class="fui-search"></span></button>
                              </span>
                            </div>
                          </div>
                        </form>

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            @if (Auth::guest())
                                <li><a href="{{ route('login') }}">Login</a></li>
                                <li><a href="{{ route('register') }}">Register</a></li>
                            @else
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ route('home') }}">Dashboard</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <br><br>
            <div class="navbar navbar-inverse navbar-static-top hidden-xs hidden-md">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".main-nav">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse main-nav">
                        <ul class="nav navbar-nav">
                            <li><a href="http://forum.novelbaru.online">Forum</a></li>
                            <li><a href="{{ route('index.novel.list') }}">Novels Listing</a></li>
                            <li><a href="#">Novel Finder</a></li>
                            <li><a href="{{ route('index.novel.ft') }}">Fan Translations</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <div class="hidden-lg">
            <br><br>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('js/flat-ui.min.js') }}"></script>
    <script src="{{ asset('js/vendor/html5shiv.js') }}"></script>
    <script src="{{ asset('js/vendor/respond.min.js') }}"></script>
    <script src="{{ asset('js/vendor/video.js') }}"></script>
    <script type="text/javascript">
        // Focus state for append/prepend inputs
        $('.input-group').on('focus', '.form-control', function () {
          $(this).closest('.input-group, .form-group').addClass('focus');
        }).on('blur', '.form-control', function () {
          $(this).closest('.input-group, .form-group').removeClass('focus');
        });
    </script>
    @section('plugin-js')
    @show
</body>
</html>
