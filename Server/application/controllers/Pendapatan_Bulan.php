<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH."libraries/Server.php";
class Pendapatan_Bulan extends Server{
    public function __construct(){
        parent::__construct();
        $this->load->model('M_Transaksi','mdl',TRUE);
    }   

    public function service_get(){
        $hasil = $this->mdl->getBulan();

        if($hasil > 0){
            $this->response([
                'status' => true,
                'message' => 'Berhasil',
                'pendapatan_bulan' => $hasil
        ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Gagal',
            ],200);
        }
    }

}