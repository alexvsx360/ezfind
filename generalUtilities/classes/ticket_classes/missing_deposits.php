<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 21/03/2018
 * Time: 09:59
 */



include_once "basicTicket.php";
class missing_deposits extends basicTicket {
    protected $missing_depositspedionData;
    public  function  dinamicData(){
        return  $this->missing_depositspedionData=
            'סוג הפניה:'.$_POST['reference_type']."\n".
            'שם המעסיק:'.$_POST['employer_name']."\n";

    }


}