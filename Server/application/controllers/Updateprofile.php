<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'controllers/Token.php';

class Updateprofile extends Token{
    function __construct(){
        parent::__construct();
        $this->load->model('M_User','mdl',TRUE);
    }

    function service_post(){
        if ($this->authtoken() == 0) {
            return $this->response(array("result" => 0, "error" => "Kode Signature Tidak Sesuai !"), 200);
        } else {
        
        $gambarLama = $this->mdl->getGambarLama($this->post('token'));
        
        // var_dump($gambarLama);
        // var_dump($pecah);die;

        $config['upload_path'] = './assets/images';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';

        $this->load->library('upload',$config);

        if(!$this->upload->do_upload('photo')){
            $data = [
                "nama_lengkap" => $this->post('nama_lengkap'),
                "email" => $this->post('token'),
                'no_hp' => $this->post('no_hp'),
                'about' => $this->post('about')
            ];
            $hasil = $this->mdl->add_photo($data['email'],$data['nama_lengkap'],$data['no_hp'], $data['about']);
        }else{
            $gambarLama = $this->mdl->getGambarLama($this->post('token'));
            // var_dump($gambarLama);die;
            if(isset($gambarLama['profile_picture'])){
                $pecah = explode('/', $gambarLama['profile_picture']);
                unlink("./assets/images/$pecah[7]");
            }
            $namaGambar = $this->upload->data('file_name');
            $doc_url = "http://localhost/TA-GAB2-HARIMAU/Server/assets/images/". $namaGambar;
            $data = [
                "profile_picture" => $doc_url,
                "email" => $this->post('token'),
                "nama_lengkap" => $this->post('nama_lengkap'),
                'no_hp' => $this->post('no_hp'),
                'about' => $this->post('about')
            ];
            $hasil = $this->mdl->add_photo($data['email'],$data['nama_lengkap'],$data['no_hp'],$data['about'],$data['profile_picture']);
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

    function service_delete(){
        if ($this->authtoken() == 0) {
            return $this->response(array("result" => 0, "error" => "Kode Signature Tidak Sesuai !"), 200);
        } else {

            $email = $this->delete('token');

            $gambarLama = $this->mdl->getGambarLama($email);
            // var_dump($pecah);die;
            
            $pecah = explode('/', $gambarLama['profile_picture']);
            unlink("./assets/images/$pecah[7]");

            $hasil = $this->mdl->deletePhoto($email);
            if($hasil == 1){
                $this->response([
                    'status' => true,
                    'message' => 'Foto Profil Berhasil Dihapus'
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'Foto Profil Gagal Dihapus'
                ],200);
            }




    }
}
}