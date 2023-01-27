<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'controllers/Token.php';

class Pengeluaran extends Token {

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

        $hasil = $this->mdl->getPengeluaran($id);


        if($id != null){
            $hasil = $this->mdl->getPengeluaran($id);
        }else{
            $hasil = $this->mdl->getPengeluaran();
        }


        if($hasil > 0){
            $this->response([
                'status' => true,
                'message' => 'Berhasil',
                'pengeluaran' => $hasil
        ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Gagal',
            ]);
        }
      }
    }

	function service_delete(){
        if ($this->authtoken() == 0) {
            return $this->response(array("result" => 0, "error" => "Kode Signature Tidak Sesuai !"), 200);
        } else {

            $data = $this->delete('selected');
            $id = $this->delete('id');
    
            
        if(!empty($data)){
            $hasil = $this->mdl->delete_selected_data(explode(",",$data));
        }else{
            $hasil = $this->mdl->deletePengeluaran($id);
        }

        if($hasil == 1){
            $this->response([
                'status' => true,
                'message' => 'Data Pengeluaran Berhasil Dihapus!',
        ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Data Pengeluaran Gagal dihapus!',
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
        $pengeluaran = $this->post('pengeluaran');

        $hasil = $this->mdl->addPengeluaran($user_id, $waktu, $perincian, $pengeluaran);

        if($hasil == 1){
            $this->response([
                'status' => true,
                'message' => 'Data Pengeluara Berhasil Ditambahkan!',
        ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Data Pengeluaran Gagal Ditambahkan!',
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
            "pengeluaran" => $this->put('pengeluaran'),
            "id" => $this->put('id')
        ];

        $hasil = $this->mdl->updatePengeluaran($data['user_id'], $data['waktu_transaksi'],$data['perincian'],$data['pengeluaran'],$data['id']);

        if($hasil==1){
            $this->response([
                'status' => true,
                'message' => 'Data Pengeluaran Berhasil Diubah!',
        ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Data Pengeluaran Gagal Diubah!',
            ]);
        }
      }
    }
}