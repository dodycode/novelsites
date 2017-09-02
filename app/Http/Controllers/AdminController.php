<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\ftnotif;
use App\Mail\ftdecline;
use Illuminate\Support\Str;
use App\Genres;
use App\TipeNovel;
use App\FT;
use App\Chapters;
use File;
use App\User;
use App\Novels;
use App\Invite;
use App\Tags;
use App\Mail\InviteCreated;
use Auth;
use Carbon\Carbon;
use Image;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.admin.home');
    }

    public function genres()
    {
        $genres = Genres::where('deleted', 0)->paginate(10);
        return view ('dashboard.admin.genres.index')
        ->with('genres', $genres);
    }

    public function addGenres()
    {
        return view('dashboard.admin.genres.add');
    }

    public function storeGenres(Request $request)
    {
        $this->validate($request, [
            'nama_genre' => 'required'
        ]);

        $cekGenre = Genres::where('nama_genre', $request->input('nama_genre'))->where('deleted', 0)->count();
        if ($cekGenre < 1) {
            $execute = Genres::create($request->all());

            return redirect()->to(route('admin.genre'))->with('Success', 'Genre tersebut berhasil ditambahkan!');
        }else{
            return redirect()->back()->with('Error', 'Genre tersebut telah terdaftar!');
        }
    }

    public function editGenres($id)
    {
        $genre = Genres::where('id', $id)->first();

        return view('dashboard.admin.genres.edit')
        ->with('genre', $genre);
    }

    public function storeEditedGenre(Request $request, $id)
    {
        $this->validate($request, [
            'nama_genre' => 'required'
        ]);

        $cekGenre = Genres::where('nama_genre', $request->input('nama_genre'))->where('id', '<>', $id)->where('deleted', 0)->count();
        if ($cekGenre < 1) {
            $execute = Genres::find($id)->update($request->all());

            return redirect()->to(route('admin.genre'))->with('Success', 'Genre tersebut berhasil diubah!');
        }else{
            return redirect()->back()->with('Error', 'Genre tersebut telah terdaftar!');
        }
    }

    public function deleteGenre($id)
    {
        $delete = ['deleted' => 1];

        $execute = Genres::find($id)->update($delete);

        if ($execute) {
            return redirect()->to(route('admin.genre'))->with('Success', 'Genre tersebut telah berhasil dihapus!');
        }else{
            return redirect()->back()->with('Error', 'Terdapat kesalahan pada sistem, silahkan hubungi sang programmer!');
        }
    }

    public function types()
    {
        $types = TipeNovel::where('deleted', 0)->paginate(10);

        return view('dashboard.admin.types.index')
        ->with('types', $types);
    }

    public function addTypes()
    {
        return view('dashboard.admin.types.add');
    }

    public function storeTypes(Request $request)
    {
        $this->validate($request, [
            'nama_tipe' => 'required'
        ]);

        $cekType = TipeNovel::where('nama_tipe', $request->input('nama_tipe'))->where('deleted', 0)->count();
        if ($cekType < 1) {
            $execute = TipeNovel::create($request->all());
            return redirect()->to(route('admin.tipenovel'))->with('Success', 'Tipe Novel tersebut berhasil ditambahkan!');
        }else{
            return redirect()->back()->with('Error', 'Tipe Novel tersebut telah terdaftar!');
        }
    }

    public function editTypes($id)
    {
        $type = TipeNovel::where('id', $id)->first();

        return view('dashboard.admin.types.edit')
        ->with('type', $type);
    }

    public function storeEditedType(Request $request, $id)
    {
        $this->validate($request, [
            'nama_tipe' => 'required'
        ]);

        $cekTipe = TipeNovel::where('nama_tipe', $request->input('nama_tipe'))->where('id', '<>', $id)->where('deleted', 0)->count();
        if ($cekTipe < 1) {
            $execute = TipeNovel::find($id)->update($request->all());

            return redirect()->to(route('admin.tipenovel'))->with('Success', 'Tipe Novel tersebut berhasil diubah!');
        }else{
            return redirect()->back()->with('Error', 'Tipe Novel tersebut telah terdaftar!');
        }
    }

    public function deleteType($id)
    {
        $delete = ['deleted' => 1];

        $execute = TipeNovel::find($id)->update($delete);
        if ($execute) {
            return redirect()->to(route('admin.tipenovel'))->with('Success', 'Tipe Novel tersebut telah berhasil dihapus!');
        }else{
            return redirect()->back()->with('Error', 'Terdapat kesalahan pada sistem, silahkan hubungi sang programmer!');
        }
    }

    public function listRequestJoin()
    {
        $fantranslations = FT::where('deleted', 0)->where('approve', 0)->paginate(20);
        return view('dashboard.admin.requestjoin')
        ->with('fantranslations', $fantranslations);
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
            return redirect()->to(route('admin.requestjoin'))->with('Success', 'Fan Translation berhasil didaftarkan!');
        }
    }

    public function declineRequest($namaft)
    {
        $execute = FT::where('nama_ft', $namaft)->delete();
        $id_user = FT::select('id_user')->where('nama_ft', $namaft)->first();
        $user = User::find($id_user->id_user)->first();

        if ($execute) {
            Mail::to($user->email)->send(new ftdecline($id_user));
            return redirect()->to(route('admin.requestjoin'))->with('Success', 'Permintaan telah berhasil ditolak!');
        }
    }

    public function getInviteList()
    {
        $inviteList = Invite::paginate(5);
        return view('dashboard.admin.invites.index')
        ->with('invites', $inviteList);
    }

    public function createInvite()
    {
        return view('dashboard.admin.invites.create');
    }

    public function processInvite(Request $request)
    {
        // validate the incoming request data

        do {
            //generate a random string using Laravel's str_random helper
            $token = str_random();
        }   //check if the token already exists and if it does, try again
        while (Invite::where('token', $token)->first());

        //create a new invite record
        $invite = Invite::create([
            'email' => $request->get('email'),
            'token' => $token
        ]);

        // send the email
        Mail::to($request->get('email'))->send(new InviteCreated($invite));

        // redirect back where we came from
        return redirect()->to(route('admin.invite'));
    }

    public function novels()
    {
        $novels = Novels::where('deleted', 0)->orderBy('created_at', 'desc')->paginate(20);

        return view('dashboard.admin.novels.index')
        ->with('novels', $novels);
    }

    public function addNovel()
    {
        $listTipe = TipeNovel::where('deleted', 0)->get();
        $listGenre = Genres::where('deleted', 0)->get();
        $listFT = FT::where('deleted', 0)->get();
        $listTag = Tags::where('deleted', 0)->get();

        return view('dashboard.admin.novels.add')
        ->with('typesnovel', $listTipe)
        ->with('genres', $listGenre)
        ->with('fantranslations', $listFT)
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

            return redirect()->to(route('admin.home'))->with('Success', 'Novel tersebut berhasil ditambahkan!');
        }else{
            return redirect()->back()->with('Error', 'Judul Novel tersebut telah terdaftar!');
        }
    }

    public function editNovel($id)
    {
        $novel = Novels::where('id', $id)->first();
        $listTipe = TipeNovel::where('deleted', 0)->get();
        $listGenre = Genres::where('deleted', 0)->get();
        $listFT = FT::where('deleted', 0)->get();

        return view('dashboard.admin.novels.edit')
        ->with('typesnovel', $listTipe)
        ->with('genres', $listGenre)
        ->with('fantranslations', $listFT)
        ->with('novel', $novel);
    }

    public function storeEditedNovel(Request $request, $id)
    {
        $this->validate($request, [
            'judul_novel' => 'required',
            'desc_novel' => 'required',
            'id_tipe_novel' => 'required',
            'author_novel' => 'required',
        ]);

        $cekNovel = Novels::where('judul_novel', $request->input('judul_novel'))->where('id', '<>', $id)->where('deleted', 0)->count();
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
            $execute = Novels::find($id)->update($novel);

            return redirect()->to(route('admin.novel'))->with('Success', 'Novel tersebut berhasil diedit!');
        }else{
            return redirect()->back()->with('Error', 'Judul Novel tersebut telah terdaftar!');
        }
    }

    public function deleteNovel($id)
    {
        $delete = ['deleted' => 1];

        $execute = Novels::find($id)->update($delete);

        return redirect()->to(route('admin.novel'))->with('Success', 'Novel tersebut berhasil dihapus!');
    }

    public function chapters()
    {
        $chapters = Chapters::where('deleted', 0)->orderBy('created_at', 'desc')->paginate(20);

        return view('dashboard.admin.chapters.index')
        ->with('chapters', $chapters);
    }

    public function addChapter()
    {
        $listFT = FT::where('deleted', 0)->where('approve', 1)->get();
        $listNovel = Novels::where('deleted', 0)->get();

        return view('dashboard.admin.chapters.add')
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
            ];

            $execute = Chapters::create($chapter);

            return redirect()->to(route('admin.chapter'))->with('Success', 'Chapter berhasil ditambahkan!');   
        }else{
            return redirect()->back()->with('Error', 'Chapter tersebut telah terdaftar pada novel ini!');
        }
    }

    public function editChapter($id)
    {
        $chapter = Chapters::where('id', $id)->first();
        $listFT = FT::where('deleted', 0)->where('approve', 1)->get();
        $listNovel = Novels::where('deleted', 0)->get();

        return view('dashboard.admin.chapters.edit')
        ->with('fantranslations', $listFT)
        ->with('novels', $listNovel)
        ->with('chapter', $chapter);
    }

    public function storeEditedChapter(Request $request, $id)
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
        ->where('id', '<>', $id)
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
            ];

            $execute = Chapters::find($id)->update($chapter);

            return redirect()->to(route('admin.chapter'))->with('Success', 'Chapter berhasil diedit!');   
        }else{
            return redirect()->back()->with('Error', 'Chapter tersebut telah terdaftar pada novel ini!');
        }
    }

    public function deleteChapter($id)
    {
        $delete = ['deleted' => 1];

        $execute = Chapters::find($id)->update($delete);

        return redirect()->to(route('admin.chapter'))->with('Success', 'Chapter tersebut berhasil dihapus!');
    }

    public function fantranslations()
    {
        $fantranslations = FT::where('deleted', 0)->where('approve', 1)->orderBy('created_at', 'desc')->paginate(20);

        return view('dashboard.admin.ft.index')
        ->with('fantranslations', $fantranslations);
    }

    public function addFT()
    {
        return view('dashboard.admin.ft.add');
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
                'slug' => Str::slug($request->input('nama_ft')),
                'approve' => 1
            ];
            $execute = FT::create($ft);

            return redirect()->to(route('admin.ft'))->with('Success', 'FT Berhasil ditambahkan');
            
        }else{
            return redirect()->back()->with('Error', 'Nama FT tersebut telah terdaftar!');
        }
    }

    public function editFT($id)
    {
        $ft = FT::where('id', $id)->first();

        return view('dashboard.admin.ft.edit')
        ->with('ft', $ft);
    }

    public function storeEditedFT(Request $request, $id)
    {
        $this->validate($request, [
            'nama_ft' => 'required',
            'url' => 'required'
        ]);
        $cekFT = FT::where('nama_ft', $request->input('nama_ft'))->where('deleted', 0)->where('id', '<>', $id)->count();

        if ($cekFT < 1) {
            $ft = [
                'nama_ft' => $request->input('nama_ft'),
                'url' => $request->input('url'),
            ];
            $execute = FT::find($id)->update($ft);

            return redirect()->to(route('admin.ft'))->with('Success', 'FT Berhasil diedit');
            
        }else{
            return redirect()->back()->with('Error', 'Nama FT tersebut telah terdaftar!');
        }
    }

    public function deleteFT($id)
    {
        $delete = ['deleted' => 1];

        $execute = FT::find($id)->update($delete);

        return redirect()->to(route('admin.ft'))->with('Success', 'FT tersebut berhasil dihapus dari web!');

    }

    public function staff()
    {
        $users = User::where('is_activated', 1)->where('is_staff', 1)->paginate(20);

        return view('dashboard.admin.staff.index')
        ->with('users', $users);
    }

    public function addStaff()
    {
        $users = User::where('is_activated', 1)->where('is_staff', 0)->get();

        return view('dashboard.admin.staff.add')
        ->with('users', $users);
    }

    public function storeStaff(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        $rekrut = ['is_staff' => 1];

        $execute = User::find($request->get('id'))->update($rekrut);

        return redirect()->to(route('admin.staff'))->with('Success', 'User telah berhasil direkrut menjadi staff NB!');
    }

    public function pecatStaff($id)
    {
        $pecat = ['is_staff' => 0];

        $execute = User::find($id)->update($pecat);

        return redirect()->to(route('admin.staff'))->with('Success', 'User tersebut telah berhasil dicopot jabatan STAFF nya!');
    }
}
