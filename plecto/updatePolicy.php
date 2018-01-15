<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 1/7/2018
 * Time: 7:19 AM
 */
// update the policy in plecto on every change!
include_once ('../generalUtilities/functions.php');
include_once ('../generalUtilities/leadImFunctions.php');
include_once ('../generalUtilities/plectoFunctions.php');
include_once ('../generalUtilities/classes/Lead.php');



$lead = "";
$method = $_GET['method'];
if($method == "update"){
    //do update
    $acc_id = $_GET['crmAcccountNumber'];
    $recordNumber = $_GET['recordNumber'];
    /*get the Json from the CRM*/
    $leadToPopulateJson = getLeadJson($_GET['recordNumber'], $acc_id, $_GET['agentId']);
    if ($leadToPopulateJson['lead']['campaign_id'] == 17967){
        /*create lead Object from the Json data and create a post to update the BI*/
        $lead = new Lead($leadToPopulateJson);
        $leadPostDate = $lead->generateUpdatePolicyPostData();
        /*update the BI and return a result code*/
        $output = addLeadToPlecto($leadPostDate);
    }
    /*lead is not from the correct campaign*/
    http_response_code(200);
}else if ($method == "delete"){
    //ddd
} else{
    //log error
}




