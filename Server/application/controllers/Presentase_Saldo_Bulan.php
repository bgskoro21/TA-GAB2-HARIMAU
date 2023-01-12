<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'controllers/Token.php';
class Presentase_Saldo_Bulan extends Token{
    public function __construct(){
        parent::__construct();
        $this->load->model('M_Transaksi','mdl',TRUE);
    }   

    public function service_get(){
        if ($this->authtoken() == 0) {
            return $this->response(array("result" => 0, "error" => "Kode Signature Tidak Sesuai !"), 200);
        } else {
        $kemarin = $this->mdl->getSaldoBKemarin();
        // var_dump($kemarin);die;
        $bulan_ini = $this->mdl->getSaldoBulans();
        // var_dump($bulan_ini);die;
        if(isset($kemarin['saldo'])){
            $hasil = ($bulan_ini['saldo'] - $kemarin['saldo'])/$kemarin['saldo'] * 100;
        }


        if($kemarin){
            $this->response([
                'status' => true,
                'message' => 'Berhasil',
                'presentase' =>  number_format($hasil,1,",","") 
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