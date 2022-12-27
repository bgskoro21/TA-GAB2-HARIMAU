<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."libraries/Server.php";

class saldo extends Server {

    public function __construct()
	{
		parent::__construct();
		// panggil model Mmahasiswa
		$this->load->model("Msaldo","mdl",TRUE);
	}

    function service_get(){
        $hasil = $this->mdl->getSaldo();

        if($hasil > 0){
            $this->response($hasil,200);
        }else{
            $this->response([
                'status' => 'Data Tidak Ditemukan'
            ],200);
        }
    }
}
