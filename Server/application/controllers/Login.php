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
        'email' => $this->post('email'),
         'password' => $this->post('password')
        ];

        $cekLogin = $this->mdl->checkLogin($data['email']);
        if($cekLogin){
            if($cekLogin['is_active']){
                // cek password
                // var_dump($cekLogin['password']);die;
                if(password_verify($data['password'], $cekLogin['password'])){
                    $data = [
                        'email' => $cekLogin['email'],
                        'level' => $cekLogin['level']
                    ];
                    $this->response([
                        "status" => 1,
                        'userdata' => $data,
                        'message' => 'Berhasil Login!'
                    ]);
                }else{
                    $this->response([
                        "status" => 0,
                        'message' => 'Password salah!'
                    ]);
                }
            }else{
                $this->response([
                    "status" => 0,
                    'message' => 'Email belum diaktivasi!'
                ]);
            }
        }else{
            $this->response([
                "status" => 0,
                'message' => 'Email tidak terdaftar!'
            ]);
        }
    }
}


