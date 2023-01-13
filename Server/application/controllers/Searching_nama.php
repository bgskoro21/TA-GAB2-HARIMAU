<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'controllers/Token.php';

class Searching_nama extends Token{

    function __construct(){
        parent::__construct();
        $this->load->model('M_Transaksi', 'mdl', TRUE);
    }

    function service_get(){
        if ($this->authtoken() == 0) {
            return $this->response(array("result" => 0, "error" => "Kode Signature Tidak Sesuai !"), 200);
        } else {
        $nama = $this->get('nama_lengkap');
        $level = $this->get('level');
        if(!empty($nama)){
            $hasil = $this->mdl->getSearchNama($nama);
        } else {
            $hasil = $this->mdl->getSearchNama($nama,$level);
        }


            if($hasil){
                $this->response([
                    'status' => true,
                    'message' => 'Berhasil',
                    'searching' => $hasil
            ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'Gagal',
                ]);
            }
    }
  }
}