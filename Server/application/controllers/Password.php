<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'controllers/Token.php';

class Password extends Token{

    function __construct(){
        parent::__construct();
        $this->load->model('M_User', 'mdl', TRUE);
    }

    function service_post(){
        if ($this->authtoken() == 0) {
            return $this->response(array("result" => 0, "error" => "Kode Signature Tidak Sesuai !"), 200);
        } else {
        $email = $this->post('email');
        $password = $this->post('password');
        $hasil = $this->mdl->cekPassword($email,$password);

        if(password_verify($password, $hasil['password'])){
            $this->response([
                'status' => true
            ],200);
        }else{
            $this->response([
                "status" => false
            ]);
        }
      }
    }

    function service_put(){
        if ($this->authtoken() == 0) {
            return $this->response(array("result" => 0, "error" => "Kode Signature Tidak Sesuai !"), 200);
        } else {
        $email = $this->put('email');
        $password = password_hash($this->put('password'),PASSWORD_DEFAULT);
        $hasil = $this->mdl->changePassword($email,$password);

        if($hasil == 1){
            $this->response([
                'status' => true,
                "message" => 'Password berhasil diubah!'
            ],200);
        }else{
            $this->response([
                'status' => false,
                "message" => 'Password gagal diubah!'
            ],200);
        }
    }
}
}