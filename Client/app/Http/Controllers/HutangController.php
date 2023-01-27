<?php

namespace App\Http\Controllers;

use App\Helpers\Custom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HutangController extends Controller
{
    public function index(){
        $hutang = Http::withToken(session('token'))->get(Custom::APIHUTANG)->object();
        // var_dump($hutang);die;
        return view('content.hutang.index',[
            'title' => 'Hutang Piutang',
            'hutang' => $hutang
        ]);
    }

    public function store(Request $request){
        $data = [
            "nama_pelanggan" => $request->nama_pelanggan,
            "kode_hutang" => $request->kode_hutang,
            "tgl_transaksi" => $request->tgl_transaksi,
            "tgl_tempo" => $request->tgl_tempo,
            "hutang" => $request->total_hutang,
            "perincian" => $request->perincian,
            "no_hp" => $request->no_hp,
            'user_id' => session('id')
        ];


        $tambah = Http::withToken(session('token'))->post(Custom::APIHUTANG, $data)->object();
        if($tambah->status == true){
            return redirect('/hutang')->with('message', $tambah->message);
        }else{
            return redirect('/hutang')->with('error', $tambah->message);

        }
    }

    public function hapus_data($id){
        $hapus = Http::withToken(session('token'))->asForm()->delete(Custom::APIHUTANG, ['id' => $id])->object();
        if($hapus->status == true){
            return redirect('/hutang')->with('message', $hapus->message);
        }else{
            return redirect('/hutang')->with('error', $hapus->message);
        }
    }

    public function getHutangById($id){
        $hutang = Http::withToken(session('token'))->get(Custom::APIHUTANG, ['id' => $id])->object();
        echo json_encode($hutang->hutang);
    }

    public function update(Request $request){
        $data = [
            "nama_pelanggan" => $request->nama_pelanggan,
            "kode_hutang" => $request->kode_hutang,
            "tgl_transaksi" => $request->tgl_transaksi,
            "tgl_tempo" => $request->tgl_tempo,
            "hutang" => $request->total_hutang,
            'user_id' => session('id'),
            "perincian" => $request->perincian,
            "no_hp" => $request->no_hp,
            'token' => $request->id
        ];

        $edit = Http::withToken(session('token'))->put(Custom::APIHUTANG, $data)->object();
        if($edit->status == true){
            return redirect('/hutang')->with('message', $edit->message);
        }else{
            return redirect('/hutang')->with('error', $edit->message);

        }
    }

    public function setLunas($kode){
        // var_dump($kode);
        $update = Http::withToken(session('token'))->put(Custom::APILUNAS, ['token' => $kode, 'status' => 'Lunas'])->object();

        if($update->status == true){
            return redirect('/hutang')->with('message', $update->message);
        }else{
            return redirect('/hutang')->with('error',$update->message);
        }
    }
}
