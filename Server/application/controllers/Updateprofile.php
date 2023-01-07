<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH."libraries/Server.php";

class Updateprofile extends Server{
    function __construct(){
        parent::__construct();
        $this->load->model('M_User','mdl',TRUE);
    }

    function service_post(){
        
        $gambarLama = $this->mdl->getGambarLama($this->post('username'));
        // var_dump($gambarLama);
        // var_dump($pecah);die;

        $config['upload_path'] = './assets/images';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';

        $this->load->library('upload',$config);

        if(!$this->upload->do_upload('photo')){
            $data = [
                "nama_lengkap" => $this->post('nama_lengkap'),
                "username" => $this->post('token'),
                'no_hp' => $this->post('no_hp')
            ];
            $hasil = $this->mdl->add_photo($data['username'],$data['nama_lengkap'],$data['no_hp']);
        }else{
            $gambarLama = $this->mdl->getGambarLama($this->post('token'));
            if($gambarLama['profile_picture'] != null){
                $pecah = explode('/', $gambarLama['profile_picture']);
                unlink("./assets/images/$pecah[7]");
            }
            $namaGambar = $this->upload->data('file_name');
            $doc_url = base_url("/assets/images/". $namaGambar);
            $data = [
                "profile_picture" => $doc_url,
                "username" => $this->post('token'),
                "nama_lengkap" => $this->post('nama_lengkap'),
                'no_hp' => $this->post('no_hp'),
            ];
            $hasil = $this->mdl->add_photo($data['username'],$data['nama_lengkap'],$data['no_hp'],$data['profile_picture']);
        }

        if($hasil == 1 ){
            $this->response([
                'status' => true,
                'message' => "Data Profil Berhasil Diubah",
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Data Profil Gagal Diubah'
            ]);
        }
    }
}