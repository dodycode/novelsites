<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\ftnotif;
use App\Mail\ftdecline;
use Auth;
use App\FT;
use App\TipeNovel;
use App\Genres;
use App\Novels;
use App\Chapters;
use App\Logs;
use App\User;
use App\Invite;
use App\Rating;
use App\Favorites;
use App\Tags;
use File;
use Feeds;
use Carbon\Carbon;
use Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jumlahNovel = Novels::where('deleted', 0)->where('id_user', Auth::id())->count();
        $jumlahFT = FT::where('deleted', 0)->where('id_user', Auth::id())->where('approve', 1)->count();
        $jumlahChapter = Chapters::where('deleted', 0)->where('id_user', Auth::id())->count();
        $logs = Logs::where('deleted', 0)->where('id_user', Auth::id())->orderBy('created_at', 'desc')->paginate(3);

        return view('dashboard.user.home')
        ->with('ft', $jumlahFT)
        ->with('novel', $jumlahNovel)
        ->with('chapter', $jumlahChapter)
        ->with('logs', $logs);
    }

    public function ft()
    {
        return view('dashboard.user.add-ft');
    }

    public function storeFT(Request $request)
    {
        $this->validate($request, [
            'nama_ft' => 'required',
            'url' => 'required'
        ]);
        $cekFT = FT::where('nama_ft', $request->input('nama_ft'))->where('deleted', 0)->count();

        if ($cekFT < 1) {
            $ft = [
                'nama_ft' => $request->input('nama_ft'),
                'url' => $request->input('url'),
                'id_user' => Auth::id(),
                'slug' => Str::slug($request->input('nama_ft'))
            ];
            $execute = FT::create($ft);

            // Catat ke log
            $action = "Mengirim permintaan pendaftaran [".$request->input('nama_ft')."]";
            $log = [
                'action' => $action,
                'id_user' => Auth::id()
            ];

            $executeLogs = Logs::create($log);

            return redirect()->to(route('home'))->with('Success', 'Permintaan berhasil dikirim! dan saat ini sedang dalam proses pengecekan, jika sesuai persyaratan FT kamu akan terdaftar disini');
            
        }else{
            return redirect()->back()->with('Error', 'Nama FT tersebut telah terdaftar!');
        }
    }

    public function novel()
    {
        $listTipe = TipeNovel::where('deleted', 0)->get();
        $listGenre = Genres::where('deleted', 0)->get();
        $listFT = FT::where('deleted', 0)->get();
        $listTag = Tags::where('deleted', 0)->get();


        return view('dashboard.user.add-novel')
        ->with('typesnovel', $listTipe)
        ->with('genres', $listGenre)
        ->with('tags', $listTag);
    }

    public function storeNovel(Request $request)
    {
        $this->validate($request, [
            'judul_novel' => 'required',
            'desc_novel' => 'required',
            'id_tipe_novel' => 'required',
            'id_genre' => 'required',
            'id_tag' => 'required',
            'author_novel' => 'required',
        ]);

        $cekNovel = Novels::where('judul_novel', $request->input('judul_novel'))->where('deleted', 0)->count();
        if ($cekNovel < 1) {
            // Slug link novel
            $slug_novel = Str::slug($request->input('judul_novel'));

            // Atur cover
            if ($request->file('cover_novel') !== null) {
                $coverKecil = Image::make($request->file('cover_novel'));
                $coverBesar = Image::make($request->file('cover_novel'));

                $coverKecil->resize(80, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $coverBesar->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $namaCoverKecil = $slug_novel."-80.jpg";
                $namaCoverBesar = $slug_novel."-200.jpg";

                // Check dulu apakah img sudah ada
                if (File::exists(public_path().'/images/novel-picture/'.$namaCoverKecil) || File::exists(public_path().'/images/novel-picture/'.$namaCoverBesar)) {
                    File::delete(public_path().'/images/novel-picture/'.$namaCoverKecil);
                    File::delete(public_path().'/images/novel-picture/'.$namaCoverBesar);
                }

                $coverKecil->save('images/novel-picture/'.$namaCoverKecil, 85);
                $coverBesar->save('images/novel-picture/'.$namaCoverBesar, 85);
            }
            $novel = [
                'slug_novel' => $slug_novel,
                'judul_novel' => $request->input('judul_novel'),
                'desc_novel' => $request->input('desc_novel'),
                'id_tipe_novel' => $request->get('id_tipe_novel'),
                'author_novel' => $request->input('author_novel'),
                'raw_ft' => $request->input('raw_ft'),
                'url_raw_ft' => $request->input('url_raw_ft'),
                'raw_eng_ft' => $request->input('raw_eng_ft'),
                'url_raw_eng_ft' => $request->input('url_raw_eng_ft'),
                'id_user' => Auth::id()
            ];

            //execute
            $execute = Novels::create($novel);

            // Atur one to many relation
            // Ambil id novel yg baru saja terbuat
            $id_novel = Novels::find($execute->id);

            // Kirim id nya ke table penghubung 'novel_genre' bersamaan dengan id_genre yang telah dipilih di form
            $id_novel->genres()->sync($request->get('id_genre'));

            // Tags
            $tags = [];
            foreach ($request->get('id_tag') as $tag) {
                if (Tags::find($tag)) {
                    $tags[] = $tag;
                }else{
                    $t = ['nama_tag' => $tag];
                    $executeTag = Tags::updateOrCreate($t);

                    $tags[] = $executeTag->id;
                }
            }
            $id_novel->tags()->sync($tags);

            // Catat ke log
            $action = "Menambahkan Novel [".$request->input('judul_novel')."]";
            $log = [
                'action' => $action,
                'id_user' => Auth::id()
            ];

            $executeLogs = Logs::create($log);

            return redirect()->to(route('home'))->with('Success', 'Novel tersebut berhasil ditambahkan!');
        }else{
            return redirect()->back()->with('Error', 'Judul Novel tersebut telah terdaftar!');
        }
    }

    public function chapters()
    {
        $listFT = FT::where('deleted', 0)->where('approve', 1)->get();
        $listNovel = Novels::where('deleted', 0)->get();

        return view('dashboard.user.add-chapter')
        ->with('fantranslations', $listFT)
        ->with('novels', $listNovel);
    }

    public function storeChapter(Request $request)
    {
        $this->validate($request, [
            'id_novel' => 'required',
            'chapter' => 'required',
            'url' => 'required',
            'id_ft' => 'required'
        ]);

        $cekChapter = Chapters::where('deleted', 0)
        ->where('chapter', $request->input('chapter'))
        ->where('id_novel', $request->get('id_novel'))
        ->count();

        if ($cekChapter < 1) {
            if ($request->has('tanggal')){
                $tanggal = date("Y-m-d",  strtotime($request->input('tanggal')));
            }else{
                $tanggal = Carbon::now();
            }

            $chapter = [
                'id_novel' => $request->get('id_novel'),
                'chapter' => $request->input('chapter'),
                'url' => $request->input('url'),
                'tanggal' => $tanggal,
                'id_ft' => $request->input('id_ft'),
                'id_user' => Auth::id()
            ];

            $execute = Chapters::create($chapter);

            // Catat ke log
            $namaft = FT::select('nama_ft')->where('id', $request->input('id_ft'))->first();
            $action = "Menambahkan Chapter [".$request->input('chapter')."] pada novel [".$namaft->nama_ft."]";
            $log = [
                'action' => $action,
                'id_user' => Auth::id()
            ];

            $executeLogs = Logs::create($log);

            return redirect()->to(route('home'))->with('Success', 'Chapter berhasil ditambahkan!');   
        }else{
            return redirect()->back()->with('Error', 'Chapter tersebut telah terdaftar pada novel ini!');
        }
    }

    public function profil()
    {
        $ratings = Rating::where('id_user', Auth::id())->paginate(10);
        $novels = Favorites::where('id_user', Auth::id())->paginate(10);
        return view('dashboard.user.profil')
        ->with('ratings', $ratings)
        ->with('novels', $novels);
    }

    public function ubahPP(Request $request)
    {
        $this->validate($request, [
            'userpp' => 'required'
        ]);

        $pp = Image::make($request->file('userpp'));
        $pp->resize(300, 300);

        $namaPP = Auth::user()->email.".jpg";

        // Check dulu apakah img sudah ada
        if (File::exists(public_path().'/images/user-picture/'.$namaPP)) {
            File::delete(public_path().'/images/user-picture/'.$namaPP);
        }

        //Pindahkan file
        $pp->save('images/user-picture/'.$namaPP, 85);

        $userpp = ['userpp' => $namaPP];

        $execute = User::find(Auth::id())->update($userpp);
        if ($execute) {
            return redirect()->to(route('home.profil'));
        }
    }

    public function listRequestJoin()
    {
        if (Auth::user()->is_staff == 1) {
            $fantranslations = FT::where('deleted', 0)->where('approve', 0)->paginate(20);
            return view('dashboard.user.requestjoin')
            ->with('fantranslations', $fantranslations);
        }else{
            return redirect()->to(route('home'))->with('Success', 'Kamu tidak memiliki akses untuk fitur ini, maaf.');
        }
    }

    public function acceptRequest($namaft)
    {
        $setApprove = [
            'approve' => 1
        ];

        $execute = FT::where('nama_ft', $namaft)->update($setApprove);
        $id_user = FT::select('id_user')->where('nama_ft', $namaft)->first();
        $user = User::find($id_user->id_user)->first();

        if ($execute) {
            Mail::to($user->email)->send(new ftnotif($id_user));
            return redirect()->to(route('home.listrequest'))->with('Success', 'Fan Translation berhasil didaftarkan!');
        }
    }

    public function declineRequest($namaft)
    {
        $execute = FT::where('nama_ft', $namaft)->delete();
        $id_user = FT::select('id_user')->where('nama_ft', $namaft)->first();
        $user = User::find($id_user->id_user)->first();

        if ($execute) {
            Mail::to($user->email)->send(new ftdecline($id_user));
            return redirect()->to(route('home.listrequest'))->with('Success', 'Permintaan telah berhasil ditolak!');
        }
    }
}
