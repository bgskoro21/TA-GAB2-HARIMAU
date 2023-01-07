<?php 

namespace App\Helpers;

Class Custom {
    const API = 'http://localhost/TA-GAB2-HARIMAU/Server';
    // const APISALDO = Custom::API.'/index.php/pemasukkan';
    const APIPENDAPATANBULANINI = Custom::API.'/index.php/pendapatan_bulan';
    const APIPENGELUARANBULANINI = Custom::API.'/index.php/pengeluaran_bulan';
    const APISALDO = Custom::API.'/index.php/saldo';
    const APIKEUNTUNGAN = Custom::API.'/index.php/keuntungan';
    const APITRANSAKSI = Custom::API.'/index.php/transaksi';
    const APIBULAN = Custom::API.'/index.php/bulan';
    const APIUSER = Custom::API.'/index.php/user';
    const APIPEMASUKKAN = Custom::API.'/index.php/pendapatan';
    const APIPENGELUARAN = Custom::API.'/index.php/pengeluaran';
    const APIWAKTU = Custom::API.'/index.php/hari_transaksi';
    const APILOGIN = Custom::API.'/index.php/login';
    const APISEARCHTRANSAKSI = Custom::API.'/index.php/laporan';
    const APIEDITPROFILE = Custom::API.'/index.php/uploadfoto';
    const APICEKPASSWORD = Custom::API.'/index.php/password';
    


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