<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helpers\Custom;

class Dashboard extends Controller
{
    public function index(){
        // var_dump(session('token'));die;
        $pend_hari = Http::withToken(session('token'))->get(Custom::APIPENDAPATANHARIINI)->object();
        // var_dump($pend_hari->result);die;
        $saldo = Http::withToken(session('token'))->get(Custom::APISALDO)->object();
        // var_dump($saldo);die;
        $pengeluaran = Http::withToken(session('token'))->get(Custom::APIPENGELUARANHARIINI)->object();
        // var_dump($pengeluaran);die;
        $transaksi = Http::withToken(session('token'))->get(Custom::APITRANSAKSI)->object();
        // var_dump($transaksi);die;
        $keuntungan = Http::withToken(session('token'))->get(Custom::APIKEUNTUNGAN)->json();
        $bulan = Http::withToken(session('token'))->get(Custom::APIBULAN)->json();
        if(isset($pend_hari->result)){
            if($pend_hari->result == 0){
                session()->flush();
                return redirect('/login')->with('loginError','<div class="alert alert-danger text-center" role="alert">Token anda sudah habis, silahkan login kembali!
                </div>');
            }
        }
        return view('content.dashboard.index',[
            "pemasukkan_hari" => $pend_hari->total_pendapatan,
            "pengeluaran" => $pengeluaran->total_pengeluaran,
            "transaksi" => $transaksi->transaksi,
            "keuntungan" => $keuntungan['keuntungan'],
            "bulan" => $bulan['bulan'],
            "saldo" => $saldo->total_saldo,
            "title" => "Dashboard"
        ]);
    }

    public function getSaldo(Request $request){
        if($request->keyword == 'This Month'){
           $saldo = Http::withToken(session('token'))->get(Custom::APISALDOBULAN)->object();
        }else if($request->keyword == 'This Year'){
           $saldo = Http::withToken(session('token'))->get(Custom::APISALDOTAHUN)->object();
        }else{
            $saldo = Http::withToken(session('token'))->get(Custom::APISALDO)->object();
        }

        if(isset($saldo->result)){
            if($saldo->result == 0){
                session()->flush();
                return redirect('/login')->with('loginError','<div class="alert alert-danger text-center" role="alert">Token anda sudah habis, silahkan login kembali!
                </div>');
            }
        }

        $data = [
            'title' => $request->keyword,
            'saldo' => $saldo->total_saldo
        ];

        echo json_encode($data);
    }

    public function getPendapatan(Request $request){
        if($request->keyword == 'This Month'){
           $saldo = Http::withToken(session('token'))->get(Custom::APIPENDAPATANBULANINI)->object();
        }else if($request->keyword == 'This Year'){
           $saldo = Http::withToken(session('token'))->get(Custom::APIPENDAPATANTAHUNINI)->object();
        }else{
            $saldo = Http::withToken(session('token'))->get(Custom::APIPENDAPATANHARIINI)->object();
        }

        if(isset($saldo->result)){
                session()->flush();
                return redirect('/login')->with('loginError','<div class="alert alert-danger text-center" role="alert">Token anda sudah habis, silahkan login kembali!
                </div>');
        }

        $data = [
            'title' => $request->keyword,
            'pemasukkan' => $saldo->total_pendapatan
        ];

        echo json_encode($data);
    }

    public function getPengeluaran(Request $request){
        if($request->keyword == 'This Month'){
           $saldo = Http::withToken(session('token'))->get(Custom::APIPENGELUARANBULANINI)->object();
        }else if($request->keyword == 'This Year'){
           $saldo = Http::withToken(session('token'))->get(Custom::APIPENGELUARANTAHUNINI)->object();
        }else{
            $saldo = Http::withToken(session('token'))->get(Custom::APIPENGELUARANHARIINI)->object();
        }

        if(isset($saldo->result)){
            if($saldo->result == 0){
                session()->flush();
                return redirect('/login')->with('loginError','<div class="alert alert-danger text-center" role="alert">Token anda sudah habis, silahkan login kembali!
                </div>');
            }
        }

        $data = [
            'title' => $request->keyword,
            'pengeluaran' => $saldo->total_pengeluaran
        ];

        echo json_encode($data);
    }
}
