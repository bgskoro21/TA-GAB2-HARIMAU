<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Mlaporan extends CI_Model {

    public function getSaldo(){
        $this->db->select('SUM(pemasukan) - SUM(pengeluaran) AS Saldo');
        $this->db->from('tbl_transaksi');
        $query = $this->db->get()->result();
        return $query;
    }
}