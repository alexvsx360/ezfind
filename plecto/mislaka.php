<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/24/2017
 * Time: 11:29 AM
 */
include_once ('../generalUtilities/plectoFunctions.php');

/*log the request*/
//$myfile = fopen("log.txt", "a");
//fwrite($myfile, "new Lead arrived: " . print_r($_REQUEST, true) . " \n");
var_dump($_REQUEST);


$leadDate = $_GET['date'];
$leadDate = str_replace("/","-", $leadDate);
$leadDate = new DateTime($leadDate);

$leadPostDate = [
    'date' => $leadDate->format(DateTime::ISO8601), // Updated ISO8601,
    'data_source' => 'c19a89078ccf4c89b5603277b54eb7c7',
    'member_api_provider' => 'Lead Im CRM',
    'member_api_id' => $_GET['suplaierId'],
    'member_name' =>  $_GET['suplaierName'],
    'callCenterName' => $_GET['callCenterName'],
    'sellingChannl' => $_GET['sellingChannl'],
    'sellerName' => $_GET['sellerName'],
    'paymentSum' => $_GET['paymentSum'],
    'paymentCount' => $_GET['paymentCount'],
    'customerCount' => $_GET['customerCount'],
    'CustomerType' => $_GET['CustomerType'],
    'reference' => $_GET['recordId'],

];

$output = addLeadToPlecto($leadPostDate);


http_response_code(200);