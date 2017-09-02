<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use UserActivation;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:web')->except('logout');
    }

    public function loginUser(Request $request)
    {
        $this->validate($request, [

            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $fields = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::guard('web')->attempt($fields, $request->remember)) {
            if(Auth::user()->is_activated == 1){
                return redirect()->intended(route('index'));
            }else{
                return redirect()->back()->with('Error', 'Akun belum diverifikasi, silahkan verifikasi terlebih dahulu');
            }
        }else{
             return redirect()->back()->with('Error', 'Password atau Email yang kamu masukkan salah! Silahkan di cek kembali');
        }

        return redirect()->back()->withInput($request->only('email', 'remember'));
    }
}
