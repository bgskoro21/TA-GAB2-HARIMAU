<?php

namespace App\Http\Controllers;

use App\Helpers\Custom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Pengeluaran extends Controller
{
    public function index(){
        $pengeluaran = Http::get(Custom::APIPENGELUARAN)->object();
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
            'user_id' => 14
        ];

        $tambah = Http::post(Custom::APIPENGELUARAN,$data)->object();
        if($tambah->status == true){
            return redirect('/pengeluaran')->with('message', $tambah->message);
        }else{
            return redirect('/pengeluaran')->with('error', $tambah->message);
        }
    }

    public function hapus_data($id){
        $delete = Http::delete(Custom::APIPENGELUARAN.'/'.$id)->object();
        if($delete->status == true){
            return redirect('/pengeluaran')->with('message', $delete->message);
        }else{
            return redirect('/pengeluaran')->with('error', $delete->message);
        }
    }

    public function getPengeluaranById($id){
        $pengeluaran = Http::get(Custom::APIPENGELUARAN, ['id' => $id])->object();
        echo json_encode($pengeluaran->pengeluaran[0]);
    }

    public function edit_data(Request $request){
        $data = [
            'waktu_transaksi' => $request->waktu_transaksi,
            'pengeluaran' =>$request->pengeluaran,
            'perincian' =>$request->perincian,
            'id' => $request->id,
            'user_id' => 14
        ];

        $edit = Http::put(Custom::APIPENGELUARAN, $data)->object();
        if($edit->status == true){
            return redirect('/pengeluaran')->with('message', $edit->message);
        }else{
            return redirect('/pengeluaran')->with('error', $edit->message);
        }
    }
}
