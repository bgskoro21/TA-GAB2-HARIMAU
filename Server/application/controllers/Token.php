<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . "libraries/Server.php";

require APPPATH . 'libraries/JWT.php';
require APPPATH . 'libraries/ExpiredException.php';
require APPPATH . 'libraries/BeforeValidException.php';
require APPPATH . 'libraries/SignatureInvalidException.php';
require APPPATH . 'libraries/JWK.php';

use \Firebase\JWT\JWT;

class Token extends Server
{
    var $privateKey = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
-----END RSA PRIVATE KEY-----
EOD;

var $publicKey = <<<EOD
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC8kGa1pSjbSYZVebtTRBLxBz5H
4i2p/llLCrEeQhta5kaQu/RnvuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t
0tyazyZ8JXw+KgXTxldMPEL95+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4
ehde/zUxo6UvS7UrBQIDAQAB
-----END PUBLIC KEY-----
EOD;
    // konfigurasi token
    function configToken()
    {
        // konfigurasi waktu expired
        $config['exp'] = 3630; //detik
        // konfiurasi key jwt (dalam format string)
        $config['key'] = 'key-kas';
        return $config;
    }
    // fungsi untuk auth token(pada saat dibaca)
    public function authtoken(){        
        $authHeader = $this->input->request_headers()['Authorization'];  
        $arr = explode(" ", $authHeader); 
        $token = $arr[1];        
        if ($token){
            // jika token valid
            try{
                // baca Isi token
                // $decoded = JWT::decode($token, $this->configToken()['key'], array('HS256'));
                $decoded = JWT::decode($token, $this->publicKey, array('RS256'));          
                if ($decoded){
                    return 1;
                }
                // jika token tidak valid
            } catch (\Exception $e) {                
                return 0;
                
            }
        }       
    }


    //buat fungsi "POST"
    function service_post()
    {
        date_default_timezone_set("Asia/Jakarta");        
        $exp = $this->configToken()['exp']+time();
        $token = array(           
            "exp" => $exp,                          
        );

        // $jwt = JWT::encode($token, $this->configToken()['key'],'HS256');
        $jwt = JWT::encode($token, $this->privateKey,'RS256');
        
            
        $data = array('token' => $jwt, 'exp' => date("d/m/Y H:i",$exp));
        $this->response($data, 200);
    }    
}
