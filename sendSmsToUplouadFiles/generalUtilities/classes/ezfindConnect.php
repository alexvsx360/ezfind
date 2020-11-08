<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/05/2018
 * Time: 10:44
 */

class ezfindConnect
{
   private $subdomain ;
   private $username ;
   private $token;
    public function __construct(){
        $this -> subdomain ="ezfind-sherut";
        $this -> username = "yaki@tgeg.co.il";
        $this -> token = "WP5x5E4l3ZCVcaiDqFSJIQouL8WY0AdcX2Rpd7SH"; // replace this with your token
    }
    public function getSubDomain(){
        return $this->subdomain;
    }
    public function getUserName(){
        return $this->username;
    }
    public function getToken(){
        return $this->token;
    }

}
