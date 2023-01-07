<?php

namespace App\Http\Controllers;

use App\Helpers\Custom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Pengeluaran extends Controller
{
    public function index(){
        $pengeluaran = Http::get(Custom::APIPENGELUARAN)->object();
        var_dump($pengeluaran);die;
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
            'user_id' => 38
        ];

        $tambah = Http::post(Custom::APIPENGELUARAN,$data)->object();
        return redirect('/pengeluaran')->with('message',$tambah->status);
    }

    public function hapus_data($id){
        $delete = Http::delete(Custom::APIPENGELUARAN.'/'.$id)->object();
        return redirect('/pengeluaran')->with('message',$delete->status);
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
            'user_id' => 38
        ];

        $edit = Http::put(Custom::APIPENGELUARAN, $data)->object();
        return redirect('/pengeluaran')->with('message',$edit->status);
    }
}
