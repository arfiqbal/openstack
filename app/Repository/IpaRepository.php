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
        $certPath =  public_path('include/ipa.ca.crt');
        
        $cookiePath =  storage_path('app/public/'.$cookieName);
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $this->ipa_login);
        curl_setopt($ch, CURLOPT_REFERER, $this->ipa_referer);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/x-www-form-urlencoded','Accept: application/json'));
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiePath);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiePath);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "user=arif&password=redhat");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CAINFO, $certPath);
        curl_setopt($ch, CURLOPT_CAPATH, $certPath);
        // curl_setopt($ch, CURLOPT_HEADER, 0);
        $content = curl_exec($ch);
        // curl_close($ch);
        return curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }

    public function addUser($username, $cookieName)
    {   
        $data = '{"method":"hbacrule_add","params":[["'.$username.'"],{"version":"2.231"}]}';

        $certPath =  public_path('include/ipa.ca.crt');

        $cookiePath =  storage_path('app/public/'.$cookieName);
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $this->ipa_post);
        curl_setopt($ch, CURLOPT_REFERER, $this->ipa_referer);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiePath);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiePath);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CAINFO, $certPath);
        curl_setopt($ch, CURLOPT_CAPATH, $certPath);
        // curl_setopt($ch, CURLOPT_HEADER, 0);
        $content = curl_exec($ch);
        // curl_close($ch);
        return curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }
    
}
