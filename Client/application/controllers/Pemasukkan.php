<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemasukkan extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $data['title'] = 'Pemasukkan';
        $data['pemasukkan'] = json_decode($this->client->simple_get(APIPEMASUKAN),true);
        // echo "<pre>";
        // var_dump($data['pemasukkan']);
        // echo "</pre>";
        $this->template->load('content/pemasukkan/vw_pemasukkan',$data);
    }
}




?>