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
		$username = $this->get('username');
		$current = $this->get('current');
		if(!empty($username)){
			$hasil = $this->model->get_data($username);

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
			"username" => $this->put("username"),
			"email" => $this->put("email"),
			"password" => $this->put("password"),
			"nama_lengkap" => $this->put("nama_lengkap"),
            "no_hp" => $this->put("no_hp"),
            "level" => $this->put("level"),
			"token" => $this->put('token') 
		];

		// panggil method update_data, dengan memasukkan argumen berupa array
		$hasil = $this->model->update_data($data['username'] ,$data['email'],$data['password'],$data['nama_lengkap'],$data['no_hp'],$data['level'],$data['token']);

		// jika hasil = 0, kenapa 0 karena kita akan memasukkan data yang belum ada di dalam database
		if($hasil==1){
			$this->response(array("status" => "Data Mahasiswa Berhasil Diubah"),200);
		}
		// jika hasil tidak sama dengan 0
		else{
			$this->response(array("status" => "Data Mahasiswa Gagal Diubah"),200);
		}
		
	}

	private function _sendEmail($token,$type){
		$config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'mahardikaakbar9090@gmail.com',
            'smtp_pass' => 'ghgojxuddibxpozu',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

		$this->load->library('email',$config);
		$this->email->initialize($config);
		$this->email->from('mahardikaakbar9090@gmail.com','Eyzel');
		$this->email->to($this->post('email'));
		if($type == 'verify'){
			$this->email->subject('Account Verification');
			$this->email->message('Click this link to verify your account : <a href="'. base_url(). 'auth/verify?email='.$this->post('email').'&token='.urlencode($token).'">Verify</a>');
		}
		if($this->email->send()){
			return true;
		}else{
			echo $this->email->print_debugger();
		}
	}

	public function verify(){
		$email = $this->get('email');
		$token = $this->get('token');

		$query;
	}

	// buat function POST, untuk menambahkan data
	function service_post(){
		// // panggil model M_user
		// $this->load->model("M_User","model",TRUE);

		// membuat data array untuk mengambil parameter data yang akan diisi
		$data = [
			"username" => $this->post("username"),
			"email" => $this->post("email"),
			"password" => password_hash($this->post("password"),PASSWORD_DEFAULT),
			"nama_lengkap" => $this->post("nama_lengkap"),
            "no_hp" => $this->post("no_hp"),
            "level" => $this->post("level"),
			"is_active" => $this->post("is_active"),
			"token" => ($this->post('username'))
		];

		$token = base64_encode(random_bytes(32));
		$user_token = [
			'email' => $data['email'],
			'token' => $token,
			'date_created' => time()
		];

		$this->mdl->add_token($user_token['email'],$user_token['token'],$user_token['date_created']);

		// panggil method save_data, dengan memasukkan argumen berupa array
		$hasil = $this->model->save_data($data['username'] ,$data['email'],$data['password'],$data['nama_lengkap'],$data['no_hp'],$data['level'],$data['token']);

		// Send Email
		$this->_sendEmail($token,'verify');

		// jika hasil = 0, kenapa 0 karena kita akan memasukkan data yang belum ada di dalam database
		if($hasil){
			$this->response(array("status" => "Data User Berhasil Disimpan"),200);
		}
		// jika hasil tidak sama dengan 0
		else{
			$this->response(array("status" => "Data User Gagal Disimpan"),200);
		}

	}
	// buat function DELETE, untuk menghapus data
	function service_delete(){
		// // panggil model M_User
		// $this->load->model("Mmahasiswa","model",TRUE);
		// ambil parameter token "username"
		// kondisi where tidak harus primary key
		$token = $this->delete('username');
		// panggil methode delete_data
		// base64_encode untuk mengirimkan token dalam bentuk base64
		// untuk mengamanka data npm
		$hasil = $this->model->delete_data($token);
		// jika proses hapus berhasil terhapus
		if($hasil != nulll){
			$this->response([
				"status" => true,
				"user" => $hasil,
				"massages" => "Data Berhasil Dihapus!"
			]);
		}else{
			$this->response([
				"status" => false,
				"massages" => "Data Gagal Dihapus!"
			]);
		}
	}
    
}
