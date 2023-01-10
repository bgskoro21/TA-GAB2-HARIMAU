<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_User extends CI_Model{
    public function get_data($username=null){
        
            $this->db->from('user');
            if($username != null){
                $this->db->where('username', $username);
            }
            $query = $this->db->get()->result();
        
        return $query;
    }

    public function get_current($current){
        $this->db->select('id,nama_lengkap,level,no_hp,profile_picture,username,email');
        $this->db->from('user');
        $this->db->where('username',$current );
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

    public function login($username,$password ){
        $this->db->select('nama_lengkap,level,profile_picture,username');
        $this->db->from('user');
        $this->db->where("username = '$username' AND password = '$password' ");
        $query = $this->db->get()->row_array();

        if(!empty($query)){
            $hasil = $query;
        }else{
            $hasil = null;
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

    function save_data($username, $email, $password, $namalengkap,$nohp,$level){
        // cek apakah npm ada atau tidak
        $this->db->select('username');
        $this->db->from("user");
        // teknik enkripsi
        $this->db->where('username',$username);
        // eksekusi query delete data
        $query = $this->db->get()->result();
        // jika npm tidak ditemukan
        if(count($query) == 0){
            // proses memasukkan data ke dalam array
            $data = array(
                'username' => $username,
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

    public function update_data($username, $email, $password, $namalengkap,$nohp,$level, $token){
        // cek apakah npm ada atau tidak
        $this->db->select('username');
        $this->db->from("user");
        // query untuk mencari data berdasarkan npm yang di encode dan juga npm biasa
        // Conditional agar menghasilkan nilai 0
        $this->db->where("username = '$token'");
        // eksekusi query delete data
        $query = $this->db->get()->result();

        if(count($query) == 1){
             // proses memasukkan data ke dalam array
             $data = array(
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'nama_lengkap' => $namalengkap,
                'no_hp' => $nohp,
                'level' => $level
            );

             // ubah data mahasiswa
             $this->db->where("username = '$token'");
             $this->db->update("user",$data);
             $hasil = 1;
        }else{
            $hasil = 0;
        }

        return $hasil;
    }

    public function add_photo($username, $nama_lengkap, $no_hp, $profile_picture=null){
        $this->db->from('user');
        $this->db->where("username = '$username'");
        $query = $this->db->get()->result();

        if(count($query) == 1){
            if($profile_picture != null){
                $data = array(
                    'nama_lengkap' => $nama_lengkap,
                    'no_hp' => $no_hp,
                    'profile_picture' => $profile_picture
                );
            }else{
                $data = array(
                    'nama_lengkap' => $nama_lengkap,
                    'no_hp' => $no_hp,
                );
            }
            $this->db->where("username = '$username'");
            $this->db->update("user",$data);
            $hasil = 1;
        }else{
            $hasil = 0;
        }
        return $hasil;
    }

    function getGambarLama($username){
        $this->db->select('profile_picture');
        return $this->db->get_where('user',['username' => $username])->row_array();
    }

    function cekPassword($username, $password){
        $this->db->select('password');
        $this->db->from('user');
        $this->db->where("username = '$username' AND password = '$password' ");
        $query = $this->db->get()->row_array();
        if(!empty($query)){
            $hasil = 1;
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
        return $query;
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