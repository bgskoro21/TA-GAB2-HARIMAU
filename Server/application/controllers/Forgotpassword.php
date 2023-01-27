<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."libraries/Server.php";

class Forgotpassword extends Server{
    public function __construct()
	{
		parent::__construct();
		// panggil model M_User
		$this->load->model("M_User","model",TRUE);
		$this->load->model("M_UserToken","mdl",TRUE);
	}

    private function _sendEmail($token,$type){
		$config = [	
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'bagaskara_dwi_putra@teknokrat.ac.id',
            'smtp_pass' => '19312112',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

		$this->load->library('email',$config);
		$this->email->initialize($config);
		$this->email->from('bagaskara_dwi_putra@teknokrat.ac.id','Eyzel');
		$this->email->to($this->post('email'));
		if($type == 'forgot'){
			$this->email->subject('Reset Password');
			$this->email->message('Click this link to verify your account : <a href="'. $this->post('url'). '?email='.$this->post('email').'&token='.urlencode($token).'">Forgot</a>');
		}
		if($this->email->send()){
			return true;
		}else{
			echo $this->email->print_debugger();
		}
	}

    public function service_post(){

        $data = [
            "email" => $this->post("email")
        ];
        
        $user = $this->model->checkLogin($data['email']);
		if($user){
            if($user['is_active']==1){
                $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $data['email'],
                'token' => $token,
                'date_created' => time()
            ];
            $query = $this->mdl->add_token($user_token['email'],$user_token['token'],$user_token['date_created']);
            $this->_sendEmail($token,'forgot');
            $this->response([
                "status" => true,
                "massages" => "Silahkan Cek Email Anda Untuk Melakukan Forgot Password"
            ]);
            } else {
            $this->response([
                    "status" => false,
                    "massages" => "Email Belum TerAktivasi"
                ]);
            }
        } else {
            $this->response([
                "status" => false,
                "massages" => "Email Tidak Terdaftar"
            ]);
        }
    }
}