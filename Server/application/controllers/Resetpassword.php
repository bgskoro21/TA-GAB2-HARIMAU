<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."libraries/Server.php";

class Resetpassword extends Server{
    public function __construct()
	{
		parent::__construct();
		// panggil model M_User
		$this->load->model("M_User","model",TRUE);
		$this->load->model("M_UserToken","mdl",TRUE);
	}

    public function service_get(){
		$email = $this->get('email');
		$token = $this->get('token');
        // var_dump($token);die;

		$user = $this->model->checkLogin($email);
		if($user){
			$user_token = $this->mdl->get_Token($token);
            // var_dump($user_token);die;
			if($user_token){
				if(time()-$user_token['date_created'] < (60 * 60 * 24)){
                    $this->model->delete_data($email);
					$this->mdl->del_email($email);
					$this->response([
						"status" => true,
						"massages" => "Berhasil",
                        "email" => $email
					]);
				}else{
					$this->model->delete_data($email);
					$this->mdl->del_email($email);
					$this->response([
						"status" => false,
						"massages" => "Reset Password Gagal! Token Salah"
					]);
				}
			}else{
                $this->response([
                    "status" => false,
                    "massages" => "Reset Password Gagal! Email Salah"
                ]);
            }
			
		}else{
			$this->response([
				"status" => false,
				"massages" => "Aktivasi Akun Gagal! Email Salah"
			]);
		}
	}

    public function service_put()
    {
        $email = $this->put('email');
        $password = password_hash($this->put('password'),PASSWORD_DEFAULT);
        
        $hasil = $this->model->changePassword($email,$password);
        // var_dump($hasil);die;
        if ($hasil == 1){
            $this->response([
                "status" => true,
                "massages" => "Password Berhasil Dirubah!"
            ]);
        } else {
            $this->response([
                "status" => false,
                "massages" => "Password Gagal Dirubah!"
            ]);
        }
    }
}