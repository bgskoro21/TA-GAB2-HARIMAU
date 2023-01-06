<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."libraries/Server.php";

class Pendapatan extends Server {

	public function __construct()
	{
		parent::__construct();
		// panggil model Mmahasiswa
		$this->load->model("M_Transaksi","mdl",TRUE);
	}

	function service_get(){
        $id = $this->get('id');
        
        $hasil = $this->mdl->get_data($id);


        if($id != null){
            $hasil = $this->mdl->get_data($id);
        }else{
            $hasil = $this->mdl->get_data();
        }


        if($hasil > 0){
            $this->response([
                'status' => true,
                'message' => 'Berhasil',
                'pendapatan' => $hasil
        ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Gagal',
            ],200);
        }
    }

	function service_delete($id){
        $hasil = $this->mdl->delete_data($id);

        if($hasil == 1){
            $this->response([
                'status' => true,
                'message' => 'Data Pendapatan Berhasil Dihapus!',
        ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Data Pendapatan Gagal dihapus!',
            ],200);
        }
    }

	function service_post(){
        $user_id = $this->post('user_id');
        $waktu = $this->post('waktu_transaksi');
        $perincian = $this->post('perincian');
        $pemasukkan = $this->post('pemasukkan');

        $hasil = $this->mdl->add_data($user_id, $waktu, $perincian, $pemasukkan);

        if($hasil == 1){
            $this->response([
                'status' => true,
                'message' => 'Data Pendapatan Berhasil Ditambahkan!',
        ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Data Pendapatan Gagal Ditambahkan!',
            ],200);
    }
}

    function service_put(){
        $data = [
            "user_id" => $this->put('user_id'),
            "waktu_transaksi" => $this->put('waktu_transaksi'),
            "perincian" => $this->put('perincian'),
            "pemasukkan" => $this->put('pemasukkan'),
            "id" => $this->put('id')
        ];

        $hasil = $this->mdl->update_data($data['user_id'], $data['waktu_transaksi'],$data['perincian'],$data['pemasukkan'],$data['id']);

        if($hasil==1){
            $this->response([
                'status' => true,
                'message' => 'Data Pendapatan Berhasil Diubah!',
        ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Data Pendapatan Gagal Diubah!',
            ],200);
    }

    
    }
}