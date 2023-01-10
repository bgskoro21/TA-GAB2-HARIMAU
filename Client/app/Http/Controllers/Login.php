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
        return view('login.login',[
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

    public function forgotPassword(){
        return view('login.forgot',[
            'title' => 'Forgot Password'
        ]);
    }

    public function verifikasi(Request $request){
        $verifikasi = Http::get(Custom::APIVERIFIKASI, [
            'email' => $request->email,
            'token' => $request->token
        ])->object();

        if($verifikasi->status == true){
            return redirect('/login')->with('loginError','<div class="alert alert-success text-center" role="alert">
            '.$verifikasi->massages.'
            </div>');
        }else{
            return redirect('/login')->with('loginError','<div class="alert alert-danger text-center" role="alert">
            '.$verifikasi->massages.'
            </div>');
        }
    }

    public function sendForgot(Request $request){
       $forgot = Http::post(Custom::APIFORGOTPASSWORD,['email' => $request->email, 'url' => 'http://127.0.0.1:8000/changepassword'])->object();
       if($forgot->status == true){
            return redirect('/forgotpassword')->with('loginError','<div class="alert alert-success text-center" role="alert">
            '.$forgot->massages.'
            </div>');
       }else{
            return redirect('/forgotpassword')->with('loginError','<div class="alert alert-danger text-center" role="alert">
            '.$forgot->massages.'
            </div>');
       }
    }

    public function changePassword(Request $request){
        $email = $request->email;
        $token = $request->token;
        $reset = Http::get(Custom::APIRESETPASSWORD, ['email' => $email, 'token' => $token])->object();
        var_dump($reset);die;
        // if($reset->status == true){

        // }
    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/login');
    }
}
