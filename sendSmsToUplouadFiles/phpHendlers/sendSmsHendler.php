<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16/05/2018
 * Time: 23:52
 */

error_reporting(E_ALL);
ini_set("display_errors","On");
include_once ('../generalUtilities/classes/sendSmsByLeadImFunctions.php');
//include_once ('../generalUtilities/leadImFunctions.php');
//var_dump($_REQUEST);
$req_dump = print_r($_REQUEST, TRUE);
$fp = fopen('request.log', 'a');
fwrite($fp, $req_dump ."\n");
if(!empty($_POST['sourceInformation'])&!empty($_POST['ticketId'])&!empty($_POST['campaignId'])&!empty($_POST['leadId'])){
    $sourceInformation = $_POST['sourceInformation'];
    $ticketId = $_POST['ticketId'];
    $campaignId = $_POST['campaignId'];
    $leadId = $_POST['leadId'];
    $crmAccountNumber = $_POST['crmAccountNumber'];
    $texToCustomer = $_POST['texToCustomer'];
    switch ($sourceInformation){
        case "crm":
            $texToCustomer = str_replace(' ', '_',  $texToCustomer);
            $updateFieldsKeyValue = [108912 => $texToCustomer];
            $leadImUpdateLead =leadImUpdateLead($crmAccountNumber, $leadId , $updateFieldsKeyValue, true, $status = null);
            if($leadImUpdateLead == "OK" ) {
                sleep(2);
                return new sendSmsByLeadImFunctions($ticketId, $campaignId, $leadId, $crmAccountNumber);
                break;
            }
    }
}
