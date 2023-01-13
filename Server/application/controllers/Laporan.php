<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."libraries/Server.php";

class Laporan extends Server{

    function __construct(){
        parent::__construct();
        $this->load->model('M_Transaksi', 'mdl', TRUE);
    }

    function service_get(){

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