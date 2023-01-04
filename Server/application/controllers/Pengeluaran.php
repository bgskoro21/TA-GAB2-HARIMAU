<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."libraries/Server.php";

class Pengeluaran extends Server {

	public function __construct()
	{
		parent::__construct();
		// panggil model Mmahasiswa
		$this->load->model("Mpengeluaran","mdl",TRUE);
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
            $this->response($hasil,200);
        }else{
            $this->response([
                'status' => 'Data Tidak Ditemukan'
            ],200);
        }
    }

	function service_delete($id){
        $hasil = $this->mdl->delete_data($id);

        if($hasil == 1){
            $this->response([
                "status" => 'Data Berhasil Dihapus!'
            ]);
        }else{
            $this->response([
                "status" => 'Data Gagal Dihapus!'
            ]);
        }
    }

	function service_post(){
        $user_id = $this->post('user_id');
        $waktu = $this->post('waktu_transaksi');
        $perincian = $this->post('perincian');
        $pengeluaran = $this->post('pengeluaran');

        $hasil = $this->mdl->add_data($user_id, $waktu, $perincian, $pengeluaran);

        if($hasil == 1){
            $this->response([
                "status" => "Data Berhasil Ditambahkan"
            ]);
        }else{
            $this->response(["status" => "Data Gagal Ditambahkan"]);
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

        $hasil = $this->mdl->update_data($data['user_id'], $data['waktu_transaksi'],$data['perincian'],$data['pengeluaran'],$data['id']);

        if($hasil==1){
            $this->response([
                "status" => "Data Berhasil Diubah!"
            ]);
        }else{
            $this->response(["status" => "Data Gagal Diubah!"]);
        }
    }
}
