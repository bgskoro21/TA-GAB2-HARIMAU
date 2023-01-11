<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'controllers/Token.php';

class Login extends Token{
    public function __construct(){
        parent::__construct();
        $this->load->model('M_User','model',TRUE);
        
    }

    public function service_post(){
        $data = [
        'email' => $this->post('email'),
         'password' => $this->post('password')
        ];

        $cekLogin = $this->model->checkLogin($data['email']);
        if($cekLogin){
            if($cekLogin['is_active']){
                // cek password
                // var_dump($cekLogin['password']);die;
                if(password_verify($data['password'], $cekLogin['password'])){
                    $data = [
                        'email' => $cekLogin['email'],
                        'level' => $cekLogin['level'],
                        'id'=> $cekLogin['id'],
                        'nama_lengkap' => $cekLogin['nama_lengkap'],
                        'profile_picture' => $cekLogin['profile_picture']
                        
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


