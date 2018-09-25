<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 18/03/2018
 * Time: 08:50
 */

include_once "basicTicket.php";
class Loan extends basicTicket {
    protected $loanData;
    public  function  dinamicData(){
        return  $this->loanData=
            'סכום להלוואה: ' . $_POST['loanAmount'] . " \n" .
            'תקופת ההלוואה בחודשים: ' . $_POST['loanMontlyPeriod'] . " \n";

    }
}