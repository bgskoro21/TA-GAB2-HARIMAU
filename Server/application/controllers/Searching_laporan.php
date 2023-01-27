<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'controllers/Token.php';

class Searching_laporan extends Token{

    function __construct(){
        parent::__construct();
        $this->load->model('M_Transaksi', 'mdl', TRUE);
    }

    function service_get(){
        if ($this->authtoken() == 0) {
            return $this->response(array("result" => 0, "error" => "Kode Signature Tidak Sesuai !"), 200);
        } else {

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
  }