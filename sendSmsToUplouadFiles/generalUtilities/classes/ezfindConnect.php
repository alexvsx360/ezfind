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
        $this -> token = "r0sQ2m9H37u6OOnmYagEM08cW11xKasCbNZspYaF"; // replace this with your token
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