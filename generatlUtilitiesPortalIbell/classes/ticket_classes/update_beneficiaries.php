<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 20/03/2018
 * Time: 15:19
 */


include_once "basicTicket.php";
class update_beneficiaries extends basicTicket {
    public  function  dinamicData($programDetails=null){
        return  $this->updateDetailsData=  'פרטי המוטבים:'. " \n". $programDetails. " \n";
    }}