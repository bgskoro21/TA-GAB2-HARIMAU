<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class M_Transaksi extends CI_Model {

	// buat method untuk tampil data
    public function get_data($id=null){
        $this->db->select('tbl_transaksi.*,user.nama_lengkap');
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
        $this->db->select('month(waktu_transaksi) as bulan');
        $this->db->from('tbl_transaksi');
        $this->db->where('year(waktu_transaksi)',date('Y'));
        $this->db->group_by('month(waktu_transaksi)');
       $query = $this->db->get()->result();
       return $query;
    }

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
        $this->db->select('SUM(pemasukan) AS Total_bulan');
        $this->db->from('tbl_transaksi');
        $this->db->where('month(waktu_transaksi)', date('m'));
        $query = $this->db->get()->row_array();
        return $query;
    }

    public function getHari(){
        $this->db->select('waktu_transaksi');
        $this->db->from('tbl_transaksi');
        $this->db->group_by('waktu_transaksi');
        $query = $this->db->get()->result();
        return $query;
    }

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

public function getSaldo(){
    $this->db->select('SUM(pemasukan) - SUM(pengeluaran) AS Saldo');
    $this->db->from('tbl_transaksi');
    $query = $this->db->get()->result();
    return $query;
}

    public function getHarian($tanggal){
        $this->db->from('tbl_transaksi');
        $this->db->where('waktu_transaksi',$tanggal);
        $query = $this->db->get()->result();
        return $query;
    }

    public function getBulanan($bulan){
        $this->db->from('tbl_transaksi');
        $this->db->where('monthname(waktu_transaksi)',$bulan);
        $query = $this->db->get()->result();
        return $query;
    }

    // pengeluaran
        // buat method untuk tampil data
        public function getPengeluaran($id=null){
            $this->db->select('tbl_transaksi.*,user.nama_lengkap');
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
    
        public function getPengBulan(){
            $this->db->select('SUM(pengeluaran) AS Total_bulan');
            $this->db->from('tbl_transaksi');
            $this->db->where('month(waktu_transaksi)', date('m'));
            $query = $this->db->get()->row_array();
            return $query;
        }
    
    
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
    
        
    }
