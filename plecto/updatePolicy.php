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
/*include_once('../generalUtilities/classes/Lead.php');
include_once('../generalUtilities/classes/LeadToCancel.php');
include_once('../generalUtilities/classes/BaseLead.php');
include_once('../generalUtilities/classes/LeadPolicy.php');
include_once('../generalUtilities/classes/LeadMislakaPensyonit.php');
include_once('../generalUtilities/classes/LeadFactory.php');
include_once ('../generalUtilities/classes/LeadLoans.php');
include_once('../generalUtilities/classes/BaseLeadMuzareyZmicha.php');
include_once ('../generalUtilities/classes/LeadPedion.php');
include_once ('../generalUtilities/classes/LeadPedionHishtalmut.php');
include_once ('../generalUtilities/classes/LeadPigurim.php');
include_once ('../generalUtilities/classes/LeadEdKunPratim.php');
include_once ('../generalUtilities/classes/LeadEdcunMutavim.php');*/


$plectoDataSourceMapping = array(
    '18491' => array( //campaigan: sherut lakochot
        '18600' => '87c813ef9f41418282d6e77ab982ee1d',//channelב bitulim
    ),
    '17967' => array( //campaigan: policy
        '18003' => ['610a2983898a41d299700b16cebd0987','367455c4622e4f22bd1764ddef85e224'],//channel: poloiceot prat(ydani)
        '17968' => ['610a2983898a41d299700b16cebd0987','367455c4622e4f22bd1764ddef85e224'],//channel: poloiceot prat
        //when policy from masad yashan delete it only from dataSource shimurim
        '19582' => '367455c4622e4f22bd1764ddef85e224'//channel:poloiceot prat masad yashan
    ),
    '18679' => array( //campaigan: muzarey zmicha
        '18681' => 'c19a89078ccf4c89b5603277b54eb7c7', //channel: mislaka pensyonit
        //all the following products are sent to the same data source in plecto
        '19904' => 'd9f8ce743a3540b09da09c3aa5882ea2', //channel: loans
        '19942' => 'd9f8ce743a3540b09da09c3aa5882ea2', // pigurim/hafkadot chaserot
        '19940' => 'd9f8ce743a3540b09da09c3aa5882ea2', //edkun mutavim
        '19939' => 'd9f8ce743a3540b09da09c3aa5882ea2', //edkun pratim
        '19648' => 'd9f8ce743a3540b09da09c3aa5882ea2', //pedion
        '19944' => 'd9f8ce743a3540b09da09c3aa5882ea2', //pedion hishtalmut
    ),

);
$lead = null;
$method = $_GET['method'];

$acc_id = $_GET['crmAcccountNumber'];
$recordNumber = $_GET['recordNumber'];

$leadPostDate = "";
///header("Location:https://ibell.frb.io//leadIm/lead/update?"."recordNumber=".$_GET["recordNumber"]."&crmAcccountNumber=".$_GET['crmAcccountNumber']."&method=".$_GET['method']."&channel_id=".$_GET['channel_id']."&campaign_id=".$_GET['campaign_id']."&date=".$_GET['date']);

//http get with parameters to out laravel application
httpGet('https://ibell.frb.io/leadIm/lead/update?' . $_SERVER['QUERY_STRING']);

if ($method == "update") {
    /*get the Json from the CRM*/
    $leadToPopulateJson = getLeadJson($_GET['recordNumber'], $acc_id, $_GET['agentId'],1);
    $lead = LeadFactory::create($leadToPopulateJson);
    if (is_null($lead)){
        error_log("Received " . $method . " Request but cannot instantiate Lead object for lead id: " . $recordNumber);
    } else {
        error_log("Received " . $method . " Request and instantiate Lead object: " . get_class($lead) ." for lead id: " . $recordNumber);
        $leadPostDate = $lead->generateUpdatePolicyPostData();
        /*update the BI and return a result code*/
        $count = count($leadPostDate);
        //if $count == 2, need to update 2 datasource : insurance policies and shimurim
        if ($count == 2){
            foreach ($leadPostDate as $value){
                $output = addLeadToPlecto($value);
            }
        }else {
            $output = addLeadToPlecto($leadPostDate);
        }
    }

} else if ($method == "delete") {
    $recordDate = new DateTime();
    $recordDate->setTimestamp($_GET['date']);
    $dataSource = $plectoDataSourceMapping[ $_GET['campaign_id']][ $_GET['channel_id']];
    // if $dataSource is array need to delete in two dataSources
    if(is_array($dataSource)){
        foreach ($dataSource as $value){
            $leadPostDate = BaseLead::generateDeletePolicyPostData($recordNumber, $_GET['agentId'], $recordDate, $value);
            $output = addLeadToPlecto($leadPostDate);
        }
    }else{
        $leadPostDate = BaseLead::generateDeletePolicyPostData($recordNumber, $_GET['agentId'], $recordDate, $dataSource);
        $output = addLeadToPlecto($leadPostDate);
    }
} else {
    /*lead is not from the correct campaign*/
    error_log("received lead from the wrong campaign " . $leadToPopulateJson['lead']['campaign_id'] . "\n");
}
http_response_code(200);




