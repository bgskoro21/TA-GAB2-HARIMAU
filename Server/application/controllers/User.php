<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."libraries/Server.php";
class User extends Server {

	public function __construct()
	{
		parent::__construct();
		// panggil model M_User
		$this->load->model("M_User","model",TRUE);
		$this->load->model("M_UserToken","mdl",TRUE);
	}

	// buat function get, untuk mengambil data
	function service_get(){
		$email = $this->get('email');
		$current = $this->get('current');
		if(!empty($email)){
			$hasil = $this->model->get_data($email);

		}else if(!empty($current)){
			$hasil = $this->model->get_current($current);

		}
		else{
			$hasil = $this->model->get_data();
		}

		if($hasil != null){
			$this->response([
				"status" => true,
				"user" => $hasil,
				"massages" => "Berhasil"
			]);
		}else{
			$this->response([
				"status" => false,
				"massages" => "Gagal"
			]);

		}
		
		
	}

	// buat function put, untuk mengupdate data
	function service_put(){
		// // panggil model M_User
		// $this->load->model("M_User","model",TRUE);

		// membuat data array untuk mengambil parameter data yang akan diisi
		$data = [
			"email" => $this->put("email"),
			"password" => password_hash($this->post("password"),PASSWORD_DEFAULT),
			"nama_lengkap" => $this->put("nama_lengkap"),
            "no_hp" => $this->put("no_hp"),
            "level" => $this->put("level"),
			"token" => $this->put('token') 
		];

		// panggil method update_data, dengan memasukkan argumen berupa array
		$hasil = $this->model->update_data($data['email'],$data['password'],$data['nama_lengkap'],$data['no_hp'],$data['level'],$data['token']);

		// jika hasil = 0, kenapa 0 karena kita akan memasukkan data yang belum ada di dalam database
		if($hasil==1){
			$this->response([
				"status" => true,
				"massages" => "Data User Berhasil Diubah"
			]);
		}
		else{
			$this->response([
				"status" => false,
				"massages" => "Data User Gagal Diubah"
			]);

		}
		
	}

	private function _sendEmail($token,$type){
		$config = [	
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'patriciusaldi70@gmail.com',
            'smtp_pass' => 'vjwqpayxyyatknhl',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

		$this->load->library('email',$config);
		$this->email->initialize($config);
		$this->email->from('patriciusaldi80@gmail.com','Eyzel');
		$this->email->to($this->post('email'));
		if($type == 'verify'){
			$this->email->subject('Account Verification');
			$this->email->message('Click this link to verify your account : <a href="'. $this->post('url'). '?email='.$this->post('email').'&token='.urlencode($token).'">Verify</a>');
		}
		if($this->email->send()){
			return true;
		}else{
			echo $this->email->print_debugger();
		}
	}

	// buat function POST, untuk menambahkan data
	function service_post(){
		// // panggil model M_user
		$this->load->model("M_User","model",TRUE);

		// membuat data array untuk mengambil parameter data yang akan diisi
		$data = [
			"email" => $this->post("email"),
			"password" => password_hash($this->post("password"),PASSWORD_DEFAULT),
			"nama_lengkap" => $this->post("nama_lengkap"),
            "no_hp" => $this->post("no_hp"),
            "level" => $this->post("level"),
			"token" => ($this->post('email'))
		];

		$token = base64_encode(random_bytes(32));
		$user_token = [
			'email' => $data['email'],
			'token' => $token,
			'date_created' => time()
		];

		$this->mdl->add_token($user_token['email'],$user_token['token'],$user_token['date_created']);

		// panggil method save_data, dengan memasukkan argumen berupa array
		$hasil = $this->model->save_data($data['email'],$data['password'],$data['nama_lengkap'],$data['no_hp'],$data['level'],$data['token']);

		// Send Email Untuk Verifikasi
		$this->_sendEmail($token,'verify');

		// jika hasil = 0, kenapa 0 karena kita akan memasukkan data yang belum ada di dalam database
		if($hasil==1){
			$this->response([
				"status" => true,
				"massages" => "Data User Berhasil Ditambahan!"
			]);
		}
		else{
			$this->response([
				"status" => false,
				"massages" => "Data User Gagal Ditambahkan!"
			]);

		}

	}
	// buat function DELETE, untuk menghapus data
	function service_delete(){
		// // panggil model M_User
		// $this->load->model("Mmahasiswa","model",TRUE);
		// ambil parameter token "username"
		// kondisi where tidak harus primary key
		$token = $this->delete('email');
		// panggil methode delete_data
		// base64_encode untuk mengirimkan token dalam bentuk base64
		// untuk mengamanka data npm
		$hasil = $this->model->delete_data($token);
		// jika proses hapus berhasil terhapus
		if($hasil==1){
			$this->response([
				"status" => true,
				"massages" => "Data User Berhasil Dihapus!"
			]);
		}else{
			$this->response([
				"status" => false,
				"massages" => "Data User Gagal Dihapus!"
			]);
		}
	}
	
	public function forgotpassword(){

	}
}