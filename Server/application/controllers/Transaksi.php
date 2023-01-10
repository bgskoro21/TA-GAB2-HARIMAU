<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH."libraries/Server.php";
class Transaksi extends Server{
    public function __construct(){
        parent::__construct();
        $this->load->model('M_Transaksi','mdl',TRUE);
    }

    
    function service_get(){
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