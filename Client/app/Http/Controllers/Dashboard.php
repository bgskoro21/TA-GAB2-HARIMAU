<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helpers\Custom;

class Dashboard extends Controller
{
    public function index(){
        // var_dump(session('username'));
        $pend_hari = Http::get(Custom::APIPENDAPATANHARIINI)->object()->total_pendapatan;
        // var_dump($pend_hari);die;
        $saldo = Http::get(Custom::APISALDO)->object()->total_saldo;
        $pengeluaran = Http::get(Custom::APIPENGELUARANBULANINI)->object()->pengeluaran_bulan;
        $transaksi = Http::get(Custom::APITRANSAKSI)->object()->transaksi;
        // var_dump($transaksi);die;
        $keuntungan = Http::get(Custom::APIKEUNTUNGAN)->json()['keuntungan'];
        $bulan = Http::get(Custom::APIBULAN)->json()['bulan'];
        return view('content.dashboard.index',[
            "pemasukkan_hari" => $pend_hari,
            "pengeluaran_bulan" => $pengeluaran,
            "transaksi" => $transaksi,
            "keuntungan" => $keuntungan,
            "bulan" => $bulan,
            "saldo" => $saldo,
            "title" => "Dashboard"
        ]);
    }

    public function getSaldo(Request $request){
        if($request->keyword == 'This Month'){
           $saldo = Http::get(Custom::APISALDOBULAN)->object()->total_saldo;
        }else if($request->keyword == 'This Year'){
           $saldo = Http::get(Custom::APISALDOTAHUN)->object()->total_saldo;
        }else{
            $saldo = Http::get(Custom::APISALDO)->object()->total_saldo;
        }

        $data = [
            'title' => $request->keyword,
            'saldo' => $saldo
        ];

        echo json_encode($data);
    }

    public function getPendapatan(Request $request){
        if($request->keyword == 'This Month'){
           $saldo = Http::get(Custom::APIPENDAPATANBULANINI)->object()->total_pendapatan;
        }else if($request->keyword == 'This Year'){
           $saldo = Http::get(Custom::APIPENDAPATANTAHUNINI)->object()->total_pendapatan;
        }else{
            $saldo = Http::get(Custom::APIPENDAPATANHARIINI)->object()->total_pendapatan;
        }

        $data = [
            'title' => $request->keyword,
            'pemasukkan' => $saldo
        ];

        echo json_encode($data);
    }
}
