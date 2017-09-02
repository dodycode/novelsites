<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Novels;
use App\Chapters;
use App\FT;
use App\Rating;
use App\Comment;
use App\Favorites;
use App\Likes;
use Auth;

class UserController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function badRate($slug)
    {
    	$id_novel = Novels::select('id', 'slug_novel')->where('slug_novel', $slug)->first();
        $cek = Rating::where('id_user', Auth::id())->where('id_novel', $id_novel->id)->count();
        if ($cek < 1) {
            $rate = [
                'id_user' => Auth::id(),
                'id_novel' => $id_novel->id,
                'buruk' => 1
            ];

            $execute = Rating::create($rate);

            if ($execute) {
                return redirect()->back()->with('Success', 'Penilaian kamu telah di kirimkan! Terima kasih atas penilaiannya');
            }
        }else{
            return redirect()->to(route('index.novel', ['slug' => $id_novel->slug_novel]));
        }
    }

    public function neutralRate($slug)
    {
    	$id_novel = Novels::select('id')->where('slug_novel', $slug)->first();
        $cek = Rating::where('id_user', Auth::id())->where('id_novel', $id_novel->id)->count();
        if ($cek < 1) {
        	$rate = [
        		'id_user' => Auth::id(),
        		'id_novel' => $id_novel->id,
        		'biasa' => 1
        	];

        	$execute = Rating::create($rate);

        	if ($execute) {
        		return redirect()->back()->with('Success', 'Penilaian kamu telah di kirimkan! Terima kasih atas penilaiannya');
        	}
        }else{
            return redirect()->to(route('index.novel', ['slug' => $id_novel->slug_novel]));
        }
    }

    public function amazingRate($slug)
    {
    	$id_novel = Novels::select('id')->where('slug_novel', $slug)->first();
        $cek = Rating::where('id_user', Auth::id())->where('id_novel', $id_novel->id)->count();
        if ($cek < 1) {
        	$rate = [
        		'id_user' => Auth::id(),
        		'id_novel' => $id_novel->id,
        		'luarbiasa' => 1
        	];

        	$execute = Rating::create($rate);

        	if ($execute) {
        		return redirect()->back()->with('Success', 'Penilaian kamu telah di kirimkan! Terima kasih atas penilaiannya');
        	}
        }else{
            return redirect()->to(route('index.novel', ['slug' => $id_novel->slug_novel]));
        }
    }

    public function makeReview(Request $request, $slug)
    {
        $this->validate($request, [
            'comment' => 'required'
        ]);

        if($request->input('comment') == null || strlen($request->input('comment')) <= 150)
        {
            return redirect()->back()->with('Success', 'Maaf, jika ingin review, buatlah review minimal 150 kata!');
        }else{
            $novel = Novels::select('id')->where('slug_novel', $slug)->first();
            $cekReview = Comment::where('id_user', Auth::id())->where('id_novel', $novel->id)->count();
            if ($cekReview < 1) {
                $ch = null;

                if ($request->has('ch')) {
                    $ch = $request->input('ch');
                }

                $postcomment = [
                    'id_user' => Auth::id(),
                    'id_novel' => $novel->id,
                    'ch' => $ch,
                    'comment' => $request->input('comment')
                ];

                $execute = Comment::create($postcomment);

                if ($execute) {
                    return redirect()->back()->with('Success', 'Sipp review kamu telah dikirimkan!');
                }   
            }else{
                return redirect()->back()->with('Success', 'Kamu sudah membuat review tentang novel ini, seseorang hanya dapat mereview 1x pada setiap novel');
            }
        }
    }

    public function editReview(Request $request, $id)
    {
        $this->validate($request, [
            'comment' => 'required'
        ]);

        if($request->input('comment') == null || strlen($request->input('comment')) <= 150)
        {
            return redirect()->back()->with('Success', 'Maaf, jika ingin review, buatlah review minimal 150 kata!');
        }else{
            $postcomment = [
                'comment' => $request->input('comment')
            ];

            $execute = Comment::find($id)->update($postcomment);

            if ($execute) {
                return redirect()->back()->with('Success', 'Sipp review kamu telah berhasil diedit!');
            }
        }
    }

    public function deleteReview($id)
    {
        $delete = Comment::find($id)->delete();

        if ($delete) {
            return redirect()->back()->with('Success', 'Sipp review kamu telah berhasil dihapus!');
        }
    }

    public function addFavorite($slug)
    {
        $id_novel = Novels::select('id')->where('slug_novel', $slug)->first();
        $cek = Favorites::where('id_novel', $id_novel->id)->where('id_user', Auth::id())->count();
        if ($cek < 1) {
            $favorite = 
            [
                'id_user' => Auth::id(),
                'id_novel' => $id_novel->id
            ];

            $execute = Favorites::create($favorite);

            if ($execute) {
                return redirect()->back()->with('Success', 'Novel berhasil ditambahkan ke favorite list');
            }
        }else{
            return redirect()->to(route('index.novel', ['slug' => $id_novel->slug_novel]));
        }
    }

    public function removeFavorite($slug)
    {
        $id_novel = Novels::select('id')->where('slug_novel', $slug)->first();
        $cek = Favorites::where('id_novel', $id_novel->id)->where('id_user', Auth::id())->count();
        if ($cek > 0) {

            $execute = Favorites::where('id_user', Auth::id())->where('id_novel', $id_novel->id)->delete();

            if ($execute) {
                return redirect()->back()->with('Success', 'Novel telah dihapus dari favorite list');
            }
        }else{
            return redirect()->to(route('index.novel', ['slug' => $id_novel->slug_novel]));
        }
    }

    public function addLike($slug)
    {
        $ft = FT::select('id')->where('slug', $slug)->first();
        $cek = Likes::where('id_ft', $ft->id)->where('id_user', Auth::id())->count();
        if ($cek < 1) {
            $like = 
            [
                'id_ft' => $ft->id,
                'id_user' => Auth::id()
            ];

            $execute = Likes::create($like);

            if ($execute) {
                return redirect()->back()->with('Success', 'Kamu telah memberi Like pada FT ini');
            }
        }else{
            return redirect()->back();
        }
    }

    public function removeLike($slug)
    {
        $ft = FT::select('id')->where('slug', $slug)->first();
        $cek = Likes::where('id_ft', $ft->id)->where('id_user', Auth::id())->count();
        if ($cek > 0) {
            $execute = Likes::where('id_user', Auth::id())->where('id_ft', $ft->id)->delete();

            if ($execute) {
                return redirect()->back()->with('Success', 'Kamu telah melepas Like kamu pada FT ini');
            }
        }else{
            return redirect()->back();
        }
    }
}
