<?php

namespace App\Http\Controllers;

use App\Helpers\Custom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Login extends Controller
{
    public function index(){
        if(!is_null(session('nama_lengkap'))){
            return redirect('/');
        }
        return view('login.index',[
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request){
        $request->validate(
            [
            'username' => 'required',
            'password' => 'required'
            ],
            [
                'username.required' => 'Username harus diisi!',
                'password.required' => 'Password harus diisi!',
            ]
    );

        $login = Http::post(Custom::APILOGIN,[
            'username' => $request->username,
            'password' => $request->password
        ])->json();
        if(isset($login['user'])){
            Session::put($login['user']);
            return redirect()->intended('/');
        }

        // Jika autentikasi gagal maka jalankan perintah dibawah
        return back()->with('loginError','<div class="alert alert-danger text-center" role="alert">
        '.$login['status'].'
        </div>');


    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/login');
    }
}
