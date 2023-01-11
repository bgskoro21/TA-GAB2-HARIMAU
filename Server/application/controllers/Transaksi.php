<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'controllers/Token.php';
class Transaksi extends Token{
    public function __construct(){
        parent::__construct();
        $this->load->model('M_Transaksi','mdl',TRUE);
    }

    
    function service_get(){
        if ($this->authtoken() == 0) {
            return $this->response(array("result" => 0, "error" => "Kode Signature Tidak Sesuai !"), 200);
        } else {
        $hasil = $this->mdl->getAllTransaksi();

        if($hasil){
            $this->response([
                'status' => true,
                'message' => 'Berhasil',
                'transaksi' => $hasil
        ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Gagal',
                'transaksi' => 0
            ]);
        }
      }
    }

}