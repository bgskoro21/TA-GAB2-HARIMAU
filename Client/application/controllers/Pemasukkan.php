<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemasukkan extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    public function index(){
        $data['title'] = 'Pemasukkan';
        $data['pemasukkan'] = json_decode($this->client->simple_get(APIPEMASUKAN),true);
        // echo "<pre>";
        // var_dump($data['pemasukkan']);
        // echo "</pre>";
        $this->template->load('content/pemasukkan/vw_pemasukkan',$data);
    }

    public function setDelete(){
        // buat variabel json
        $json = file_get_contents("php://input");
        $hasil = json_decode($json, true);
        $delete = json_decode($this->client->simple_delete(APIPEMASUKAN.'/'.$hasil['idnya']));
        echo json_encode(array('statusnya' => $delete->status));
    }

    public function add_pemasukkan(){
        $data = [
            'waktu_transaksi' => $this->input->post('waktu_transaksi'),
            'pemasukkan' => $this->input->post('pemasukkan'),
            'perincian' => $this->input->post('perincian'),
            'user_id' => 2
        ];

        $hasil = json_decode($this->client->simple_post(APIPEMASUKAN,$data),true);
        if($hasil){
            $this->session->set_flashdata('success',$hasil['status']);
            redirect('pemasukkan');
        }else{
            $this->session->set_flashdata('success',$hasil['status']);
            redirect('pemasukkan');
        }
    }

    public function getPemasukkanById($id){
        $data = json_decode($this->client->simple_get(APIPEMASUKAN.'?id='.$id),true);
        echo json_encode($data[0]);
    }

    public function edit_pemasukkan($id){
        $data = [
            'waktu_transaksi' => $this->input->post('waktu_transaksi'),
            'pemasukkan' => $this->input->post('pemasukkan'),
            'perincian' => $this->input->post('perincian'),
            'id' => $id,
            'user_id' => 2
        ];

        $hasil = json_decode($this->client->simple_put(APIPEMASUKAN,$data),true);
        if($hasil){
            $this->session->set_flashdata('success',$hasil['status']);
            redirect('pemasukkan');
        }else{
            $this->session->set_flashdata('success',$hasil['status']);
            redirect('pemasukkan');
        }
    }
}




?>