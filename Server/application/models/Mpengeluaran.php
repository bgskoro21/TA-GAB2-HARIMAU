<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Mpengeluaran extends CI_Model {

	// buat method untuk tampil data
    public function get_data(){
        $this->db->select('*');
        $this->db->from('tbl_transaksi');
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


    public function add_data($user_id, $waktu, $perincian, $pengeluaran){

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

    function update_data($user_id, $waktu_transaksi, $perincian, $pengeluaran,$id){
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