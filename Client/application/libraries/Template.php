<?php
defined('BASEPATH') or exit ('Not Allowed Direct Access');

class Template{
    var $ci;

    function __construct()
    {
        $this->ci =& get_instance();
    }

    public function load($body_view=null,$data=null){
        // memasukkan view yang akan dirender ke dalam file template dan mengembalikkannya sebagai string
        $body= $this->ci->load->view($body_view,$data,true);
        // membuat variabel yang digunakan untuk menunjukkan view yang dikirim akan dimasukkan ke mana
        $tpl_view = '_partials/template';
        // menampung body pada argumen data
        $data["body"] = $body;
        // menampilkan template view yang serta mengirimkan data yang berisi body tersebut sehingga dapat dipanggil di template
        $this->ci->load->view($tpl_view,$data);
    }
}