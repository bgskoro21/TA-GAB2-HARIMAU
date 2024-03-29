<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class M_Transaksi extends CI_Model {

	// buat method untuk tampil data
    public function get_data($id=null){
        $this->db->select('tbl_transaksi.*,user.email,user.profile_picture');
        $this->db->from('tbl_transaksi');
        $this->db->join('user','tbl_transaksi.user_id = user.id');
        if($id != null){
            $this->db->where('tbl_transaksi.id',$id);
            $this->db->where('pemasukan > 0');
        }else{
            $this->db->where('pemasukan > 0');
        }
        $query = $this->db->get()->result();

         return $query;
    }

    // menampilkan bulan
    public function getBulans(){
        $this->db->select('monthname(waktu_transaksi) as bulan');
        $this->db->from('tbl_transaksi');
        $this->db->where('year(waktu_transaksi)',date('Y'));
        $this->db->order_by('month(waktu_transaksi)','ASC');
        $this->db->group_by('monthname(waktu_transaksi)');
       $query = $this->db->get()->result();
       return $query;
    }

    // menampilkan semua Transaksi
    public function getAllTransaksi()
    {
        $this->db->select('tbl_transaksi.*,user.email');
        $this->db->from('tbl_transaksi');
        $this->db->join('user','tbl_transaksi.user_id = user.id');
        $query = $this->db->get()->result();
        if (count($query) > 0){
            $hasil = $query;
        }else{
            $hasil = null;
        }

        return $hasil;
    }

    // Menampilkan Jumlah Sebagai Keuntungan
    public function getKeuntungan(){
        $this->db->select('SUM(pemasukan) - SUM(pengeluaran) AS Keuntungan');
        $this->db->from('tbl_transaksi');
        $this->db->where('year(waktu_transaksi)',date('Y'));
        $this->db->group_by('month(waktu_transaksi)');
       $query = $this->db->get()->result();
       return $query;
    }

    // menampilkan jumlah pemasukan dalam bulan
    public function getBulan(){
        $this->db->select('SUM(pemasukan) AS pemasukan');
        $this->db->from('tbl_transaksi');
        $this->db->where('month(waktu_transaksi)', date('m'));
        $query = $this->db->get()->row_array();
        return $query;
    }
    // Untuk Mencari Hari
    public function getHari(){
        $this->db->select('waktu_transaksi');
        $this->db->from('tbl_transaksi');
        $this->db->group_by('waktu_transaksi');
        $query = $this->db->get()->result();
        return $query;
    }
    // Untuk Menghapus Controller Pendapatan
    public function delete_data($id){
        $this->db->select('id');
        $this->db->from('tbl_transaksi');
        $this->db->where("id = '$id'");
        $query = $this->db->get()->result();

        if(count($query)==1){
            $this->db->where("id = '$id'");
            $this->db->delete('tbl_transaksi');
            $hasil = 1;
        }else{
            $hasil = 0;
        }
        return $hasil;
    }

    // menghapus multiple data
    public function delete_selected_data($data = []){
        $this->db->select('id');
        $this->db->from('tbl_transaksi');
        $this->db->where('id',$data[0]);
        $query = $this->db->get()->row_array();
        if($query){
            for($i = 0; $i < count($data) ; $i++){
                $this->db->where('id',$data[$i]);
                $this->db->delete('tbl_transaksi');
            }
            $hasil = 1;
        }else{
            $hasil = 0;
        }

        return $hasil;

    }
    // Untuk Menambahkan Controller Pendapatan
    public function add_data($user_id, $waktu, $perincian, $pemasukkan){

        $data=[
            "user_id" => $user_id,
            "waktu_transaksi" => $waktu,
            "perincian" => $perincian,
            "pemasukan" => $pemasukkan,
        ];

        $this->db->insert('tbl_transaksi',$data);
         
        if($this->db->affected_rows() == 1){
            $hasil = 1;
        }else if($this->db->affected_rows() == 0){
            $hasil = 0;
        }

        return $hasil;
    }
    // Untuk Mengedit Controller Pendapatan
    function update_data($user_id, $waktu_transaksi, $perincian, $pemasukkan,$id){
        $this->db->from('tbl_transaksi');
        $this->db->where("id = $id");
        $query = $this->db->get()->result_array();
        if(count($query) == 1){
            $data = [
                "user_id" => $user_id,
                "waktu_transaksi" => $waktu_transaksi,
                "perincian" => $perincian,
                "pemasukan" => $pemasukkan,
            ];
            $this->db->where("id = $id");
            $this->db->update('tbl_transaksi',$data);
            
            $hasil=1;
        } else {
            $hasil=0;
        }
        return $hasil;
}

// Untuk Menampilkan Seluruh Saldo
public function getSaldo(){
    $this->db->select('SUM(pemasukan) - SUM(pengeluaran) AS saldo');
    $this->db->from('tbl_transaksi');
    $this->db->where('waktu_transaksi',date('Y-m-d'));
    $query = $this->db->get()->row_array();
    if($query){
        $hasil = $query;
    }else {
        $hasil = null;
    }
    return $hasil;
}   
// digunakan untuk perbandingan saldo sebelumnya
public function getSaldoKemarin(){
    $this->db->select('waktu_transaksi');
    $this->db->from('tbl_transaksi');
    $this->db->where('waktu_transaksi',date('Y-m-d', strtotime('yesterday')));
    $query = $this->db->get()->row_array();
    if($query){
        $this->db->select('SUM(pemasukan) - SUM(pengeluaran) as saldo');
        $this->db->from('tbl_transaksi');
        $this->db->where('waktu_transaksi',$query['waktu_transaksi']);
        $kemarin = $this->db->get()->row_array();
        $hasil = $kemarin;
    }else {
        $hasil = null;
    }
    return $hasil;
} 

// digunakan untuk membandingkan saldo bulan kemarin
public function getSaldoBKemarin(){
    $this->db->select('waktu_transaksi');
    $this->db->from('tbl_transaksi');
    if(date('m') == '01'){
        $this->db->where('month(waktu_transaksi)', '12');
        $this->db->where('year(waktu_transaksi)', date('Y', strtotime('last year')));
    }else{
        $this->db->where('month(waktu_transaksi)', date('Y-m', strtotime('last month')));
    }
    $query = $this->db->get()->row_array();
    if($query){
        $this->db->select('SUM(pemasukan) - SUM(pengeluaran) as saldo');
        $this->db->from('tbl_transaksi');
        $this->db->where('waktu_transaksi',$query['waktu_transaksi']);
        $kemarin = $this->db->get()->row_array();
        $hasil = $kemarin;
    }else {
        $hasil = null;
    }
    return $hasil;
}

// digunakan untuk membandingkan saldo tahun kemarin
public function getSaldoTKemarin(){
    $this->db->select('waktu_transaksi');
    $this->db->from('tbl_transaksi');
    $this->db->where('year(waktu_transaksi)', date('Y', strtotime('last year')));;
    $query = $this->db->get()->row_array();
    if($query){
        $this->db->select('SUM(pemasukan) - SUM(pengeluaran) as saldo');
        $this->db->from('tbl_transaksi');
        $this->db->where('waktu_transaksi',$query['waktu_transaksi']);
        $kemarin = $this->db->get()->row_array();
        $hasil = $kemarin;
    }else {
        $hasil = null;
    }
    return $hasil;
}

// Untuk Saldo Bulan
public function getSaldoBulans(){
    $this->db->select('SUM(pemasukan) - SUM(pengeluaran) AS saldo');
    $this->db->from('tbl_transaksi');
    $this->db->where('month(waktu_transaksi)', date('m'));
    $query = $this->db->get()->row_array();
    return $query;
}
// Untuk Mencari Saldo dalam bulan
public function getSaldoBulan($bulan){
    $this->db->select('SUM(pemasukan) - SUM(pengeluaran) AS saldo');
    $this->db->from('tbl_transaksi');
    $this->db->where('monthname(waktu_transaksi)',$bulan);
    $query = $this->db->get()->row_array();
    if($query){
        $hasil = $query;
    }else {
        $hasil = null;
    }
    return $hasil;
}
// Untuk Mencari Saldo setahun
public function getSaldoTahuns(){
    $this->db->select('SUM(pemasukan) - SUM(pengeluaran) AS saldo');
    $this->db->from('tbl_transaksi');
    $this->db->where('year(waktu_transaksi)', date('Y'));
    $query = $this->db->get()->row_array();
    return $query;
}
// Untuk Mencari saldo dalam pertahun
public function getSaldoTahun($year){
    $this->db->select('SUM(pemasukan) - SUM(pengeluaran) AS saldo');
    $this->db->from('tbl_transaksi');
    $this->db->where('year(waktu_transaksi)',$year);
    $query = $this->db->get()->row_array();
    if($query){
        $hasil = $query;
    }else {
        $hasil = null;
    }
    return $hasil;
}
// Untuk mencari jumalah pendapatan perhari
public function getPendHari(){
    $this->db->select('SUM(pemasukan) AS pemasukan');
    $this->db->from('tbl_transaksi');
    $this->db->where('waktu_transaksi',date('Y-m-d'));
    $query = $this->db->get()->row_array();
    if($query){
        $hasil = $query;
    }else {
        $hasil = null;
    }
    return $hasil;
}
// Untuk Mencari jumalh pendapatan pertahun
public function getPendTahun(){
    $this->db->select('SUM(pemasukan) AS pemasukan');
    $this->db->from('tbl_transaksi');
    $this->db->where('year(waktu_transaksi)', date('Y'));
    $query = $this->db->get()->row_array();
    return $query;
}
// digunakan untuk membandingkan pendapatan kemarin
public function getPendKemarin(){
    $this->db->select('waktu_transaksi');
    $this->db->from('tbl_transaksi');
    $this->db->where('pemasukan > 0');
    $this->db->where('waktu_transaksi',date('Y-m-d', strtotime('yesterday')));
    $query = $this->db->get()->row_array();
    if($query){
        $this->db->select('SUM(pemasukan) AS pemasukan');
        $this->db->from('tbl_transaksi');
        $this->db->where('pemasukan > 0');
        $this->db->where('waktu_transaksi',$query['waktu_transaksi']);
        $kemarin = $this->db->get()->row_array();
        $hasil = $kemarin;
    }else {
        $hasil = null;
    }
    return $hasil;
} 
// digunakan untuk membandingkan pendapatan bulan kemarin
public function getpendBKemarin(){
    $this->db->select('waktu_transaksi');
    $this->db->from('tbl_transaksi');
    $this->db->where('pemasukan > 0');
    if(date('m') == '01'){
        $this->db->where('month(waktu_transaksi)', '12');
        $this->db->where('year(waktu_transaksi)', date('Y', strtotime('last year')));
    }else{
        $this->db->where('month(waktu_transaksi)', date('Y-m', strtotime('last month')));
    }
    $query = $this->db->get()->row_array();
    if($query){
        $this->db->select('SUM(pemasukan) AS pemasukan');
        $this->db->from('tbl_transaksi');
        $this->db->where('pemasukan > 0');
        $this->db->where('waktu_transaksi',$query['waktu_transaksi']);
        $kemarin = $this->db->get()->row_array();
        $hasil = $kemarin;
    }else {
        $hasil = null;
    }
    return $hasil;
}
// digunakan untuk membandingkan pendaptan tahun kemarin
public function getPendTKemarin(){
    $this->db->select('waktu_transaksi');
    $this->db->from('tbl_transaksi');
    $this->db->where('pemasukan > 0');
    $this->db->where('year(waktu_transaksi)', date('Y', strtotime('last year')));;
    $query = $this->db->get()->row_array();
    if($query){
        $this->db->select('SUM(pemasukan) as pemasukan');
        $this->db->from('tbl_transaksi');
        $this->db->where('pemasukan > 0');
        $this->db->where('waktu_transaksi',$query['waktu_transaksi']);
        $kemarin = $this->db->get()->row_array();
        $hasil = $kemarin;
    }else {
        $hasil = null;
    }
    return $hasil;
}

// Untuk Mencari Jumalh pengeluaran perhari
public function getPengHari(){
    $this->db->select('SUM(pengeluaran) AS pengeluaran');
    $this->db->from('tbl_transaksi');
    $this->db->where('waktu_transaksi',date('Y-m-d'));
    $query = $this->db->get()->row_array();
    if($query){
        $hasil = $query;
    }else {
        $hasil = null;
    }
    return $hasil;
}
// Untuk Mencari Jumlah Pengeluaran pertahun
public function getPengTahun(){
    $this->db->select('SUM(pengeluaran) AS pengeluaran');
    $this->db->from('tbl_transaksi');
    $this->db->where('year(waktu_transaksi)', date('Y'));
    $query = $this->db->get()->row_array();
    return $query;
}
    // Untuk Mendapatakan Tanggal Digunakan pada Laporan
    public function getHarian($tanggal){
        $this->db->from('tbl_transaksi');
        $this->db->where('waktu_transaksi',$tanggal);
        $query = $this->db->get()->result();
        return $query;
    }
    // digunakan untuk mencari tanggal awal dan akhir pada laporan yang ingin dilihat
    public function getSearch($tanggal_awal,$tanggal_akhir){
        $this->db->from('tbl_transaksi');
        $this->db->where('waktu_transaksi >=',$tanggal_awal);
        $this->db->where('waktu_transaksi <=',$tanggal_akhir);
        $query = $this->db->get()->result();
        if (count($query) > 0){
            $hasil = $query;
        }else{
            $hasil = null;
        }

        return $hasil;
    }


    // Untuk Mendapatkan Bulan Digunakan pada Laporan
    public function getBulanan($bulan){
        $this->db->from('tbl_transaksi');
        $this->db->where('monthname(waktu_transaksi)',$bulan);
        $query = $this->db->get()->result();
        return $query;
    }

    // pengeluaran
        // buat method untuk tampil data Pengeluaran
        public function getPengeluaran($id=null){
            $this->db->select('tbl_transaksi.*,user.email,user.profile_picture');
            $this->db->from('tbl_transaksi');
            $this->db->join('user','tbl_transaksi.user_id = user.id');
            if($id != null){
                $this->db->where('tbl_transaksi.id',$id);
                $this->db->where('pengeluaran > 0');
            }else{
                $this->db->where('pengeluaran > 0');
            }
            $query = $this->db->get()->result();
    
             return $query;
        }
        // Untuk Mendapatkan Pengeluaran Per bulan
        public function getPengBulan(){
            $this->db->select('SUM(pengeluaran) AS pengeluaran');
            $this->db->from('tbl_transaksi');
            $this->db->where('month(waktu_transaksi)', date('m'));
            $query = $this->db->get()->row_array();
            return $query;
        }
    
        // Untuk Menghapus Controller Pengeluaran
        public function deletePengeluaran($id){
            $this->db->select('id');
            $this->db->from('tbl_transaksi');
            $this->db->where("id = '$id'");
            $query = $this->db->get()->result();
    
            if(count($query)==1){
                $this->db->where("id = '$id'");
                $this->db->delete('tbl_transaksi');
                $hasil = 1;
            }else{
                $hasil = 0;
            }
            return $hasil;
        }
    
        // Untuk Menambahkan Controller Pengeluaran
        public function addPengeluaran($user_id, $waktu, $perincian, $pengeluaran){
    
            $data=[
                "user_id" => $user_id,
                "waktu_transaksi" => $waktu,
                "perincian" => $perincian,
                "pengeluaran" => $pengeluaran,
            ];
    
            $this->db->insert('tbl_transaksi',$data);
             
            if($this->db->affected_rows() == 1){
                $hasil = 1;
            }else if($this->db->affected_rows() == 0){
                $hasil = 0;
            }
    
            return $hasil;
        }
        // Untuk Mengedite Controller Pengeluaran
        function updatePengeluaran($user_id, $waktu_transaksi, $perincian, $pengeluaran,$id){
            $this->db->from('tbl_transaksi');
            $this->db->where("id = $id");
            $query = $this->db->get()->result_array();
            if(count($query) == 1){
                $data = [
                    "user_id" => $user_id,
                    "waktu_transaksi" => $waktu_transaksi,
                    "perincian" => $perincian,
                    "pengeluaran" => $pengeluaran,
                ];
                $this->db->where("id = $id");
                $this->db->update('tbl_transaksi',$data);
                
                $hasil=1;
            } else {
                $hasil=0;
            }
            return $hasil;
    }
    // digunakan untuk membandingkan pengeluaran kemarin
    public function getPengKemarin(){
        $this->db->select('waktu_transaksi');
        $this->db->from('tbl_transaksi');
        $this->db->where('pengeluaran > 0');
        $this->db->where('waktu_transaksi',date('Y-m-d', strtotime('yesterday')));
        $query = $this->db->get()->row_array();
        if($query){
            $this->db->select('SUM(pengeluaran) AS pengeluaran');
            $this->db->from('tbl_transaksi');
            $this->db->where('pengeluaran > 0');
            $this->db->where('waktu_transaksi',$query['waktu_transaksi']);
            $kemarin = $this->db->get()->row_array();
            $hasil = $kemarin;
        }else {
            $hasil = null;
        }
        return $hasil;
    } 
    // digunakan untuk membandingkan pengelauran bulan kemarin
    public function getpengBKemarin(){
        $this->db->select('waktu_transaksi');
        $this->db->from('tbl_transaksi');
        $this->db->where('pengeluaran > 0');
        if(date('m') == '01'){
            $this->db->where('month(waktu_transaksi)', '12');
            $this->db->where('year(waktu_transaksi)', date('Y', strtotime('last year')));
        }else{
            $this->db->where('month(waktu_transaksi)', date('Y-m', strtotime('last month')));
        }
        $query = $this->db->get()->row_array();
        if($query){
            $this->db->select('SUM(pengeluaran) AS pengeluaran');
            $this->db->from('tbl_transaksi');
            $this->db->where('pengeluaran > 0');
            $this->db->where('waktu_transaksi',$query['waktu_transaksi']);
            $kemarin = $this->db->get()->row_array();
            $hasil = $kemarin;
        }else {
            $hasil = null;
        }
        return $hasil;
    }
    // digunakan untuk membandingkan pengeluaran tahun kemarin
    public function getPengTKemarin(){
        $this->db->select('waktu_transaksi');
        $this->db->from('tbl_transaksi');
        $this->db->where('pengeluaran > 0');
        $this->db->where('year(waktu_transaksi)', date('Y', strtotime('last year')));;
        $query = $this->db->get()->row_array();
        if($query){
            $this->db->select('SUM(pengeluaran) as pengeluaran');
            $this->db->from('tbl_transaksi');
            $this->db->where('pengeluaran > 0');
            $this->db->where('waktu_transaksi',$query['waktu_transaksi']);
            $kemarin = $this->db->get()->row_array();
            $hasil = $kemarin;
        }else {
            $hasil = null;
        }
        return $hasil;
    }
        
    }