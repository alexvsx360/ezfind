<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 19/03/2018
 * Time: 10:42
 */


include_once "basicTicket.php";
class update_details extends basicTicket {
    protected $updateDetailsData;
    public  function getHeader($customerCount){

        return $this->headerTicket=
            'מוקד: ' . $_POST['callCenterName'] . " \n" .
            'איש מכירות: ' . $_POST['userName'] . " \n" .
            'פעולה לביצוע: ' . $_POST['operationType'] . " \n" ;
    }
    public  function  dinamicData($programDetails=null){
        return  $this->updateDetailsData=  'פרטי הקופות:'. " \n". $programDetails. " \n";

    }}
