<?php

namespace App\Http\Controllers;

use App\Helpers\Custom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Laporan extends Controller
{
    public function index(Request $request){
        $waktu = Http::withToken(session('token'))->get(Custom::APIWAKTU)->object();
        // var_dump($waktu);die;
        $bulan = Http::withToken(session('token'))->get(Custom::APIBULAN)->object();
        if(isset($waktu->result) || isset($bulan->result)){
            session()->flush();
            return redirect('/login')->with('loginError','<div class="alert alert-danger text-center" role="alert">Token anda sudah habis, silahkan login kembali!
            </div>');
        }
        if($request->waktu == 'harian'){
            return view('content.laporan.index',[
                'title' => 'Laporan Harian',
                'waktu' => $waktu->hari
            ]);
        }else if($request->waktu == 'bulanan'){
            return view('content.laporan.index',[
                'title' => 'Laporan Bulanan',
                'waktu' => $bulan->bulan
            ]);
        }
    }

    public function pdf(Request $request){
        if(!empty($request->tanggal)){
            $transaksi = Http::withToken(session('token'))->get(Custom::APISEARCHTRANSAKSI, [
                'tanggal' => $request->tanggal 
            ])->json();
            // var_dump($transaksi);die;
            $waktu = Custom::format_indo($request->tanggal);
        }else{
            $transaksi = Http::withToken(session('token'))->get(Custom::APISEARCHTRANSAKSI, [
                'bulan' => $request->bulan
            ])->json();
            // var_dump($transaksi);die;
            $waktu = $request->bulan;
        }

        if(isset($transaksi['result'])){
            session()->flush();
            return redirect('/login')->with('loginError','<div class="alert alert-danger text-center" role="alert">Token anda sudah habis, silahkan login kembali!
            </div>');
        }

        $pdf = Pdf::loadView('content.pdf.index', [
            'waktu' => $waktu,
            'transaksi' => $transaksi['laporan']
        ])->setPaper('a4','landscape');
        return $pdf->stream();
    }

    public function qrcode(Request $request){
        if(!empty($request->tanggal)){
            $waktu = Custom::format_indo($request->tanggal);
            $laporan = 'harian';
            $output_file = '/qr-code/harian/img-' . $waktu . '.png';
        }else{
            $waktu = $request->bulan;
            $laporan = 'bulanan';
            $output_file = '/qr-code/bulanan/img-' . $waktu . '.png';
        }

        $image = QrCode::format('png')
        ->size(300)->errorCorrection('H')
        ->generate("Laporan : $waktu");
        Storage::disk('public')->put($output_file, $image);

        return view('content.qrcode.index',[
            'title' => 'QR-Code',
            'waktu' => $waktu,
            'laporan' => $laporan
        ]);
    }
}
