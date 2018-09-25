<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 25/03/2018
 * Time: 11:07
 */

class basicTicket {

protected  $headerTicket;
protected  $footerTicket;

    public function __constructor(){

    }

public  function getHeader($customerCount){

    return $this->headerTicket=
    'מוקד: ' . $_POST['callCenterName'] . " \n" .
    'איש מכירות: ' . $_POST['userName'] . " \n" .
    'פעולה לביצוע: ' . $_POST['operationType'] . " \n" .
    'הגוף המנהל: ' . $_POST['insuranceCompany'] . " \n" .
    'סוג הקופה: ' . $_POST['pedionType'] . " \n" .
    'מספר הקופה: ' . $_POST['programNumber'] . " \n" ;
}

    public  function getFooter(){
      return  $this->footerTicket=
          'קישור לרשומת הליד המקורי (ממוקד המכירות) : ' . 'https://crm.ibell.co.il/a/3328/leads/' . $_POST['recordNumber'] . " \n\n".
          'הערות להצעה: ' . $_POST['insuranceComment']. " \n" ;
}
   }