<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."libraries/Server.php";
class User extends Server {

	public function __construct()
	{
		parent::__construct();
		// panggil model M_User
		$this->load->model("M_User","model",TRUE);
	}

	// buat function get, untuk mengambil data
	function service_get(){
		// // panggil model Mmahasiswa, parameter kedua sebagai alias bersifat opsional
		// $this->load->model("M_User","model",TRUE);
		// panggil function get_data yang ada pada model yang sudah diinstance dengan perintah diatas
		$hasil = $this->model->get_data();
		// memanggil function response ketika data berhasil diambil
		$this->response(array("User" => $hasil),200);
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

	// buat function POST, untuk menambahkan data
	function service_post(){
		// // panggil model M_user
		// $this->load->model("M_User","model",TRUE);

		// membuat data array untuk mengambil parameter data yang akan diisi
		$data = [
			"username" => $this->post("username"),
			"email" => $this->post("email"),
			"password" => base64_encode($this->post("password")),
			"nama_lengkap" => $this->post("nama_lengkap"),
            "no_hp" => $this->post("no_hp"),
            "level" => $this->post("level"),
			"token" => ($this->post('username'))
		];
        

		// panggil method save_data, dengan memasukkan argumen berupa array
		$hasil = $this->model->save_data($data['username'] ,$data['email'],$data['password'],$data['nama_lengkap'],$data['no_hp'],$data['level'],$data['token']);

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
		if($hasil == 1){
			$this->response(array("status"=> "Data Userberhasil dihapus"),200 );
		}
		// jika proses hapus gagal
		else{
			$this->response(array("status"=> "Data User Gagal dihapus"),200 );
		}
	}
    
}
