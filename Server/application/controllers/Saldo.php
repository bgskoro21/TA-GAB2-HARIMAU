<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH."libraries/Server.php";
class Saldo extends Server{
    public function __construct(){
        parent::__construct();
        $this->load->model('M_Transaksi','mdl',TRUE);
    }   

    public function service_get(){
        $hasil = $this->mdl->getSaldo();

        if($hasil > 0){
            $this->response([
                'status' => true,
                'message' => 'Berhasil',
                'total_saldo' => $hasil
<<<<<<< HEAD
        ],200);
=======
            ],200);
>>>>>>> 9f142b7fecf9eae39682a2e9af33c215031e5bd4
        }else{
            $this->response([
                'status' => false,
                'message' => 'Gagal',
            ]);
        }
    }

}