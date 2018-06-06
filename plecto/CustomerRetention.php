<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 09/04/2018
 * Time: 13:13
 */
include_once ('../generalUtilities/plectoFunctions.php');

/*log the request*/
//$myfile = fopen("log.txt", "a");
//fwrite($myfile, "new Lead arrived: " . print_r($_REQUEST, true) . " \n");
var_dump($_REQUEST);


$leadDate = $_GET['date'];
$leadDate = str_replace("/","-", $leadDate);
$leadDate = new DateTime($leadDate);

$cancelDate = $_GET['cancelDate'];
$cancelDate = str_replace("/","-", $cancelDate);
$cancelDate = new DateTime($cancelDate);

$leadPostDate = [
    'date' => $leadDate->format(DateTime::ISO8601), // Updated ISO8601,
    'data_source' => '87c813ef9f41418282d6e77ab982ee1d',
    'member_api_provider' => 'Lead Im CRM',
    'member_api_id' =>$_GET['supplier_id'],
    'member_name' => $_GET['lm_supplier'],
    'status' => $_GET['status'],
    'callCenterName' => $_GET['callCenterName'],
    'cancelDate' => $cancelDate->format(DateTime::ISO8601),
    'cancelType' => $_GET['cancelType'],
    'cancelTicketNumber' => $_GET['cancelTicketNumber'],
    'cancelMonthlyPremia' => $_GET['cancelMonthlyPremia'],
    'annualPremia' =>  $_GET['annualPremia'],
    'cancelInsurenceCompany' => $_GET['cancelInsurenceCompany'],
    'cancelPolicyType' => $_GET['cancelPolicyType'],
    'salesMan' => $_GET['salesMan'],
    'reference' => $_GET['recordId'],
    'recordStatus' => ""

];

$output = addLeadToPlecto($leadPostDate);


http_response_code(200);