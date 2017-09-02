<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ActivationMail;
use App\UserActivation;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:web');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function register(Request $request){
        $this->validator($request->all())->validate();
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $aktivasi = [
            'id_user' => $user->id,
            'token' => str_random()
        ];

        $execute = UserActivation::create($aktivasi);

        Mail::to($user->email)->send(new ActivationMail($execute));

        return redirect()->to('login')->with('Success',"Pendaftaran berhasil!. Kami telah mengirim kode verifikasi pada email kamu, silahkan di verifikasi dulu.");
    }

    public function userActivation($token)
    {
        $check = UserActivation::where('token', $token)->first();

        if (!is_null($check)) {
            $user = User::find($check->id_user);

            if ($user->is_activated == 1) {
                return redirect()->to('login')
                    ->with('info',"Akun tersebut sudah terdaftar dan terverifikasi"); 
            }

            $user->update(['is_activated' => 1]);
            $delete = UserActivation::where('token', $token)->delete();

            return redirect()->to('login')
                ->with('Success',"Sip! akun telah berhasil diverifikasi, sekarang kamu sudah bisa login dengan akun tersebut.");
        }else{
            return redirect()->to('login')
                ->with('Error',"verifikasi kode tidak valid, pastikan akun kamu diverifikasikan secara benar");
        }
    }
}
