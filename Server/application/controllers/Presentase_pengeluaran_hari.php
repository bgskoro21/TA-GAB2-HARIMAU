<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'controllers/Token.php';
class Presentase_pengeluaran_hari extends Token{
    public function __construct(){
        parent::__construct();
        $this->load->model('M_Transaksi','mdl',TRUE);
    }   

    public function service_get(){
        if ($this->authtoken() == 0) {
            return $this->response(array("result" => 0, "error" => "Kode Signature Tidak Sesuai !"), 200);
        } else {
        $kemarin = $this->mdl->getPengKemarin();
        $hari_ini = $this->mdl->getPengHari();
        if(isset($kemarin['pengeluaran'])){
            $hasil = ($hari_ini['pengeluaran']-$kemarin['pengeluaran'])/$kemarin['pengeluaran'] * 100;
        }


        if($kemarin){
            $this->response([
                'status' => true,
                'message' => 'Berhasil',
                'presentase' =>  $hasil
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