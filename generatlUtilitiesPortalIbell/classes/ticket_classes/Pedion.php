<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 18/03/2018
 * Time: 08:50
 */

include_once "basicTicket.php";
class Pedion extends basicTicket {
    protected $pedionData;
    public  function  dinamicData($programDetails=null){
        return  $this->pedionData=
            'מעמד הקופה: ' . $_POST['programStatus'] . " \n".
            'סכום לפדיון: ' . $_POST['pedionSum'] . " \n".
            'האם הלקוח מודע לתשלום מס 35%?: ' . $_POST['taxAware'] . " \n";

    }}