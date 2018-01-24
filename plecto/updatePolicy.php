<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 1/7/2018
 * Time: 7:19 AM
 */
// update the policy in plecto on every change!
include_once('../generalUtilities/functions.php');
include_once('../generalUtilities/leadImFunctions.php');
include_once('../generalUtilities/plectoFunctions.php');
include_once('../generalUtilities/classes/Lead.php');


$lead = "";
$method = $_GET['method'];

$acc_id = $_GET['crmAcccountNumber'];
$recordNumber = $_GET['recordNumber'];

$leadPostDate = "";
/*get the Json from the CRM*/
$leadToPopulateJson = getLeadJson($_GET['recordNumber'], $acc_id, $_GET['agentId']);
if ($leadToPopulateJson['lead']['campaign_id'] == 17967 && $method == "update") {
    /*create lead Object from the Json data and create a post to update the BI*/
    $lead = new Lead($leadToPopulateJson);
    $leadPostDate = $lead->generateUpdatePolicyPostData();
    /*update the BI and return a result code*/
    $output = addLeadToPlecto($leadPostDate);


} else if ($method == "delete") {
    $recordDate = new DateTime();
    $recordDate->setTimestamp($_GET['date']);

    $leadPostDate = Lead::generateDeletePolicyPostData($recordNumber, $_GET['agentId'], $recordDate);
    $output = addLeadToPlecto($leadPostDate);
} else {
    /*lead is not from the correct campaign*/
    error_log("received lead from the wrong campaign " . $leadToPopulateJson['lead']['campaign_id'] . "\n");
}
http_response_code(200);



