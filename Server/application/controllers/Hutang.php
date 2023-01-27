<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'controllers/Token.php';

class Hutang extends Token {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model("M_Hutang","mdl",TRUE);
	}

	function service_get(){
        if ($this->authtoken() == 0) {
            return $this->response(array("result" => 0, "error" => "Kode Signature Tidak Sesuai !"), 200);
        } else {
        $id = $this->get('id');
        
        $hasil = $this->mdl->get_hutang($id);


        if($id != null){
            $hasil = $this->mdl->get_hutang($id);
        }else{
            $hasil = $this->mdl->get_hutang();
        }


        if($hasil > 0){
            $this->response([
                'status' => true,
                'message' => 'Berhasil',
                'hutang' => $hasil
        ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Gagal',
            ]);
        }
      }
    }

    function service_delete(){
        if ($this->authtoken() == 0) {
            return $this->response(array("result" => 0, "error" => "Kode Signature Tidak Sesuai !"), 200);
        } else {
  
        $id = $this->delete('id');
        $hasil = $this->mdl->delete_hutang($id);

        if($hasil == 1){
            $this->response([
                'status' => true,
                'message' => 'Data hutang Berhasil Dihapus!',
        ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Data hutang Gagal dihapus!',
            ]);
        }
     }
    }


    //   private function _sendEmail($type){
	// 	$config = [	
    //         'protocol' => 'smtp',
    //         'smtp_host' => 'ssl://smtp.googlemail.com',
    //         'smtp_user' => 'mahardika_akbar_wijaya@teknokrat.ac.id',
    //         'smtp_pass' => '19312020',
    //         'smtp_port' => 465,
    //         'mailtype' => 'html',
    //         'charset' => 'utf-8',
    //         'newline' => "\r\n"
    //     ];

	// 	$this->load->library('email',$config);
	// 	$this->email->initialize($config);
	// 	$this->email->from('mahardika_akbar_wijaya@teknokrat.ac.id','Eyzel');
	// 	$this->email->to($this->post('email'));
	// 	if($type == 'reminder'){
	// 		$this->email->subject('Reminder Hutang');
	// 		$this->email->message('Hutang dengan : ?email='.$this->post('email').'&tgl_transaksi='.$this->post('tgl_transaksi').'&tgl_transaksi='.$this->post('tgl_tempo').'&tgl_transaksi='.$this->post('hutang').'">Reminder</a>');
	// 	}
	// 	if($this->email->send()){
	// 		return true;
	// 	}else{
	// 		echo $this->email->print_debugger();
	// 	}
	// }

      function service_post(){
        if ($this->authtoken() == 0) {
            return $this->response(array("result" => 0, "error" => "Kode Signature Tidak Sesuai !"), 200);
        } else {
        $data = [
            "nama_pelanggan" => $this->post('nama_pelanggan'),
            'kode_hutang' => $this->post('kode_hutang'),
            "tgl_transaksi" => $this->post('tgl_transaksi'),
            "tgl_tempo" => $this->post('tgl_tempo'),
            "hutang" => $this->post('hutang'),
            'user_id' => $this->post('user_id'),
            'no_hp' => $this->post('no_hp'),
            'perincian' => $this->post('perincian'),
            'token' => $this->post('kode_hutang')
        ];

        $hasil = $this->mdl->add_hutang($data['nama_pelanggan'],$data['kode_hutang'], $data['tgl_transaksi'], $data['tgl_tempo'],$data['hutang'], $data['user_id'], $data['no_hp'], $data['perincian'],$data['token']);

        // $this->_sendEmail('reminder');
        if($hasil == 1){
            $this->response([
                'status' => true,
                'message' => 'Data hutang Berhasil Ditambahkan!',
        ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Data hutang Gagal Ditambahkan!',
            ]);
         }
        }
  }

  function service_put(){
    if ($this->authtoken() == 0) {
        return $this->response(array("result" => 0, "error" => "Kode Signature Tidak Sesuai !"), 200);
    } else {
    $data = [
        "nama_pelanggan" => $this->put('nama_pelanggan'),
        "tgl_transaksi" => $this->put('tgl_transaksi'),
        "tgl_tempo" => $this->put('tgl_tempo'),
        "hutang" => $this->put('hutang'),
        "id" => $this->put('id'),
        'user_id' => $this->put('user_id'),
        'no_hp' => $this->put('no_hp'),
        'perincian' => $this->put('perincian'),
        'kode_hutang' => $this->put('kode_hutang'),
        'token' => $this->put('token')
    ];

    $hasil = $this->mdl->update_hutang($data['nama_pelanggan'],$data['tgl_transaksi'],$data['tgl_tempo'],$data['hutang'],$data['id'],$data['user_id'],$data['no_hp'],$data['perincian'], $data['kode_hutang'], $data['token']);

    if($hasil==1){
        $this->response([
            'status' => true,
            'message' => 'Data hutang Berhasil Diubah!',
    ],200);
    }else{
        $this->response([
            'status' => false,
            'message' => 'Data hutang Gagal Diubah!',
        ]);
        }
    }
}

    
}