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
            return redirect('/expToken');
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
            $transaksi = Http::get(Custom::APISEARCHTRANSAKSI, [
                'tanggal' => $request->tanggal 
            ])->json();
            // var_dump($transaksi);die;
            $waktu = Custom::format_indo($request->tanggal);
        }else{
            $transaksi = Http::get(Custom::APISEARCHTRANSAKSI, [
                'bulan' => $request->bulan
            ])->json();
            // var_dump($transaksi);die;
            $waktu = $request->bulan;
        }

        if(isset($transaksi['result'])){
            return redirect('/expToken');
        }

        $pdf = Pdf::loadView('content.pdf.index', [
            'waktu' => $waktu,
            'transaksi' => $transaksi['laporan']
        ])->setPaper('a4','landscape');
        return $pdf->stream();
    }

    public function qrcode(Request $request){
        if(isset($request->tanggal)){
            $keyword = $request->tanggal;
            $url = 'http://127.0.0.1:8000/laporan/pdf?tanggal=';
        }else{
            $url = 'http://127.0.0.1:8000/laporan/pdf?bulan=';
            $keyword = $request->bulan;
        }
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
        ->generate("$url".$keyword);
        Storage::disk('public')->put($output_file, $image);

        return view('content.qrcode.index',[
            'title' => 'QR-Code',
            'waktu' => $waktu,
            'laporan' => $laporan
        ]);
    }

    public function laporan_umum(Request $request){
        if($request->tanggal_awal || $request->tanggal_akhir){
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
            $transaksi = Http::withToken(session('token'))->get(Custom::APIFILTERTRANSAKSI, ['tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir])->object();
            if($tanggal_awal != $tanggal_akhir){
                $waktu = Custom::format_indo($tanggal_awal).' s/d '.Custom::format_indo($tanggal_akhir);
            }else{
                $waktu = Custom::format_indo($tanggal_awal);
            }
        }else{
            $tanggal_awal = date('Y-m-d');
            $tanggal_akhir = date('Y-m-d');
            $transaksi = Http::withToken(session('token'))->get(Custom::APIFILTERTRANSAKSI, ['tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir])->object();
            $waktu = Custom::format_indo($tanggal_awal);
        }

        if(isset($transaksi->result)){
            return redirect('/expToken');
        }

        return view('content.laporan.umum',[
            'title' => 'Kas Umum',
            'transaksi' => $transaksi,
            'waktu' => $waktu,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir
        ]);
    }

    public function pdf_umum(Request $request){
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        // var_dump($tanggal_akhir);die;
        
        if($tanggal_awal != $tanggal_akhir){
            $waktu = Custom::format_indo($tanggal_awal).' s/d '.Custom::format_indo($tanggal_akhir);
        }else{
            $waktu = Custom::format_indo($tanggal_awal);
        }

        $transaksi = Http::withToken(session('token'))->get(Custom::APIFILTERTRANSAKSI, ['tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir])->object();
        // var_dump($transaksi);die;

        if(isset($transaksi->result)){
            return redirect('/expToken');
        }

        $pdf = Pdf::loadView('content.pdf.umum', [
            'waktu' => $waktu,
            'transaksi' => $transaksi,
            'title' => 'Kas Umum'
        ])->setPaper('a4','landscape');
        return $pdf->stream();
    }

    public function qrcode_umum(Request $request){
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        if($tanggal_awal != $tanggal_akhir){
            $waktu = Custom::format_indo($tanggal_awal).' - '.Custom::format_indo($tanggal_akhir);
        }else{
            $waktu = Custom::format_indo($tanggal_awal);
        }

        $laporan = 'umum';
        $output_file = '/qr-code/umum/img-' . $waktu . '.png';

        $image = QrCode::format('png')
        ->size(300)->errorCorrection('H')
        ->generate("http://127.0.0.1:8000/laporan/umum/pdf?tanggal_awal=".$tanggal_awal."&tanggal_akhir=".$tanggal_akhir);
        Storage::disk('public')->put($output_file, $image);

        return view('content.qrcode.index',[
            'title' => 'QR-Code',
            'waktu' => $waktu,
            'laporan' => $laporan
        ]);
    }
}
