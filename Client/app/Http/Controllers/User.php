<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Custom;
use RealRashid\SweetAlert\Facades\Alert;
// use RealRashid\SweetAlert\Facades\Alert;

class User extends Controller
{
    public function index(){
        if(session('level') != 'Admin'){
            return redirect('/')->with('error','Anda bukan seorang Admin!');
        }
        $user = Http::withToken(session('token'))->get(Custom::APIUSER)->object();
        if(isset($user->result)){
            session()->flush();
            return redirect('/login')->with('loginError','<div class="alert alert-danger text-center" role="alert">Token anda sudah habis, silahkan login kembali!
            </div>');
        }
        // var_dump($user->object());die;
        return view('content.user.index',[
            'title' => "Daftar User",
            'users' => $user
        ]);
    }

    public function add_data(Request $request){

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'level' => $request->level,
            'password' => $request->password,
            'url' => 'http://127.0.0.1:8000/login/verifikasi'
        ];
        $tambah = Http::withToken(session('token'))->post(Custom::APIUSER, $data)->object();
        // var_dump($tambah);die;
        if(isset($tambah->result)){
            session()->flush();
            return redirect('/login')->with('loginError','<div class="alert alert-danger text-center" role="alert">Token anda sudah habis, silahkan login kembali!
            </div>');
        }

        if($tambah->status == true){
            return redirect('/user')->with('message',$tambah->massages);
        }
        else{
            return redirect('/user')->with('error',$tambah->massages);
        }
    }

    public function hapus_data($email){
        $delete = Http::withToken(session('token'))->asForm()->delete(Custom::APIUSER,["email" => $email])->object();
        // var_dump($delete);
        if(isset($delete->result)){
            session()->flush();
            return redirect('/login')->with('loginError','<div class="alert alert-danger text-center" role="alert">Token anda sudah habis, silahkan login kembali!
            </div>');
        }
        if($delete->status == true){
            return redirect('/user')->with('message',$delete->massages);
        }
        else{
            return redirect('/user')->with('error',$delete->massages);
        }
    }

    public function dataByUsername($email){
        $users = Http::withToken(session('token'))->get(Custom::APIUSER,['email' => $email])->object();
        if(isset($users->result)){
            session()->flush();
            return redirect('/login')->with('loginError','<div class="alert alert-danger text-center" role="alert">Token anda sudah habis, silahkan login kembali!
            </div>');
        }
        echo json_encode($users->user[0]);
    }

    public function edit_data(Request $request){
        $data = [
            'email' => $request->email,
            'level' => $request->level,
            'token' => $request->token,
        ];

        $edit = Http::withToken(session('token'))->put(Custom::APIUSER, $data)->object();
        if(isset($edit->result)){
            if($edit->result == 0){
                session()->flush();
                return redirect('/login')->with('loginError','<div class="alert alert-danger text-center" role="alert">Token anda sudah habis, silahkan login kembali!
                </div>');
            }
        }

        if($edit->status == true){
            // echo 'Hai';die;
            if($data['token'] == session('email')){
                session()->put([
                    'email' => $request->email,
                    'level' => $request->level
                ]);
            }
            return redirect('/user')->with('message',$edit->massages);
        }
        else{
            return redirect('/user')->with('error',$edit->massages);
        }
    }
}
