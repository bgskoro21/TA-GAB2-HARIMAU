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
            return redirect('/expToken');
        }
        // var_dump($user->object());die;
        return view('content.user.index',[
            'title' => "Daftar User",
            'users' => $user,
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
            return redirect('/expToken');
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
            return redirect('/expToken');
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
            echo json_encode($users);
        }else{
            echo json_encode($users->user[0]);
        }
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
                return redirect('/expToken');
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

    public function detailUser(Request $request){
        $email = $request->email;
        $user = Http::withToken(session('token'))->get(Custom::APIUSER,['current' => $email])->object();
        if(isset($user->result)){
            return redirect('/expToken');
        }

        return view('content.user.detail',[
            'title' => 'Detail User',
            'current_user' => $user->user
        ]);
        // var_dump($user);
    }

    public function filterUser(Request $request){
        $keyword = $request->keyword;
        $output = '';
        $users = Http::withToken(session('token'))->get(Custom::APIFILTERUSER, ['keyword' => $keyword])->object();
        if(isset($users->result)){
            return redirect('/expToken');
        }

        if($users->status == true){
            foreach($users->searching as $user){
                    $output .= '  <li class="list-group-item list-user bg-dark">
                    <div class="row d-flex">
                    <div class="col-2 d-flex align-items-center">
                        <img src="'.$user->profile_picture.'" class="img-fluid rounded-circle" alt="Profile Picture" style="width: 80px; height:80px;">
                    </div>
                    <div class="col-8 d-flex flex-column p-0 justify-content-center">
                        <p class="card-title text-white fw-bold">'.$user->nama_lengkap.'</p>
                        <p class="card-text text-white">'.$user->level.'</p>
                    </div>
                    <div
                     class="col-2 d-flex align-items-center justify-content-end">
                        <a href="/user/detailuser?email='.$user->email.'"><button class="btn btn-show-all text-white btn-sm btn-detail me-1"><i class="bx bxs-user-detail"></i></button></a>
                        <button class="btn btn-suc text-white btn-sm btn-edit me-1" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="'.$user->email.'"><i class="bx bx-edit"></i></button>
                        <button type="submit" onclick="setDelete('."'$user->email'".')" class="btn btn-dang text-white btn-sm"><i class="bx bx-trash"></i></button>
                    </div>
                </div></li>';
        }
    }else{
        $output .= '<li class="list-group-item list-user bg-dark"><div class="d-flex justify-content-center align-items-center text-white">Data User Tidak Ditemukan!</div></li>';
    }
        echo $output;
    }
}
