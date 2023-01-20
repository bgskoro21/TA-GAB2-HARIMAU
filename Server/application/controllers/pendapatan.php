<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'controllers/Token.php';

class Pendapatan extends Token {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model("M_Transaksi","mdl",TRUE);
	}

	function service_get(){
        if ($this->authtoken() == 0) {
            return $this->response(array("result" => 0, "error" => "Kode Signature Tidak Sesuai !"), 200);
        } else {
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
            ]);
        }
      }
    }

	function service_delete($id){
        if ($this->authtoken() == 0) {
            return $this->response(array("result" => 0, "error" => "Kode Signature Tidak Sesuai !"), 200);
        } else {

        $data = $this->delete('selected');
        $id = $this->delete('id');

        if(!empty($data)){
            $hasil = $this->mdl->delete_selected_data(explode(",",$data));
        }else {
            $hasil = $this->mdl->delete_data($id);
        }

        if($hasil == 1){
            $this->response([
                'status' => true,
                'message' => 'Data Pendapatan Berhasil Dihapus!',
        ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Data Pendapatan Gagal dihapus!',
            ]);
        }
      }
    }

	function service_post(){
        if ($this->authtoken() == 0) {
            return $this->response(array("result" => 0, "error" => "Kode Signature Tidak Sesuai !"), 200);
        } else {
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
            ]);
    }
  }
}

    function service_put(){
        if ($this->authtoken() == 0) {
            return $this->response(array("result" => 0, "error" => "Kode Signature Tidak Sesuai !"), 200);
        } else {
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
            ]);
    }

    
    }
  }
}