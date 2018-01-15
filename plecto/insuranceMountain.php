<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 1/11/2018
 * Time: 9:54 AM
 */

include_once ('../generalUtilities/plectoFunctions.php');

/*log the request*/
//$myfile = fopen("log.txt", "a");
//fwrite($myfile, "new Lead arrived: " . print_r($_REQUEST, true) . " \n");
var_dump($_REQUEST);

$insuranceStartDate = $_GET['insuranceStartDate'];
$insuranceStartDate = str_replace("/","-", $insuranceStartDate);
$insuranceStartDate = new DateTime($insuranceStartDate);

$insuranceEndDate = $_GET['insuranceEndDate'];
$insuranceEndDate = str_replace("/","-", $insuranceEndDate);
$insuranceEndDate = new DateTime($insuranceEndDate);

$leadDate = $_GET['date'];
$leadDate = str_replace("/","-", $leadDate);
$leadDate = new DateTime($leadDate);

$leadPostDate = [
    'date' => $leadDate->format(DateTime::ISO8601), // Updated ISO8601,
    'data_source' => '24f7c175723d456ebee7279f575bcd82',
    'member_api_provider' => 'leadsProxy',
    'member_api_id' => '1234',
    'member_name' => 'Leads Proxy',
    'customerId' => $_GET['customerId'],
    'insuranceCategory' => $_GET['insuranceCategory'],
    'mainBrunch' => $_GET['mainBrunch'],
    'secondaryBrunch' => $_GET['secondaryBrunch'],
    'productType' => $_GET['productType'],
    'insuranceCompany' => $_GET['insuranceCompany'],
    'premia' => $_GET['premia'],
    'premiaType' => $_GET['premiaType'],
    'policyNumber' => $_GET['policyNumber'],
    'programType' => $_GET['programType'],
    'insuranceStartDate' => $insuranceStartDate->format(DateTime::ISO8601),
    'insuranceEndDate' => $insuranceEndDate->format(DateTime::ISO8601),
    'reference' => $_GET['recordId'],
    'renewMonth' => $insuranceStartDate->format("M")
];

$output = addLeadToPlecto($leadPostDate);


http_response_code(200);
