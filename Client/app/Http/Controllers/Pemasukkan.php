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
        $pemasukkan = Http::get(Custom::APIPEMASUKKAN)->object();
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
            'user_id' => 14
        ];

        $tambah = Http::post(Custom::APIPEMASUKKAN,$data)->object();
        // var_dump($tambah);die;
        if($tambah->status == true){
            return redirect('/pemasukkan')->with('message', $tambah->message);
        }else{
            return redirect('/pemasukkan')->with('error', $tambah->message);
        }
    }

    public function hapus_data($id){
        $delete = Http::delete(Custom::APIPEMASUKKAN.'/'.$id)->object();
        if($delete->status == true){
            return redirect('/pemasukkan')->with('message', $delete->message);
        }else{
            return redirect('/pemasukkan')->with('error', $delete->message);
        }
    }

    public function getPemasukkanById($id){
        $pemasukkan = Http::get(Custom::APIPEMASUKKAN, ['id' => $id])->object();
        echo json_encode($pemasukkan->pendapatan[0]);
    }

    public function edit_data(Request $request){
        $data = [
            'waktu_transaksi' => $request->waktu_transaksi,
            'pemasukkan' =>$request->pemasukkan,
            'perincian' =>$request->perincian,
            'id' => $request->id,
            'user_id' => 14
        ];
        
        $edit = Http::put(Custom::APIPEMASUKKAN, $data)->object();
        // var_dump($edit);die;
        if($edit->status == true){
            return redirect('/pemasukkan')->with('message', $edit->message);
        }else{
            return redirect('/pemasukkan')->with('error', $edit->message);
        }
    }
}
