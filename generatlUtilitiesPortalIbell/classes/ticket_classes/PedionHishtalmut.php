<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 18/03/2018
 * Time: 11:19
 */

include_once "basicTicket.php";
class PedionHishtalmut extends basicTicket {
    protected $pedionHishtalmutData;
    public  function  dinamicData(){
      return  $this->pedionHishtalmutData=
          'מעמד הקופה: ' . $_POST['programStatus'] . " \n".
          'סכום לפדיון: ' . $_POST['pedionAmount'] . " \n".
            'סוג המשיכה: ' . $_POST['pedionType'] . " \n" ;

    }


}