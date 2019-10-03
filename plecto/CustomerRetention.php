<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 09/04/2018
 * Time: 13:13
 */
include_once ('../generalUtilities/plectoFunctions.php');

//error_log($_GET);
/*log the request*/
//$myfile = fopen("log.txt", "a");
//fwrite($myfile, "new Lead arrived: " . print_r($_REQUEST, true) . " \n");

var_dump($_REQUEST);
//To get the url values that sent in  same name (a multivalued field in CRM), do the following:

$query  = explode('&', $_SERVER['QUERY_STRING']);
$params = array();
foreach( $query as $param )
{
    list($name, $value) = explode('=', $param, 2);
    $params[urldecode($name)][] = urldecode($value);
}



$leadDate = $_GET['date'];
$leadDate = str_replace("/","-", $leadDate);
$leadDate = new DateTime($leadDate);

$cancelDate = $_GET['cancelDate'];
$cancelDate = str_replace("/","-", $cancelDate);
$cancelDate = new DateTime($cancelDate);

$lastRoutingDate = $_GET['lastRoutingDate'];
$lastRoutingDate = str_replace("/","-", $lastRoutingDate);
$lastRoutingDate = new DateTime($lastRoutingDate);

$leadPostDate = [
    'date' => $leadDate->format(DateTime::ISO8601), // Updated ISO8601,
    'data_source' => '87c813ef9f41418282d6e77ab982ee1d',
    'member_api_provider' => 'Lead Im CRM',
    'member_api_id' => ($_GET['supplier_id']== ""?"15348":$_GET['supplier_id']),
    'member_name' => ($_GET['lm_supplier']== "" ? "בקשה לביטול איש מכירות עזב" : $_GET['lm_supplier']),
    'status' => $_GET['status'],
    'callCenterName' => $_GET['callCenterName'],
    'cancelDate' => $cancelDate->format(DateTime::ISO8601),
    'cancelType' => implode(";",$params['cancelType']),
    'cancelTicketNumber' => $_GET['cancelTicketNumber'],
    'cancelMonthlyPremia' => $_GET['cancelMonthlyPremia'],
    'annualPremia' =>  $_GET['annualPremia'],
    'cancelInsurenceCompany' => $_GET['cancelInsurenceCompany'],
    'cancelPolicyType' => $_GET['cancelPolicyType'],
    'salesMan' => $_GET['salesMan'],
    'reference' => $_GET['recordId'],
    'payWith' => $_GET['payWith'],
    'sortingCancellLetters'=> $_GET["sortingCancellLetters"],
    'recordStatus' => "",
    'cancelTypeDetails' => $_GET['cancelTypeDetails'],
    'moveToMokedShimur' => $_GET['moveToMokedShimur'],
    'saveInPast' => $_GET['saveInPast'],
    'handlingShimurAgent' => $_GET['handlingShimurAgent'],//נציג שימור מטפל
    'lastRoutingDate' => $lastRoutingDate->format(DateTime::ISO8601),


];

$output = addLeadToPlecto($leadPostDate);


http_response_code(200);