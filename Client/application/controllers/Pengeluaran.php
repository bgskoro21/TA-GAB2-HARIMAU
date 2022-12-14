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

    public function setDelete(){
        // buat variabel json
        $json = file_get_contents("php://input");
        $hasil = json_decode($json, true);
        $delete = json_decode($this->client->simple_delete(APIPENGELUARAN.'/'.$hasil['idnya']));

        echo json_encode(array('statusnya' => $delete->status));
    }

    public function add_pengeluaran(){
        $data = [
            'waktu_transaksi' => $this->input->post('waktu_transaksi'),
            'pengeluaran' => $this->input->post('pengeluaran'),
            'perincian' => $this->input->post('perincian'),
            'user_id' => 2
        ];

        $hasil = json_decode($this->client->simple_post(APIPENGELUARAN,$data),true);
        if($hasil){
            $this->session->set_flashdata('success',$hasil['status']);
            redirect('pengeluaran');
        }else{
            // var_dump($hasil['status']);
            $this->session->set_flashdata('success',$hasil['status']);
            redirect('pengeluaran');
        }
    }

    public function getPengeluaranById($id){
        $data = json_decode($this->client->simple_get(APIPENGELUARAN.'?id='.$id),true);
        echo json_encode($data[0]);
    }

    public function edit_pengeluaran($id){
        $data = [
            'waktu_transaksi' => $this->input->post('waktu_transaksi'),
            'pengeluaran' => $this->input->post('pengeluaran'),
            'perincian' => $this->input->post('perincian'),
            'id' => $id,
            'user_id' => 2
        ];

        $hasil = json_decode($this->client->simple_put(APIPENGELUARAN,$data),true);
        if($hasil){
            $this->session->set_flashdata('success',$hasil['status']);
            redirect('pengeluaran');
        }else{
            $this->session->set_flashdata('success',$hasil['status']);
            redirect('pengeluaran');
        }
    }
}




?>