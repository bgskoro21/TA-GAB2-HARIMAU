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
        $waktu = Http::get(Custom::APIWAKTU)->object()->hari;
        // var_dump($waktu);die;
        $bulan = Http::get(Custom::APIBULAN)->object()->bulan;
        if($request->waktu == 'harian'){
            return view('content.laporan.index',[
                'title' => 'Laporan Harian',
                'waktu' => $waktu
            ]);
        }else if($request->waktu == 'bulanan'){
            return view('content.laporan.index',[
                'title' => 'Laporan Bulanan',
                'waktu' => $bulan
            ]);
        }
    }

    public function pdf(Request $request){
        if(!empty($request->tanggal)){
            $transaksi = Http::get(Custom::APISEARCHTRANSAKSI, [
                'tanggal' => $request->tanggal
            ])->json()['laporan'];
            // var_dump($transaksi);die;
            $waktu = $request->tanggal;
        }else{
            $transaksi = Http::get(Custom::APISEARCHTRANSAKSI, [
                'bulan' => $request->bulan
            ])->json();
            var_dump($transaksi);die;
            $waktu = $request->bulan;
        }

        $pdf = Pdf::loadView('content.pdf.index', [
            'waktu' => $waktu,
            'transaksi' => $transaksi
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
        ->generate($waktu);
        Storage::disk('public')->put($output_file, $image);

        return view('content.qrcode.index',[
            'title' => 'QR-Code',
            'waktu' => $waktu,
            'laporan' => $laporan
        ]);
    }
}
