<?php

namespace App\Repository;

use Illuminate\Support\Collection;



class IpaRepository
{
    // public function __construct(){

    // }
    protected $ipa_referer = 'https://inidmor1.cloud.vssi.com/ipa';
    protected $ipa_login = 'https://inidmor1.cloud.vssi.com/ipa/session/login_password';
    protected $ipa_post = "https://inidmor1.cloud.vssi.com/ipa/session/json";

    protected function credential(){
        $data = array(
            'username' => 'arif',
            'password' => env('LDAP_PASSWORD')
        );
        return json_encode(array($data));
    }

    public function login($cookieName)
    {
        $certPath =  storage_path('app/public/ipa.ca.crt');
        $cookiePath =  storage_path('app/public/'.$cookieName);
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $this->ipa_login);
        curl_setopt($ch, CURLOPT_REFERER, $this->ipa_referer);
        // curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/x-www-form-urlencoded','Accept: application/json'));
        // curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiePath);
        // curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiePath);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_VERBOSE, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $this->credential());
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_CAINFO, $certPath);
        // curl_setopt($ch, CURLOPT_CAPATH, $certPath);
        
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }
    
}
