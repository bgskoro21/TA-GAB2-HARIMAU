<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."libraries/Server.php";

class Password extends Server{

    function __construct(){
        parent::__construct();
        $this->load->model('M_User', 'mdl', TRUE);
    }

    function service_post(){
        $username = $this->post('username');
        $password = $this->post('password');
        $hasil = $this->mdl->cekPassword($username,$password);

        if($hasil == 1){
            $this->response([
                'status' => true
            ],200);
        }else{
            $this->response([
                "status" => false
            ],200);
        }
    }

    function service_put(){
        $username = $this->put('username');
        $password = $this->put('newpassword');
        $hasil = $this->mdl->changePassword($username,$password);

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