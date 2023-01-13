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
                    $this->model->aktivasi_login(1,$data['email']);
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

    function service_put(){

            $data = [
                "email" => $this->put('email')
            ];
            $hasil = $this->model->aktivasi_login(0,$data['email']);
            // var_dump($hasil);die;
            if($hasil == 1){
                $this->response([
                    'status' => true,
                    'message' => 'Logout Berhasil'
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'Logout Gagal'
                ],200);
            }
         }
    }
 


