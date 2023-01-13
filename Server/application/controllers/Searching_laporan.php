<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."libraries/Server.php";

class Searching_laporan extends Server{

    function __construct(){
        parent::__construct();
        $this->load->model('M_Transaksi', 'mdl', TRUE);
    }

    function service_get(){

        $tanggal_awal = $this->get('tanggal_awal');
        $tanggal_akhir = $this->get('tanggal_akhir');
            $hasil = $this->mdl->getSearch($tanggal_awal,$tanggal_akhir);

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