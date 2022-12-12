<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."libraries/Server.php";

class Login extends Server{
    public function __construct(){
        parent::__construct();
        $this->load->model('M_User','mdl',TRUE);
    }

    public function service_post(){
        $data = [
        'username' => $this->post('username'),
            'password' => $this->post('password')
        ];

        $hasil = $this->mdl->login($data['username'], $data['password']);

        if($hasil){
            $this->response([
                "status" => "Berhasil Login",
                "data" => $hasil,
            ]);
        }else if ($hasil == null){
            $this->response([
                "status" => "Login Gagal",
            ]);
        }
    }
}


