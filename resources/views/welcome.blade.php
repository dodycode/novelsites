@extends('layouts.app')
@section('title_and_meta')
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="Pusat bagi para Fan Translation di Indonesia" />

    <!-- Social Meta Tags -->
    <meta property="og:title" content="{{ config('app.name', 'Laravel') }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:description" content="Pusat bagi para Fan Translation di Indonesia">
    <meta property="og:image" content="https://sumeramalik.files.wordpress.com/2015/01/577376_zabor_art_zakat_siluet_doma_oblaka_devushka_anime__2800x2000_www-gdefon-ru.jpg" />

    <!-- Twitter Meta Cards -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:url" content="{{ url()->current() }}" />
    <meta name="twitter:title" content="{{ config('app.name', 'Laravel') }}" />
    <meta name="twitter:description" content="Pusat bagi para Fan Translation di Indonesia" />
    <meta property="twitter:image" content="https://sumeramalik.files.wordpress.com/2015/01/577376_zabor_art_zakat_siluet_doma_oblaka_devushka_anime__2800x2000_www-gdefon-ru.jpg" /> 
@endsection

@section('content')
@if(count($chapters) > 0)
<div class="row" id="no-more-tables">
    <div class="col-xs-12">
        <h4>Latest Releases</h4>
        <table class="table table-striped table-curved table-hover cf">
            <thead class="cf">
                <tr>
                    <th width="40%">Title</th>
                    <th width="10%">Release</th>
                    <th width="30%">Fan Translations</th>
                    <th width="20%">Dirilis Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($chapters as $chapter)
                <tr>
                    <td data-title="Title"><a href="{{ route('index.novel', ['slug' => $chapter->novels->slug_novel]) }}">{{ $chapter->novels->judul_novel }}</a></td>
                    <td data-title="Release"><a href="{{ $chapter->url }}">{{ $chapter->chapter }}</a></td>
                    <td data-title="Fan Translations"><a href="{{ route('index.ft.detail', ['slug' => $chapter->ft->slug]) }}">{{ $chapter->ft->nama_ft }}</a></td>
                    <?php 
                        $datebefore = strtotime($chapter->tanggal);
                    ?>
                    <td data-title="Dirilis Tanggal">{{ $date = date('j F Y', $datebefore) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-center">
            {{ $chapters->links() }}
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="alert alert-info col-xs-12 text-center">
        <p>Belum ada satupun rilisan yang didaftarkan</p>
    </div>
</div>
@endif
<hr>
<div class="row">
    <div class="col-lg-8 col-md-12 col-xs-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <a href="{{ route('index.novel.list') }}" class="btn btn-xs btn-primary pull-right">Lainnya</a>
                <h4 class="panel-title">Latest Novel</h4>
            </div>
            <div class="panel-body">
                @if(count($novels) > 0)
                @foreach($novels as $novel)
                    @if($loop->first)
                    <div class="row">
                    @endif

                    <div class="col-lg-6 col-md-12 col-xs-12 text-center">
                        <div class="row">
                            <div class="col-lg-4 col-xs-4 col-md-4">
                                <a href="{{ route('index.novel', ['slug' => $novel->slug_novel]) }}">
                                    @if(File::exists(public_path().'/images/novel-picture/'.$novel->slug_novel.'-80.jpg'))
                                    <img src="{{ asset('images/novel-picture/'.$novel->slug_novel.'-80.jpg') }}" class="img-rounded img-responsive center-block" alt="{{ $novel->judul_novel }}">
                                    @else
                                    <img src="{{ asset('images/novel-picture/noimg.jpg') }}" style="width: 80px; height: auto;" class="img-rounded img-responsive center-block" alt="{{ $novel->judul_novel }}">
                                    @endif
                                </a>
                            </div>
                            <div class="col-lg-8 col-xs-8 col-md-8">
                                <h4 class="media-title">
                                    <a href="{{ route('index.novel', ['slug' => $novel->slug_novel]) }}">{{ $novel->judul_novel }}</a>
                                </h4>
                                <div class="label-section">
                                    @if($novel->author_novel !== null)
                                    <span class="label label-primary">{{ $novel->author_novel }}</span>
                                    @endif
                                    <span class="label label-danger">
                                        <span class="glyphicon glyphicon-heart"></span>
                                        {{ count($novel->favorites) }}
                                    </span>
                                    <span class="label label-info">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                        {{ $novel->created_at->format('j F, Y') }}
                                    </span>
                                </div>

                                <?php
                                    $totalvote = App\Rating::where('id_novel', $novel->id)->count();
                                    $jumlahbad = App\Rating::where('id_novel', $novel->id)->where('buruk', 1)->count();
                                    $jumlahneutral = App\Rating::where('id_novel', $novel->id)->where('biasa', 1)->count();
                                    $jumlahamazing = App\Rating::where('id_novel', $novel->id)->where('luarbiasa', 1)->count();
                                    if ($totalvote > 0) {
                                        if ($jumlahbad > 0) {
                                            $persentasebad = floor(($jumlahbad / $totalvote) * 100);
                                        }

                                        if ($jumlahneutral > 0) {
                                            $persentaseneutral = floor(($jumlahneutral / $totalvote) * 100);
                                        }

                                        if ($jumlahamazing > 0) {
                                            $persentaseamazing = floor(($jumlahamazing / $totalvote) * 100);
                                        }
                                    }
                                ?>
                                @if($totalvote > 0)     
                                <div class="progress progress-xs">
                                    <div class="progress-bar progress-bar-success" role="progressbar" style="width:{{ $persentaseamazing }}%">
                                      @if($jumlahamazing > 0)
                                        Luar Biasa ({{ $jumlahamazing }} Votes)
                                      @endif
                                    </div>
                                    <div class="progress-bar progress-bar-warning" role="progressbar" style="width:{{ $persentaseneutral }}%">
                                      @if($jumlahneutral > 0)   
                                        Biasa Aja ({{ $jumlahneutral }} Votes)
                                      @endif
                                    </div>
                                    <div class="progress-bar progress-bar-danger" role="progressbar" style="width:{{ $persentasebad }}%">
                                      @if($jumlahbad > 0)
                                        Buruk ({{ $jumlahbad }} Votes)
                                      @endif
                                    </div>
                                </div>
                                @else
                                <div class="alert alert-info text-center">
                                    <p style="font-size: 14px">Belum ada rating</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($loop->iteration % 2 == 0 && !$loop->last)
                    </div>
 
                    <div class="row">
                    @endif

                    @if($loop->last)
                    </div>
                    <hr>
                    @endif
                @endforeach
                @else
                <div class="alert alert-info text-center">
                    <p>Belum ada satupun novel yang didaftarkan</p>
                </div>
                @endif                 
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12 col-xs-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Latest Registered Users</h4>
            </div>
            @if(count($users) > 0)
            <ul class="list-group">
                @foreach($users as $user)
                <li class="list-group-item">
                    <div class="media">
                        <div class="media-left media-middle">
                            @if($user->userpp !== null)
                            <img src="{{ asset('images/user-picture/'.$user->userpp) }}" style="width: 48px; height: auto" class="img-circle" alt="novelbaru">
                            @else
                            <img src="{{ asset('images/user-picture/user.png') }}" style="width: 48px; height: auto" class="img-circle" alt="novelbaru">
                            @endif
                        </div>
                        <div class="media-body media-middle">
                            <h4 class="media-title">{{ $user->name }}</h4>
                            <div class="label-section">
                                <span class="label label-primary">Bergabung Sejak {{ $user->created_at->format('j, F Y') }}</span>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            @else
            <div class="panel-body">
                <div class="alert alert-info text-center">
                    <p>Belum ada</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection