<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'controllers/Token.php';

class Lunas extends Token {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Hutang','mdl',TRUE);
    }

    public function service_put(){
        if ($this->authtoken() == 0) {
            return $this->response(array("result" => 0, "error" => "Kode Signature Tidak Sesuai !"), 200);
        } else {
        $token = $this->put('token');
        $status = $this->put('status');
        $hasil = $this->mdl->update_status($token, $status);

        if($hasil==1){
            $this->response([
                'status' => true,
                'message' => 'Hutang Lunas!',
        ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Status Hutang Gagal Diubah!',
            ]);
            }
        }
    }
}