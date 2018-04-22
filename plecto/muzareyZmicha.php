<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15/04/2018
 * Time: 10:50
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
    'data_source' => 'd9f8ce743a3540b09da09c3aa5882ea2',
    'member_api_provider' => 'leadsProxy',
    'member_api_id' =>"1234",
    'member_name' => 'Leads Proxy',
    'productName' => $_GET['channel_name'],
    'sellerName' => $_GET['sellerName'],
    'callCenterName' => $_GET['callCenterName'],
    'paymentSum' => $_GET['paymentSum'],
    'mislakaPaymentCount' => $_GET['mislakaPaymentCount'],
    'loanAmount' => $_GET['loanAmount'],
    'loanMontlyPeriod' => $_GET['loanMontlyPeriod'],
    'pedionSum' => $_GET['pedionSum'],
    'policyType' => $_GET['policyType'],
    'pullType' => $_GET['pullType'],
    'referenceType' => $_GET['referenceType'],
    'ticketStatus' => $_GET['ticketStatus'],
    'reference' => $_GET['recordId'],

];

$output = addLeadToPlecto($leadPostDate);


http_response_code(200);