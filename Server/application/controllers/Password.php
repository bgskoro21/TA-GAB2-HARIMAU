<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."libraries/Server.php";

class Password extends Server{

    function __construct(){
        parent::__construct();
        $this->load->model('M_User', 'mdl', TRUE);
    }

    function service_post(){
        $email = $this->post('email');
        $password = $this->post('password');
        $hasil = $this->mdl->cekPassword($email,$password);

        if($hasil == 1){
            $this->response([
                'status' => true
            ],200);
        }else{
            $this->response([
                "status" => false
            ]);
        }
    }

    function service_put(){
        $email = $this->put('email');
        $password = $this->put('password');
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