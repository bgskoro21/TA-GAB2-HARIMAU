<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class M_Hutang extends CI_Model {

	// buat method untuk tampil data
    public function get_hutang($id=null){
        $this->db->select('*');
        $this->db->from('tbl_hutangs');
        // $this->db->join('hutang_hutang','tbl_hutang.hutang_id = hutang_hutang.id');
        if($id != null){
            $this->db->where('tbl_hutangs.id',$id);
            $query = $this->db->get()->row_array();
        }else{
            $query = $this->db->get()->result();
        }

         return $query;
    }

    public function delete_hutang($id){
        $this->db->select('id');
        $this->db->from('tbl_hutangs');
        $this->db->where("id = '$id'");
        $query = $this->db->get()->result();

        if(count($query)==1){
            $this->db->where("id = '$id'");
            $this->db->delete('tbl_hutangs');
            $hasil = 1;
        }else{
            $hasil = 0;
        }
        return $hasil;
    }

    public function add_hutang($nama_pelanggan,$kode_hutang, $tgl_transaksi, $tgl_tempo,$hutang,$user_id, $no_hp, $perincian,$token){
        $this->db->select('kode_hutang');
        $this->db->from('tbl_hutangs');
        $this->db->where('kode_hutang',$token);
        $query = $this->db->get()->row_array();

        if(!$query){
            $data=[
                "nama_pelanggan" => $nama_pelanggan,
                'kode_hutang' => $kode_hutang,
                "tgl_transaksi" => $tgl_transaksi,
                "tgl_tempo" => $tgl_tempo,
                "total_hutang" => $hutang,
                'user_id' => $user_id,
                'no_hp' => $no_hp,
                'perincian' => $perincian
            ];
    
            $this->db->insert('tbl_hutangs',$data);
            
            $hasil = 1;
        }else{
            $hasil = 0;
        }

        return $hasil;
    }

    function update_hutang($nama_pelanggan, $tgl_transaksi, $tgl_tempo,$hutang,$id,$user_id, $no_hp, $perincian, $kode_hutang, $token){
        $this->db->from('tbl_hutangs');
        $this->db->where('kode_hutang',$token);
        $query = $this->db->get()->row_array();
        if($query){
            $data=[
                "nama_pelanggan" => $nama_pelanggan,
                "tgl_transaksi" => $tgl_transaksi,
                "tgl_tempo" => $tgl_tempo,
                "total_hutang" => $hutang,
                'user_id' => $user_id,
                'no_hp' => $no_hp,
                'perincian' => $perincian,
                'kode_hutang' => $kode_hutang
            ];
            $this->db->where('kode_hutang',$token);
            $this->db->update('tbl_hutangs',$data);
            
            $hasil=1;
        } else {
            $hasil=0;
        }
        return $hasil;
}
public function update_status($kode_hutang, $status){
    $this->db->select('kode_hutang');
    $this->db->from('tbl_hutangs');
    $this->db->where('kode_hutang',$kode_hutang);
    $query = $this->db->get()->row_array();
    if($query){
        $data['status'] = $status;
        $this->db->where('kode_hutang',$kode_hutang);
        $this->db->update('tbl_hutangs',$data);
        $hasil = 1;
    }else{
        $hasil = 0;
    }
    return $hasil;
 }
}