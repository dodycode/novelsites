<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Novels;
use App\Chapters;
use App\Rating;
use App\Comment;
use App\User;
use App\Favorites;
use App\FT;
use App\Likes;
use App\TipeNovel;
use App\Genres;
use App\Tags;
use Auth;
use Feeds;

class FrontEndController extends Controller
{
    public function index()
    {
        //nilai default
        $totalvote = 0;
        $jumlahBad = 0;
        $jumlahNeutral = 0;
        $jumlahAmazing = 0;
        $persentaseBad = 0;
        $persentaseNeutral = 0;
        $persentaseAmazing = 0;

        $chapters = Chapters::where('deleted', 0)->orderBy('created_at', 'desc')->paginate(20);
        $novels = Novels::where('deleted', 0)->orderBy('created_at', 'desc')->paginate(6);
        $users = User::where('is_activated', 1)->orderBy('created_at', 'desc')->paginate(6);

        return view('welcome')
        ->with('chapters', $chapters)
        ->with('novels', $novels)
        ->with('totalvote', $totalvote)
        ->with('jumlahbad', $jumlahBad)
        ->with('jumlahneutral', $jumlahNeutral)
        ->with('jumlahamazing', $jumlahAmazing)
        ->with('persentasebad', $persentaseBad)
        ->with('persentaseneutral', $persentaseNeutral)
        ->with('persentaseamazing', $persentaseAmazing)
        ->with('users', $users);
    }

    public function detailNovel($slug)
    {
    	//nilai default
    	$totalvote = 0;
    	$jumlahBad = 0;
    	$jumlahNeutral = 0;
    	$jumlahAmazing = 0;
    	$persentaseBad = 0;
    	$persentaseNeutral = 0;
    	$persentaseAmazing = 0;

        $count = Novels::where('slug_novel', $slug)->where('deleted', 0)->count();
        if($count > 0){
            $novel = Novels::where('slug_novel', $slug)->where('deleted', 0)->first();
            $chapters = Chapters::where('id_novel', $novel->id)->where('deleted', 0)->orderBy('created_at', 'desc')->paginate(10);
            $comments = Comment::where('deleted', 0)->where('id_novel', $novel->id)->orderBy('created_at', 'desc')->paginate(10);
            $cekUser = Rating::where('id_user', Auth::id())->where('id_novel', $novel->id)->first();
            $cekfavorite = Favorites::where('id_user', Auth::id())->where('id_novel', $novel->id)->first();
            $favoritcount = Favorites::where('deleted', 0)->where('id_novel', $novel->id)->count();

            // hitungan votes
            $totalvote = Rating::where('id_novel', $novel->id)->count();
            $jumlahBad = Rating::where('id_novel', $novel->id)->where('buruk', 1)->count();
            $jumlahNeutral = Rating::where('id_novel', $novel->id)->where('biasa', 1)->count();
            $jumlahAmazing = Rating::where('id_novel', $novel->id)->where('luarbiasa', 1)->count();
            if ($totalvote > 0) {
                if ($jumlahBad > 0) {
                    $persentaseBad = floor(($jumlahBad / $totalvote) * 100);
                }

                if ($jumlahNeutral > 0) {
                    $persentaseNeutral = floor(($jumlahNeutral / $totalvote) * 100);
                }

                if ($jumlahAmazing > 0) {
                    $persentaseAmazing = floor(($jumlahAmazing / $totalvote) * 100);
                }
            }

            return view('novel')
            ->with('novel', $novel)
            ->with('chapters', $chapters)
            ->with('cekuser', $cekUser)
            ->with('totalvote', $totalvote)
            ->with('jumlahbad', $jumlahBad)
            ->with('jumlahneutral', $jumlahNeutral)
            ->with('jumlahamazing', $jumlahAmazing)
            ->with('persentasebad', $persentaseBad)
            ->with('persentaseneutral', $persentaseNeutral)
            ->with('persentaseamazing', $persentaseAmazing)
            ->with('comments', $comments)
            ->with('favorite', $cekfavorite)
            ->with('favoritcount', $favoritcount);
        }else{
            abort(404);
        }
    }

    public function novels($orderby = 'tanggal', $order = 'desc')
    {
        //nilai default
        $totalvote = 0;
        $jumlahBad = 0;
        $jumlahNeutral = 0;
        $jumlahAmazing = 0;
        $persentaseBad = 0;
        $persentaseNeutral = 0;
        $persentaseAmazing = 0;

        if ($orderby == 'favorites') {
            $novels = Novels::withCount('favorites')->orderBy('favorites_count', $order)->paginate(20);
        }elseif ($orderby == 'judul') {
            $novels = Novels::where('deleted', 0)->orderBy('judul_novel', $order)->paginate(20);
        }elseif($orderby == 'tanggal'){
            $novels = Novels::where('deleted', 0)->orderBy('created_at', $order)->paginate(20);
        }
        return view('novels')
        ->with('totalvote', $totalvote)
        ->with('jumlahbad', $jumlahBad)
        ->with('jumlahneutral', $jumlahNeutral)
        ->with('jumlahamazing', $jumlahAmazing)
        ->with('persentasebad', $persentaseBad)
        ->with('persentaseneutral', $persentaseNeutral)
        ->with('persentaseamazing', $persentaseAmazing)
        ->with('novels', $novels)
        ->with('orderby', $orderby)
        ->with('order', $order);
    }

    public function ft($orderby = 'tanggal', $order = 'desc')
    {
        $ft = FT::where('deleted', 0)->orderBy('created_at', 'desc')->paginate(20);

        if ($orderby == 'likes') {
            $ft = FT::withCount('likes')->orderBy('likes_count', $order)->paginate(20);
        }elseif ($orderby == 'releases') {
            $ft = FT::withCount('chapters')->orderBy('chapters_count', $order)->paginate(20);
        }elseif($orderby == 'tanggal'){
            $ft = FT::where('deleted', 0)->orderBy('created_at', $order)->paginate(20);
        }

        return view('fantranslations')
        ->with('ft', $ft)
        ->with('orderby', $orderby)
        ->with('order', $order);
    }

    public function ftdetail($slug)
    {
        $ft = FT::where('slug', $slug)->where('deleted', 0)->first();
        $chapters = Chapters::where('id_ft', $ft->id)->orderBy('created_at', 'desc')->paginate(20);
        $cekLike = Likes::where('id_user', Auth::id())->where('id_ft', $ft->id)->count();

        return view ('fantranslation')
        ->with('ft', $ft)
        ->with('chapters', $chapters)
        ->with('cekLike', $cekLike);
    }

    public function filterNovel($filtertipe, $slug, $orderby = 'tanggal', $order = 'desc')
    {
        //nilai default
        $totalvote = 0;
        $jumlahBad = 0;
        $jumlahNeutral = 0;
        $jumlahAmazing = 0;
        $persentaseBad = 0;
        $persentaseNeutral = 0;
        $persentaseAmazing = 0;

        if($filtertipe == 'tipenovel'){
            $tipenovel = TipeNovel::select('id', 'nama_tipe', 'slug')->where('slug', $slug)->first();
            if (count($tipenovel) > 0) {
                $slugPage = $tipenovel->slug;
                $judulPage = $tipenovel->nama_tipe;

                if ($orderby == 'favorites') {
                    $novels = Novels::withCount('favorites')->where('id_tipe_novel', $tipenovel->id)->where('deleted', 0)->orderBy('favorites_count', $order)->paginate(20);
                }elseif ($orderby == 'judul') {
                    $novels = Novels::where('deleted', 0)->where('id_tipe_novel', $tipenovel->id)->orderBy('judul_novel', $order)->paginate(20);
                }elseif($orderby == 'tanggal'){
                    $novels = Novels::where('deleted', 0)->where('id_tipe_novel', $tipenovel->id)->orderBy('created_at', $order)->paginate(20);
                }

                return view('filtered-novel')
                ->with('totalvote', $totalvote)
                ->with('jumlahbad', $jumlahBad)
                ->with('jumlahneutral', $jumlahNeutral)
                ->with('jumlahamazing', $jumlahAmazing)
                ->with('persentasebad', $persentaseBad)
                ->with('persentaseneutral', $persentaseNeutral)
                ->with('persentaseamazing', $persentaseAmazing)
                ->with('collections', $novels)
                ->with('judulPage', $judulPage)
                ->with('orderby', $orderby)
                ->with('order', $order)
                ->with('slugPage', $slugPage)
                ->with('filtertipe', $filtertipe);
            }else{
                abort(404);
            }
        }elseif($filtertipe == "genres"){
            $genre = Genres::select('id', 'nama_genre', 'slug')->where('slug', $slug)->first();
            if (count($genre) > 0) {
                $slugPage = $genre->slug;
                $judulPage = $genre->nama_genre;

                 if ($orderby == 'favorites') {
                    $novels = Novels::withCount('favorites')->whereHas('genres', function ($query) use ($slug) {
                        $query->where('slug', $slug);
                    })->orderBy('favorites_count', $order)->paginate(20);
                }elseif ($orderby == 'judul') {
                    $novels = Novels::whereHas('genres', function ($query) use ($slug) {
                        $query->where('slug', $slug);
                    })->orderBy('judul_novel', $order)->paginate(20);
                }elseif($orderby == 'tanggal'){
                    $novels = Novels::whereHas('genres', function ($query) use ($slug) {
                        $query->where('slug', $slug);
                    })->orderBy('created_at', $order)->paginate(20);
                }

                return view('filtered-novel')
                ->with('totalvote', $totalvote)
                ->with('jumlahbad', $jumlahBad)
                ->with('jumlahneutral', $jumlahNeutral)
                ->with('jumlahamazing', $jumlahAmazing)
                ->with('persentasebad', $persentaseBad)
                ->with('persentaseneutral', $persentaseNeutral)
                ->with('persentaseamazing', $persentaseAmazing)
                ->with('collections', $novels)
                ->with('judulPage', $judulPage)
                ->with('orderby', $orderby)
                ->with('order', $order)
                ->with('slugPage', $slugPage)
                ->with('filtertipe', $filtertipe);
            }else{
                abort(404);
            }
        }elseif($filtertipe == "tags"){
            $tags = Tags::select('id', 'nama_tag', 'slug')->where('slug', $slug)->first();
            if (count($tags) > 0) {
                $slugPage = $tags->slug;
                $judulPage = $tags->nama_tag;

                 if ($orderby == 'favorites') {
                    $novels = Novels::withCount('favorites')->whereHas('tags', function ($query) use ($slug) {
                        $query->where('slug', $slug);
                    })->orderBy('favorites_count', $order)->paginate(20);
                }elseif ($orderby == 'judul') {
                    $novels = Novels::whereHas('tags', function ($query) use ($slug) {
                        $query->where('slug', $slug);
                    })->orderBy('judul_novel', $order)->paginate(20);
                }elseif($orderby == 'tanggal'){
                    $novels = Novels::whereHas('tags', function ($query) use ($slug) {
                        $query->where('slug', $slug);
                    })->orderBy('created_at', $order)->paginate(20);
                }

                return view('filtered-novel')
                ->with('totalvote', $totalvote)
                ->with('jumlahbad', $jumlahBad)
                ->with('jumlahneutral', $jumlahNeutral)
                ->with('jumlahamazing', $jumlahAmazing)
                ->with('persentasebad', $persentaseBad)
                ->with('persentaseneutral', $persentaseNeutral)
                ->with('persentaseamazing', $persentaseAmazing)
                ->with('collections', $novels)
                ->with('judulPage', $judulPage)
                ->with('orderby', $orderby)
                ->with('order', $order)
                ->with('slugPage', $slugPage)
                ->with('filtertipe', $filtertipe);
            }else{
                abort(404);
            }
        }elseif($filtertipe == "author"){
            $author = Novels::select('id', 'author_novel')->where('author_novel', $slug)->first();
            if (count($author) > 0) {
                $slugPage = $author->author_novel;
                $judulPage = $author->author_novel;

                if ($orderby == 'favorites') {
                    $novels = Novels::withCount('favorites')->where('author_novel', $author->author_novel)->where('deleted', 0)->orderBy('favorites_count', $order)->paginate(20);
                }elseif ($orderby == 'judul') {
                    $novels = Novels::where('deleted', 0)->where('author_novel', $author->author_novel)->orderBy('judul_novel', $order)->paginate(20);
                }elseif($orderby == 'tanggal'){
                    $novels = Novels::where('deleted', 0)->where('author_novel', $author->author_novel)->orderBy('created_at', $order)->paginate(20);
                }

                return view('filtered-novel')
                ->with('totalvote', $totalvote)
                ->with('jumlahbad', $jumlahBad)
                ->with('jumlahneutral', $jumlahNeutral)
                ->with('jumlahamazing', $jumlahAmazing)
                ->with('persentasebad', $persentaseBad)
                ->with('persentaseneutral', $persentaseNeutral)
                ->with('persentaseamazing', $persentaseAmazing)
                ->with('collections', $novels)
                ->with('judulPage', $judulPage)
                ->with('orderby', $orderby)
                ->with('order', $order)
                ->with('slugPage', $slugPage)
                ->with('filtertipe', $filtertipe);
            }else{
                abort(404);
            }
        }else{
            abort(404);
        }
    }
}
