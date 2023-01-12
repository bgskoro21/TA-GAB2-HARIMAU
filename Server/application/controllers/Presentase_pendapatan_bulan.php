<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'controllers/Token.php';
class Presentase_pendapatan_bulan extends Token{
    public function __construct(){
        parent::__construct();
        $this->load->model('M_Transaksi','mdl',TRUE);
    }   

    public function service_get(){
        if ($this->authtoken() == 0) {
            return $this->response(array("result" => 0, "error" => "Kode Signature Tidak Sesuai !"), 200);
        } else {
        $kemarin = $this->mdl->getpendBKemarin();
        // var_dump($kemarin);die;
        $bulan_ini = $this->mdl->getBulan();
        // var_dump($bulan_ini);die;
        if(isset($kemarin['pemasukan'])){
            $hasil = ($bulan_ini['pemasukan'] - $kemarin['pemasukan'])/$kemarin['pemasukan'] * 100;
        }


        if($kemarin){
            $this->response([
                'status' => true,
                'message' => 'Berhasil',
                'presentase_pendapatan' => number_format($hasil,1,",","") 
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