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
                $output .= ' <div class="col-md-3">
                <div class="card mb-3">
                    <div class="row g-0">
                      <div class="col-md-4 d-flex align-items-center p-1">
                        <img src="'.$user->profile_picture.'" class="img-fluid rounded-circle" alt="Profile Picture">
                      </div>
                      <div class="col-md-6 d-flex align-items-center">
                        <div class="card-body">
                          <p class="card-title text-dark fw-bold">'.$user->nama_lengkap.'</p>
                          <p class="card-text text-dark">'.$user->level.'</p>
                        </div>
                      </div>
                      <div class="col-md-2 d-flex flex-column justify-content-center align-items-end">
                        <a href="/user/detailuser?email='.$user->email.'"><button class="btn btn-dark btn-sm btn-detail mb-1"><i class="bx bxs-user-detail"></i></button></a>
                        <button class="btn btn-success btn-sm btn-edit mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="'.$user->email.'"><i class="bx bx-edit"></i></button>
                        <button type="submit" onclick="setDelete('.$user->email.')" class="btn btn-danger btn-sm"><i class="bx bx-trash"></i></button>
                      </div>
                    </div>
                </div>
            </div>';
        }
    }else{
        $output .= '<p class="text-center text-white fs-4">User tidak ditemukan!</p>';
    }
        echo $output;
    }
}
