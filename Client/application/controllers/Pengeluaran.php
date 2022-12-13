<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengeluaran extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $data['title'] = 'Pengeluaran';
        $data['pengeluaran'] = json_decode($this->client->simple_get(APIPENGELUARAN),true);
        // echo "<pre>";
        // var_dump($data['pemasukkan']);
        // echo "</pre>";
        $this->template->load('content/pengeluaran/vw_pengeluaran',$data);
    }
}




?>