<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'controllers/Token.php';

class Laporan extends Token{

    function __construct(){
        parent::__construct();
        $this->load->model('M_Transaksi', 'mdl', TRUE);
    }

    function service_get(){
        if ($this->authtoken() == 0) {
            return $this->response(array("result" => 0, "error" => "Kode Signature Tidak Sesuai !"), 200);
        } else {
        $tanggal = $this->get('tanggal');
        $bulan = $this->get('bulan');
        if(!empty($tanggal)){
            $hasil = $this->mdl->getHarian($tanggal);
        }else{
            $hasil = $this->mdl->getBulanan($bulan);
        }
        if($hasil){
            $this->response([
                'status' => true,
                'message' => 'Berhasil',
                'laporan' => $hasil
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