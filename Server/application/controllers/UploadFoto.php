<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH."libraries/Server.php";

class UploadFoto extends Server{
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

        if(!$this->upload->do_upload('IMAGE')){
            $this->response([
                "status" => 'Upload Gagal'
            ],200);
        }else{
            if($gambarLama != null){
                $pecah = explode('/', $gambarLama[0]['IMAGE']);
                if($pecah[0] != ''){
                    // var_dump($pecah);
                    unlink("./assets/images/$pecah[7]");
                }
               
            }
            $namaGambar = $this->upload->data('file_name');
            $doc_url = base_url("/assets/images/". $namaGambar);
        }

        $data = [
            "IMAGE" => $doc_url,
            "username" => $this->post('username')
        ];

        $hasil = $this->mdl->add_photo($data['username'],$data['IMAGE']);

        if($hasil == 1 ){
            $this->response([
                'status' => true,
                'message' => "Foto Profil Diubah",
            ],200);
        }
    }
}