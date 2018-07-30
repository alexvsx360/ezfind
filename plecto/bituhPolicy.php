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

$saleDate = $_GET['saleDate'];
$saleDate = str_replace("/","-", $saleDate);
$saleDate = new DateTime($saleDate . "09:00:00");

$leadDate = $_GET['leadDate'];
$leadDate = str_replace("/","-", $leadDate);
$leadDate = new DateTime($leadDate);

$productionDate = "";
if ($_GET['productionDate'] != ""){
    $productionDate = $_GET['productionDate'];
    $productionDate = str_replace("/","-", $productionDate);
    $productionDate = new DateTime($productionDate);
}

$leadPostDate = [
    'date' => $leadDate->format(DateTime::ISO8601), // Updated ISO8601,
    'data_source' => '610a2983898a41d299700b16cebd0987',
    'member_api_provider' => 'Lead Im CRM',
    'member_api_id' => $_GET['suplaierId'],
    'member_name' => "supplier_" . $_GET['suplaierId'],
    'callCenterName' => $_GET['callCenterName'],
    'sellingChannel' => $_GET['sellingChannel'],
    'saleDate' => $saleDate->format(DateTime::ISO8601), // Updated ISO8601,
    'sellerName' => $_GET['sellerName'],
    'promoterName' => $_GET['promoterName'],
    'insuranceType' => $_GET['insuranceType'],
    'insuranceCompany' => $_GET['insuranceCompany'],
    'monthlyPremia' => $_GET['monthlyPremia'],
    'anualPremia' => $_GET['anualPremia'],
    'hitum' => $_GET['hitum'],
    'productionStatus' => $_GET['productionStatus'],
    'pendingStatus' => (isset($_GET["pendingStatus"]) ? $_GET["pendingStatus"] : ""),
    'productionDate' => ($productionDate instanceof DateTime ? $productionDate->format(DateTime::ISO8601) : "" ),
    'actualPremia' => $_GET['actualPremia'],
    'origLeadCampaignName' => $_GET['origLeadCampaignName'],
    'origLeadSupplaier' => $_GET['origLeadSupplaier'],
    'reference' => $_GET['recordId'],

];

$output = addLeadToPlecto($leadPostDate);


http_response_code(200);