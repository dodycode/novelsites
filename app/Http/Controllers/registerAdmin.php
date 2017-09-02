<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Admin;
use App\Invite;

class registerAdmin extends Controller
{
    // User Invitation
    public function processRegistration($token)
    {
         // Look up the invite
        if (!$invite = Invite::where('token', $token)->first()) {
            //if the invite doesn't exist do something more graceful than this
            abort(404);
        }

        return view('dashboard.admin.invites.register')
        ->with('invite', $invite);
    }

    public function storeRegistration(Request $request, $token)
    {
         // Look up the invite
        if (!$invite = Invite::where('token', $token)->first()) {
            //if the invite doesn't exist do something more graceful than this
            abort(404);
        }

        // create the user with the details from the invite form
        $createUser = 
        [
            'name' => $request->input('name'),
            'email' => $invite->email,
            'password' => Hash::make($request->input('password'))
        ];

        $execute = Admin::create($createUser);

        // delete the invite so it can't be used again
        $invite->delete();

        return redirect()->to(route('admin.login'))->with('Success', 'Silahkan login untuk melanjutkan');
    }
}
