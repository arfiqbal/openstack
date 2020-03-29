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

    public function curlCommon($cookiePath,$certPath,$data){
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
        $content = curl_exec($ch);
        //  curl_close($ch);
        return curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }

    protected function login($cookieName)
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

    public function addUser($username,$firstname,$lastname,$password, $cookieName)
    {   
       
        $data = '{"method":"user_add","params":[["'.$username.'"],{"givenname":"'.$firstname.'","sn":"'.$lastname.'","'.$password.'":"redhat","version":"2.231"}]}';
        $certPath =  public_path('include/ipa.ca.crt');
        $cookiePath =  storage_path('app/public/'.$cookieName);
        $this->login($cookieName);
        $this->curlCommon($cookiePath,$certPath,$data);
    }

    

    public function addHbacRule($rule, $cookieName)
    {   
        $data = '{"method":"hbacrule_add","params":[["'.$rule.'"],{"version":"2.231"}]}';
        $certPath =  public_path('include/ipa.ca.crt');
        $cookiePath =  storage_path('app/public/'.$cookieName);
        $this->curlCommon($cookiePath,$certPath,$data);
    }


    protected function addHbacRuleUser($rule,$username, $cookieName)
    {   
        $data = '{"method":"hbacrule_add_user","params":[["'.$rule.'"],{"user":["'.$username.'"],"version":"2.231"}]}';
        $certPath =  public_path('include/ipa.ca.crt');
        $cookiePath =  storage_path('app/public/'.$cookieName);
        $this->curlCommon($cookiePath,$certPath,$data);
    }

    protected function addHbacRuleHost($rule,$hostname, $cookieName)
    {   
        $data = '{"method":"hbacrule_add_host","params":[["'.$rule.'"],{"host":["'.$hostname.'"],"version":"2.231"}]}';
        $certPath =  public_path('include/ipa.ca.crt');
        $cookiePath =  storage_path('app/public/'.$cookieName);
        $this->curlCommon($cookiePath,$certPath,$data);
    }

    protected function addHbacRuleService($rule, $cookieName)
    {   
        $data = '{"method":"hbacrule_add_service","params":[["'.$rule.'"],{"hbacsvc":["sshd"],"version":"2.231"}]}';
        $certPath =  public_path('include/ipa.ca.crt');
        $cookiePath =  storage_path('app/public/'.$cookieName);
        $this->curlCommon($cookiePath,$certPath,$data);
    }
    
}
