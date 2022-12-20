<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH."libraries/Server.php";
class Bulan extends Server{
    public function __construct(){
        parent::__construct();
        $this->load->model('Mpendapatan','mdl',TRUE);
    }

    
    function service_get(){
        $hasil = $this->mdl->getBulans();

        if($hasil > 0){
            $this->response($hasil,200);
        }else{
            $this->response([
                'status' => 'Data Tidak Ditemukan'
            ],200);
        }
    }

}