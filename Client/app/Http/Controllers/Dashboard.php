<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helpers\Custom;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;


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
        $presentase_saldo = Http::withToken(session('token'))->get(Custom::APIPRESENTASESALDOHARIAN)->object();
        $presentase_pendapatan = Http::withToken(session('token'))->get(Custom::APIPRESENTASEPENDAPATANHARIAN)->object();
        $presentase_pengeluaran = Http::withToken(session('token'))->get(Custom::APIPRESENTASEPENGELUARANHARIAN)->object();
        $keuntungan = Http::withToken(session('token'))->get(Custom::APIKEUNTUNGAN)->json();
        $bulan = Http::withToken(session('token'))->get(Custom::APIBULAN)->json();
        $pendapatan = Http::withToken(session('token'))->get(Custom::APIPEMASUKKAN)->object();
        $pengeluaran_h = Http::withToken(session('token'))->get(Custom::APIPENGELUARAN)->object();
        $waktu='';

        if(isset($pend_hari->result)){
            return redirect('/expToken');
        }

        if(!empty($transaksi->transaksi)){
            for($i=0; $i<count($transaksi->transaksi); $i++){
                if($transaksi->transaksi[$i]->waktu_transaksi == date('Y-m-d')){
                    $waktu = date('Y-m-d');
                    break;
                }
                $waktu = null;
            }

            if($waktu != null){
                $output_file = '/qr-code/harian/img-' . $waktu . '.png';
                $image = QrCode::format('png')
                ->size(300)->errorCorrection('H')
                ->generate("http://127.0.0.1:8000/laporan/pdf?tanggal=".$waktu);
                Storage::disk('public')->put($output_file, $image);
            }
        }
        
        


        return view('content.dashboard.index',[
            "pemasukkan_hari" => $pend_hari->total_pendapatan,
            "pengeluaran" => $pengeluaran->total_pengeluaran,
            "transaksi" => $transaksi->transaksi,
            "keuntungan" => $keuntungan['keuntungan'],
            "bulan" => $bulan['bulan'],
            "saldo" => $saldo->total_saldo,
            'presentase_saldo' => $presentase_saldo,
            'presentase_pendapatan' => $presentase_pendapatan,
            'presentase_pengeluaran' => $presentase_pengeluaran,
            'pemasukkan' => $pendapatan,
            'pengeluaran_h' => $pengeluaran_h,
            'waktu' => $waktu,
            "title" => "Dashboard"
        ]);
    }

    public function getSaldo(Request $request){
        if($request->keyword == 'This Month'){
           $saldo = Http::withToken(session('token'))->get(Custom::APISALDOBULAN)->object();
           $presentase = Http::withToken(session('token'))->get(Custom::APIPRESENTASESALDOBULAN)->object();
        }else if($request->keyword == 'This Year'){
            $saldo = Http::withToken(session('token'))->get(Custom::APISALDOTAHUN)->object();
            $presentase = Http::withToken(session('token'))->get(Custom::APIPRESENTASESALDOTAHUN)->object();
        }else{
            $saldo = Http::withToken(session('token'))->get(Custom::APISALDO)->object();
            $presentase = Http::withToken(session('token'))->get(Custom::APIPRESENTASESALDOHARIAN)->object();
        }

        if(isset($saldo->result)){
            $data = [
                'title' => $request->keyword,
                'saldo' => $saldo
            ];
        }
        else{
            $data = [
                'title' => $request->keyword,
                'saldo' => $saldo->total_saldo,
                'presentase' => $presentase
            ];
        }


        echo json_encode($data);
    }

    public function getPendapatan(Request $request){
        if($request->keyword == 'This Month'){
           $saldo = Http::withToken(session('token'))->get(Custom::APIPENDAPATANBULANINI)->object();
           $presentase = Http::withToken(session('token'))->get(Custom::APIPRESENTASEPENDAPATANBULAN)->object();
        }else if($request->keyword == 'This Year'){
            $saldo = Http::withToken(session('token'))->get(Custom::APIPENDAPATANTAHUNINI)->object();
            $presentase = Http::withToken(session('token'))->get(Custom::APIPRESENTASEPENDAPATANTAHUN)->object();
        }else{
            $saldo = Http::withToken(session('token'))->get(Custom::APIPENDAPATANHARIINI)->object();
            $presentase = Http::withToken(session('token'))->get(Custom::APIPRESENTASEPENDAPATANHARIAN)->object();
        }

        if(isset($saldo->result)){
            $data = [
                'title' => $request->keyword,
                'pemasukkan' => $saldo
            ];
        }else {
            $data = [
                'title' => $request->keyword,
                'pemasukkan' => $saldo->total_pendapatan,
                'presentase' => $presentase
            ];
        }


        echo json_encode($data);
    }

    public function getPengeluaran(Request $request){
        if($request->keyword == 'This Month'){
           $saldo = Http::withToken(session('token'))->get(Custom::APIPENGELUARANBULANINI)->object();
           $presentase = Http::withToken(session('token'))->get(Custom::APIPRESENTASEPENGELUARANBULAN)->object();
        }else if($request->keyword == 'This Year'){
           $saldo = Http::withToken(session('token'))->get(Custom::APIPENGELUARANTAHUNINI)->object();
           $presentase = Http::withToken(session('token'))->get(Custom::APIPRESENTASEPENGELUARANBULAN)->object();
        }else{
            $saldo = Http::withToken(session('token'))->get(Custom::APIPENGELUARANHARIINI)->object();
            $presentase = Http::withToken(session('token'))->get(Custom::APIPRESENTASEPENGELUARANHARIAN)->object();
        }

        if(isset($saldo->result)){
            $data = [
                'title' => $request->keyword,
                'pengeluaran' => $saldo
            ];
        }else{
            $data = [
                'title' => $request->keyword,
                'pengeluaran' => $saldo->total_pengeluaran,
                'presentase' => $presentase
            ];
        }


        echo json_encode($data);
    }
}
