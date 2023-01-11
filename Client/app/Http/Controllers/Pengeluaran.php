<?php

namespace App\Http\Controllers;

use App\Helpers\Custom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Pengeluaran extends Controller
{
    public function index(){
        $pengeluaran = Http::withToken(session('token'))->get(Custom::APIPENGELUARAN)->object();
        if(isset($pengeluaran->result)){
            session()->flush();
            return redirect('/login')->with('loginError','<div class="alert alert-danger text-center" role="alert">Token anda sudah habis, silahkan login kembali!
            </div>');
        }
        // var_dump($pengeluaran);die;
        return view('content.pengeluaran.index',[
            'title' => 'Daftar Pengeluaran',
            'pengeluaran' => $pengeluaran
        ]);
    }

    public function add_data(Request $request){
        $data = [
            'waktu_transaksi' => $request->waktu_transaksi,
            'pengeluaran' =>$request->pengeluaran,
            'perincian' =>$request->perincian,
            'user_id' => session('id')
        ];

        $tambah = Http::withToken(session('token'))->post(Custom::APIPENGELUARAN,$data)->object();

        if(isset($tambah->result)){
            session()->flush();
            return redirect('/login')->with('loginError','<div class="alert alert-danger text-center" role="alert">Token anda sudah habis, silahkan login kembali!
            </div>');
        }

        if($tambah->status == true){
            return redirect('/pengeluaran')->with('message', $tambah->message);
        }else{
            return redirect('/pengeluaran')->with('error', $tambah->message);
        }
    }

    public function hapus_data($id){
        $delete = Http::withToken(session('token'))->delete(Custom::APIPENGELUARAN.'/'.$id)->object();

        if(isset($delete->result)){
            session()->flush();
            return redirect('/login')->with('loginError','<div class="alert alert-danger text-center" role="alert">Token anda sudah habis, silahkan login kembali!
            </div>');
        }

        if($delete->status == true){
            return redirect('/pengeluaran')->with('message', $delete->message);
        }else{
            return redirect('/pengeluaran')->with('error', $delete->message);
        }
    }

    public function getPengeluaranById($id){
        $pengeluaran = Http::withToken(session('token'))->get(Custom::APIPENGELUARAN, ['id' => $id])->object();
        if(isset($pengeluaran->result)){
            session()->flush();
            return redirect('/login')->with('loginError','<div class="alert alert-danger text-center" role="alert">Token anda sudah habis, silahkan login kembali!
            </div>');
        }
        echo json_encode($pengeluaran->pengeluaran[0]);
    }

    public function edit_data(Request $request){
        $data = [
            'waktu_transaksi' => $request->waktu_transaksi,
            'pengeluaran' =>$request->pengeluaran,
            'perincian' =>$request->perincian,
            'id' => $request->id,
            'user_id' => session('id')
        ];

        $edit = Http::withToken(session('token'))->put(Custom::APIPENGELUARAN, $data)->object();
        if(isset($edit->result)){
            session()->flush();
            return redirect('/login')->with('loginError','<div class="alert alert-danger text-center" role="alert">Token anda sudah habis, silahkan login kembali!
            </div>');
        }
        if($edit->status == true){
            return redirect('/pengeluaran')->with('message', $edit->message);
        }else{
            return redirect('/pengeluaran')->with('error', $edit->message);
        }
    }
}
