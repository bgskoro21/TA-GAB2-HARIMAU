<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helpers\Custom;

class Dashboard extends Controller
{
    public function index(){
        // var_dump(session('username'));
        $pend_bulan = Http::get(Custom::APIPENDAPATANBULANINI)->object()->pendapatan_bulan;
        // $saldo = Http::get(Custom::APISALDO);
        $pengeluaran = Http::get(Custom::APIPENGELUARANBULANINI)->object()->pengeluaran_bulan;
        // $transaksi = Http::get(Custom::APITRANSAKSI);
        $keuntungan = Http::get(Custom::APIKEUNTUNGAN)->json()['keuntungan'];
        // var_dump($keuntungan);die;
        $bulan = Http::get(Custom::APIBULAN)->json()['bulan'];
        return view('content.dashboard.index',[
            "pemasukkan_bulan" => $pend_bulan,
            "pengeluaran_bulan" => $pengeluaran,
            // "transaksi" => $transaksi->object(),
            "keuntungan" => $keuntungan,
            "bulan" => $bulan,
            // "saldo" => $saldo->object(),
            "title" => "Dashboard"
        ]);
    }
}
