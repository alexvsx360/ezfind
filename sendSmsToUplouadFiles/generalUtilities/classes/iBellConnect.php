<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13/06/2018
 * Time: 11:34
 */

class iBellConnect
{
    private $subdomain ;
    private $username ;
    private $token;
    public function __construct(){
        $this -> subdomain ="ezfind";
        $this -> username = "yaki@ezfind.co.il";
        $this -> token = "Bdt7m6GAv0VQghQ6CRr81nhCMXcjq2fIfZHwMjMW"; // replace this with your token
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