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
            'username' => $request->username,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'level' => $request->level,
            'password' => $request->password,
        ];
        $tambah = Http::post(Custom::APIUSER, $data)->object();
        var_dump($tambah);die;
        if($tambah->status == true){
            return redirect('/user')->with('message',$tambah->messages);
        }else{
            return redirect('/user')->with('error',$tambah->messages);
        }
    }

    public function hapus_data($username){
        $delete = Http::asForm()->delete(Custom::APIUSER,["username" => $username])->object();
        return redirect('/user')->with('message',$delete->status);
    }

    public function dataByUsername($username){
        $users = Http::get(Custom::APIUSER,['username' => $username])->object();
        echo json_encode($users->user[0]);
    }

    public function edit_data(Request $request){
        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'level' => $request->level,
            'token' => $request->token,
        ];

        Http::put(Custom::APIUSER, $data);
        return redirect('/user');
    }
}
