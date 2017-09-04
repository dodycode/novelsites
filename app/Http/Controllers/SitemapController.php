<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon;
use App\Novels;
use App\Chapters;
use App\User;

class SitemapController extends Controller
{
	public function index()
	{
		$novel = Novels::where('deleted', 0)->orderBy('created_at', 'desc')->first();
		$chapter = Chapters::where('deleted', 0)->orderBy('created_at', 'desc')->first();
		$user = User::where('is_activated', 1)->orderBy('created_at', 'desc')->first();

		return response()->view('sitemaps.index', [
      		'novel' => $novel,
      		'chapter' => $chapter,
      		'user' => $user
  		])->header('Content-Type', 'text/xml');
	}
}
