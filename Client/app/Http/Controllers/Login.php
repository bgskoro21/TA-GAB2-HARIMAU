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
            'email' => 'required',
            'password' => 'required'
            ],
            [
                'email.required' => 'Email harus diisi!',
                'password.required' => 'Password harus diisi!',
            ]
    );

        $login = Http::post(Custom::APILOGIN,[
            'email' => $request->email,
            'password' => $request->password
        ])->json();
        if($login['status'] == 1){
            Session::put($login['userdata']);
            return redirect()->intended('/');
        }

        // Jika autentikasi gagal maka jalankan perintah dibawah
        return back()->with('loginError','<div class="alert alert-danger text-center" role="alert">
        '.$login['message'].'
        </div>');


    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/login');
    }
}
