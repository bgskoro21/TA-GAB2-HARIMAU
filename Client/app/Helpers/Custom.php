<?php 

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

Class Custom {
    const API = 'http://localhost/TA-GAB2-HARIMAU/Server';
    // const APISALDO = Custom::API.'/index.php/pemasukkan';
    const APIPENDAPATANBULANINI = Custom::API.'/index.php/pendapatan_bulan';
    const APIPENDAPATANTAHUNINI = Custom::API.'/index.php/pendapatan_tahun';
    const APIPENDAPATANHARIINI = Custom::API.'/index.php/pendapatan_hari';
    const APIPENGELUARANBULANINI = Custom::API.'/index.php/pengeluaran_bulan';
    const APIPENGELUARANTAHUNINI = Custom::API.'/index.php/pengeluaran_tahun';
    const APIPENGELUARANHARIINI = Custom::API.'/index.php/pengeluaran_hari';
    const APISALDO = Custom::API.'/index.php/saldo';
    const APISALDOBULAN = Custom::API.'/index.php/saldo_bulan';
    const APIPRESENTASESALDOHARIAN = Custom::API.'/index.php/presentase_saldo_harian';
    const APIPRESENTASESALDOTAHUN = Custom::API.'/index.php/presentase_saldo_tahun';
    const APIPRESENTASESALDOBULAN = Custom::API.'/index.php/presentase_saldo_bulan';
    const APIPRESENTASEPENDAPATANHARIAN = Custom::API.'/index.php/presentase_pendapatan_hari';
    const APIPRESENTASEPENDAPATANBULAN = Custom::API.'/index.php/presentase_pendapatan_bulan';
    const APIPRESENTASEPENDAPATANTAHUN = Custom::API.'/index.php/presentase_pendapatan_tahun';
    const APIPRESENTASEPENGELUARANBULAN = Custom::API.'/index.php/presentase_pengeluaran_bulan';
    const APIPRESENTASEPENGELUARANTAHUN = Custom::API.'/index.php/presentase_pengeluaran_tahun';
    const APIPRESENTASEPENGELUARANHARIAN = Custom::API.'/index.php/presentase_pengeluaran_hari';
    const APISALDOTAHUN = Custom::API.'/index.php/saldo_tahun';
    const APIKEUNTUNGAN = Custom::API.'/index.php/keuntungan';
    const APITRANSAKSI = Custom::API.'/index.php/transaksi';
    const APIBULAN = Custom::API.'/index.php/bulan';
    const APIUSER = Custom::API.'/index.php/user';
    const APIPEMASUKKAN = Custom::API.'/index.php/pendapatan';
    const APIPENGELUARAN = Custom::API.'/index.php/pengeluaran';
    const APIWAKTU = Custom::API.'/index.php/hari_transaksi';
    const APILOGIN = Custom::API.'/index.php/login';
    const APISEARCHTRANSAKSI = Custom::API.'/index.php/laporan';
    const APIEDITPROFILE = Custom::API.'/index.php/updateprofile';
    const APICEKPASSWORD = Custom::API.'/index.php/password';
    const APIVERIFIKASI =  Custom::API.'/index.php/verifikasi';
    const APIFORGOTPASSWORD =  Custom::API.'/index.php/forgotpassword';
    const APIRESETPASSWORD =  Custom::API.'/index.php/resetpassword';
    const APITOKEN = Custom::API.'/index.php/token';
    const APIFILTERUSER = Custom::API.'/index.php/searching_nama';
    const APIFILTERTRANSAKSI = Custom::API.'/index.php/searching_laporan';
    


    public static function format_indo($date){
        date_default_timezone_set('Asia/Jakarta');
        // array hari dan bulan
        $Hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
        $Bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        
        // pemisahan tahun, bulan, hari, dan waktu
        $tahun = substr($date,0,4);
        $bulan = substr($date,5,2);
        $tgl = substr($date,8,2);
        $waktu = substr($date,11,5);
        $hari = date("w",strtotime($date));
        $result = $Hari[$hari].", ".$tgl." ".$Bulan[(int)$bulan-1]." ".$tahun." ".$waktu;
    
        return $result;
      }
}





?>