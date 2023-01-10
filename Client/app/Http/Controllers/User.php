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
        $user = Http::get(Custom::APIUSER);
        // var_dump($user->object());die;
        return view('content.user.index',[
            'title' => "Daftar User",
            'users' => $user->object()
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
        $tambah = Http::post(Custom::APIUSER, $data)->object();
        // var_dump($tambah);die;
        if($tambah->status == true){
            return redirect('/user')->with('message',$tambah->massages);
        }else{
            return redirect('/user')->with('error',$tambah->massages);
        }
    }

    public function hapus_data($email){
        $delete = Http::asForm()->delete(Custom::APIUSER,["email" => $email])->object();
        // var_dump($delete);
        if($delete->status == true){
            return redirect('/user')->with('message',$delete->massages);
        }else{
            return redirect('/user')->with('error',$delete->massages);
        }
    }

    public function dataByUsername($email){
        $users = Http::get(Custom::APIUSER,['email' => $email])->object();
        echo json_encode($users->user[0]);
    }

    public function edit_data(Request $request){
        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'level' => $request->level,
            'token' => $request->token,
        ];

        $edit = Http::put(Custom::APIUSER, $data)->object();
        if($edit->status == true){
            return redirect('/user')->with('message',$edit->massages);
        }else{
            return redirect('/user')->with('error',$edit->massages);
        }
    }
}
