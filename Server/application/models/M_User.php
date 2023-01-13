<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_User extends CI_Model{
    public function get_data($email=null){
        
            $this->db->from('user');
            if($email != null){
                $this->db->where('email', $email);
            }
            $query = $this->db->get()->result();
        
        return $query;
    }

    public function get_current($current){
        $this->db->select('id,nama_lengkap,level,no_hp,profile_picture, email');
        $this->db->from('user');
        $this->db->where('email',$current );
        $query = $this->db->get()->row_array();

        if(!empty($query)){
            $hasil = $query;
        }else{
            $hasil = null;
        }
        return $hasil;
    

    }

    public function checkLogin($email){
        $query = $this->db->get_where('user',['email' => $email])->row_array();
        if($query){
            $hasil = $query;
        }else{
            $hasil = 0;
        }

        return $hasil;
    }

    

    public function delete_data($email){
        $this->db->select('email');
        $this->db->from('user');
        $this->db->where("email = '$email' ");
        $query = $this->db->get()->result();
        if(count($query) == 1){
            $this->db->where("email = '$email' ");
            $this->db->delete('user');
            $hasil = 1;
        }else{
            $hasil=0;
        }
        return $hasil;
    }

    function save_data($email, $password, $namalengkap,$nohp,$level){
        // cek apakah npm ada atau tidak
        $this->db->select('email');
        $this->db->from("user");
        // teknik enkripsi
        $this->db->where('email',$email);
        // eksekusi query delete data
        $query = $this->db->get()->result();
        // jika npm tidak ditemukan
        if(count($query) == 0){
            // proses memasukkan data ke dalam array
            $data = array(
                'email' => $email,
                'password' => $password,
                'nama_lengkap' => $namalengkap,
                'no_hp' => $nohp,
                'level' => $level
            );

            // melakukan query simpan
            $this->db->insert('user',$data);
            $hasil = 1;
        }
        // jika npm ditemukan artinya data sudah ada 
        else{
            $hasil = 0;
        }

        return $hasil;
    }

    public function update_data($email,$level, $token){
        // cek apakah npm ada atau tidak
        $this->db->select('email');
        $this->db->from("user");
        // query untuk mencari data berdasarkan npm yang di encode dan juga npm biasa
        // Conditional agar menghasilkan nilai 0
        $this->db->where("email = '$token'");
        // eksekusi query delete data
        $query = $this->db->get()->result();

        if(count($query) == 1){
             // proses memasukkan data ke dalam array
             $data = array(
                'email' => $email,
                'level' => $level
            );

             // ubah data mahasiswa
             $this->db->where("email = '$token'");
             $this->db->update("user",$data);
             $hasil = 1;
        }else{
            $hasil = 0;
        }

        return $hasil;
    }

    public function add_photo($email, $nama_lengkap, $no_hp, $profile_picture=null, $about){
        $this->db->from('user');
        $this->db->where("email = '$email'");
        $query = $this->db->get()->result();

        if(count($query) == 1){
            if($profile_picture != null){
                $data = array(
                    'nama_lengkap' => $nama_lengkap,
                    'no_hp' => $no_hp,
                    'profile_picture' => $profile_picture,
                    'about' => $about
                );
            }else{
                $data = array(
                    'nama_lengkap' => $nama_lengkap,
                    'about' => $about,
                    'no_hp' => $no_hp,
                );
            }
            $this->db->where("email = '$email'");
            $this->db->update("user",$data);
            $hasil = 1;
        }else{
            $hasil = 0;
        }
        return $hasil;
    }

    function getGambarLama($email){
        $this->db->select('profile_picture');
        return $this->db->get_where('user',['email' => $email])->row_array();
    }

    function cekPassword($email){
        $this->db->select('password');
        $this->db->from('user');
        $this->db->where("email = '$email'");
        $query = $this->db->get()->row_array();
        if(!empty($query)){
            $hasil = $query;
        }else {
            $hasil = 0;
        }
        return $hasil;
    }

    function changePassword($email,$password){
        $this->db->from('user');
        $this->db->where('email',$email);
        $query = $this->db->get()->result();
        if(count($query) == 1){
            $data['password'] = $password;
            $this->db->where('email',$email);
            $this->db->update('user',$data);
            $hasil = 1;
        }else{
            $hasil = 0;
        }
        return $hasil;
    }

    function forgotpassword($email,$password,$is_active){
        $this->db->select('email');
        $this->db->from('user');
        $this->db->where('email',$email);
        $this->db->where('is_active',1);
        $query = $this->db->get()->row_array();
        if($query){
            $this->db->update('password',$password);
            $hasil = 1;
        } else {
            $hasil = 0;
        }

        return $hasil;
    }
    
    public function aktivasi_akun($is_active,$email){
        $this->db->select('email');
        $this->db->from('user');
        $this->db->where('email',$email);
        $query = $this->db->get()->result();
        if(count($query) > 0){
            $data['is_active'] = $is_active;
            $this->db->where('email',$email);
            $this->db->update('user',$data);
            $hasil = 1;
        }else{
            $hasil = 0;
        }
        return $hasil;
    }
    
}