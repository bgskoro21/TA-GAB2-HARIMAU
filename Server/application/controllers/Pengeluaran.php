<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."libraries/Server.php";

class Pengeluaran extends Server {

	public function __construct()
	{
		parent::__construct();
		// panggil model Mmahasiswa
		$this->load->model("M_Transaksi","mdl",TRUE);
	}

	function service_get(){
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

	function service_delete($id){
        $hasil = $this->mdl->deletePengeluaran($id);

        if($hasil == 1){
            $this->response([
                'status' => true,
                'message' => 'Data Pengeluaran Berhasil Dihapus',
                'pengeluaran' => $hasil
        ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Data Pengeluaran Gagal Dihapus',
            ]);
        }
    }

	function service_post(){
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

    function service_put(){
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
