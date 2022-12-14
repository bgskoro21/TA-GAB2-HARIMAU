<?php

namespace App\Http\Controllers;

use App\Helpers\Custom;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Profile extends Controller
{

    public function index(){
        $user = Http::get(Custom::APIUSER,['current' => session('email')])->object();
        return view('content.profiles.index',[
            'title' => 'User Profile',
            'current_user' => $user->user
        ]);
    }

    public function edit_profile(Request $request){
        $profile_picture = $request->file('profile_picture');
        if($request->hasFile('profile_picture')){
            $update = Http::attach('photo', file_get_contents($profile_picture),session('nama_lengkap').'-picture.jpg')->post(Custom::APIEDITPROFILE,[
                    'nama_lengkap' => $request->nama_lengkap,
                    'no_hp' => $request->no_hp,
                    'token' => $request->token,
                     ])->object();
        }else{
            // var_dump($profile_picture);die;
            $update = Http::post(Custom::APIEDITPROFILE,[
                'nama_lengkap' => $request->nama_lengkap,
                'no_hp' => $request->no_hp,
                'token' => $request->token,
            ])->object();
        }
        // var_dump($update);die;
        if($update->status == true){
            $user = Http::get(Custom::APIUSER,['current' => session('email')])->object();
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
        $cekPassword = Http::post(Custom::APICEKPASSWORD,[
            'password' => $request->password,
            'email' => session('email')
        ])->object();
        // var_dump($cekPassword);die;
        if($cekPassword->status == true){
            $data = [
                'password' => $request->newpassword,
                'email' => session('email')
            ];

            $password = Http::put(Custom::APICEKPASSWORD,$data)->object();
            if($password->status == true){
                return redirect('/profile')->with('message',$password->message);
            }else{
                return redirect('/profile')->with('message',$password->message);
            }
        }else{
            return redirect('/profile')->with('error','Password lama tidak cocok');
        }
    }

}
