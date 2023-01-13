<?php

namespace App\Http\Controllers;

use App\Helpers\Custom;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Profile extends Controller
{

    public function index(){
        $user = Http::withToken(session('token'))->get(Custom::APIUSER,['current' => session('email')])->object();
        if(isset($user->result)){
            return redirect('/expToken');
        }
        return view('content.profiles.index',[
            'title' => 'User Profile',
            'current_user' => $user->user
        ]);
    }

    public function edit_profile(Request $request){
        $profile_picture = $request->file('profile_picture');
        if($request->hasFile('profile_picture')){
            $update = Http::withToken(session('token'))->attach('photo', file_get_contents($profile_picture),session('nama_lengkap').'-picture.jpg')->post(Custom::APIEDITPROFILE,[
                    'nama_lengkap' => $request->nama_lengkap,
                    'no_hp' => $request->no_hp,
                    'about' => $request->about,
                    'token' => $request->token,
                     ])->object();
        }else{
            // var_dump($profile_picture);die;
            $update = Http::withToken(session('token'))->post(Custom::APIEDITPROFILE,[
                'nama_lengkap' => $request->nama_lengkap,
                'no_hp' => $request->no_hp,
                'about' => $request->about,
                'token' => $request->token,
            ])->object();
        }
        if(isset($update->result)){
            return redirect('/expToken');
        }
        // var_dump($update);die;
        if($update->status == true){
            $user = Http::withToken(session('token'))->get(Custom::APIUSER,['current' => session('email')])->object();
            if(isset($user->result)){
                return redirect('/expToken');
            }
            session()->put([
                'nama_lengkap' => $user->user->nama_lengkap,
                'email' => $user->user->email,
                'profile_picture' => $user->user->profile_picture,
                'level' => $user->user->level,
            ]);
        }
        return redirect('/profile')->with('message',$update->message);
    }

    public function change_password(Request $request){
        $cekPassword = Http::withToken(session('token'))->post(Custom::APICEKPASSWORD,[
            'password' => $request->password,
            'email' => session('email')
        ])->object();
        if(isset($cekPassword->result)){
            return redirect('/expToken');
        }
        // var_dump($cekPassword);die;
        if($cekPassword->status == true){
            $data = [
                'password' => $request->newpassword,
                'email' => session('email')
            ];

            $password = Http::withToken(session('token'))->put(Custom::APICEKPASSWORD,$data)->object();

            // jika token habis atau tidak sesuai
            if(isset($password->result)){
                return redirect('/expToken');
            }

            if($password->status == true){
                return redirect('/profile')->with('message',$password->message);
            }else{
                return redirect('/profile')->with('message',$password->message);
            }
        }else{
            return redirect('/profile')->with('error','Password lama tidak cocok');
        }
    }

    public function deletePhoto(){
        $email = session('email');
        // var_dump($email);die;
        $hapus = Http::withToken(session('token'))->asForm()->delete(Custom::APIEDITPROFILE, ['token' => $email])->object();

        if(isset($hapus->result)){
            return redirect('/expToken');
        }

        if($hapus->status == true){
            session()->put([
                'profile_picture' => null
            ]);
            return redirect('/profile')->with('message',$hapus->message);
        }else{
            return redirect('/profile')->with('error',$hapus->message);
        }
    }

}
