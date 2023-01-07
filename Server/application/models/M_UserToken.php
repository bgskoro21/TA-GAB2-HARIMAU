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
    
    public function get_Token($token=null){
        $this->db->from('user_token');
        $this->db->where('token',$token);
        $query = $this->db->get()->row_array();
        if($query) {
            $hasil = $query;
        }else {
            $hasil = null;
        }
        return $hasil;
    }

    public function del_email($email){
        $this->db->select('email');
        $this->db->from('user_token');
        $this->db->where('email',$email);
        $query = $this->db->get()->result();
        if(count($query) > 0){
            $this->db->where('email',$email);
            $this->db->delete('user_token');
            $hasil = 1;
        }else{
            $hasil = 0;
        }
        return $hasil;
    }

}
