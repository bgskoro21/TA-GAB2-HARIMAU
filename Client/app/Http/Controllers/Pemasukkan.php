<?php

namespace App\Http\Controllers;

use App\Helpers\Custom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class Pemasukkan extends Controller
{
    public function index(){
        $pemasukkan = Http::withToken(session('token'))->get(Custom::APIPEMASUKKAN)->object();
        if(isset($pemasukkan->result)){
            session()->flush();
            return redirect('/login')->with('loginError','<div class="alert alert-danger text-center" role="alert">Token anda sudah habis, silahkan login kembali!
            </div>');
        }
        // var_dump($pemasukkan);die;
        return view('content.pemasukkan.index',[
            'title' => 'Daftar Pemasukkan',
            'pemasukkan' => $pemasukkan,
        ]);
    }

    public function add_data(Request $request){
        $data = [
            'waktu_transaksi' => $request->waktu_transaksi,
            'pemasukkan' =>$request->pemasukkan,
            'perincian' =>$request->perincian,
            'user_id' => session('id')
        ];

        $tambah = Http::withToken(session('token'))->post(Custom::APIPEMASUKKAN,$data)->object();
        if(isset($tambah->result)){
            session()->flush();
            return redirect('/login')->with('loginError','<div class="alert alert-danger text-center" role="alert">Token anda sudah habis, silahkan login kembali!
            </div>');
        }
        // var_dump($tambah);die;
        if($tambah->status == true){
            return redirect('/pemasukkan')->with('message', $tambah->message);
        }else{
            return redirect('/pemasukkan')->with('error', $tambah->message);
        }
    }

    public function hapus_data($id){
        $delete = Http::withToken(session('token'))->delete(Custom::APIPEMASUKKAN.'/'.$id)->object();
        if(isset($delete->result)){
            session()->flush();
            return redirect('/login')->with('loginError','<div class="alert alert-danger text-center" role="alert">Token anda sudah habis, silahkan login kembali!
            </div>');
        }
        if($delete->status == true){
            return redirect('/pemasukkan')->with('message', $delete->message);
        }else{
            return redirect('/pemasukkan')->with('error', $delete->message);
        }
    }

    public function getPemasukkanById($id){
        $pemasukkan = Http::withToken(session('token'))->get(Custom::APIPEMASUKKAN, ['id' => $id])->object();
        if(isset($pemasukkan->result)){
            session()->flush();
            return redirect('/login')->with('loginError','<div class="alert alert-danger text-center" role="alert">Token anda sudah habis, silahkan login kembali!
            </div>');
        }
        echo json_encode($pemasukkan->pendapatan[0]);
    }

    public function edit_data(Request $request){
        $data = [
            'waktu_transaksi' => $request->waktu_transaksi,
            'pemasukkan' =>$request->pemasukkan,
            'perincian' =>$request->perincian,
            'id' => $request->id,
            'user_id' => session('id')
        ];
        
        $edit = Http::withToken(session('token'))->put(Custom::APIPEMASUKKAN, $data)->object();
        if(isset($edit->result)){
            session()->flush();
            return redirect('/login')->with('loginError','<div class="alert alert-danger text-center" role="alert">Token anda sudah habis, silahkan login kembali!
            </div>');
        }
        // var_dump($edit);die;
        if($edit->status == true){
            return redirect('/pemasukkan')->with('message', $edit->message);
        }else{
            return redirect('/pemasukkan')->with('error', $edit->message);
        }
    }
}
