<?php

class M_UserToken extends CI_Model {

    public function add_token($email,$token,$date_created){
        $data = [
            'email' => $email,
            'token' => $token,
            'date_created' => $date_created
        ];
        $query = $this->db->insert('user_token',$data);
        if($query) {
            $hasil = 1;
        }else {
            $hasil = 0;
        }
        return $hasil;
    }
}
