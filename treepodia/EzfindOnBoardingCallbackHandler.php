<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/18/2018
 * Time: 9:24 AM
 */

include_once "../generalUtilities/functions.php";
include_once "../generalUtilities/leadImFunctions.php";

echo "hello world";


$jsonStr = file_get_contents('php://input');
$callbackJson = json_decode($jsonStr);
if ((json_last_error() == JSON_ERROR_NONE)) {
    $requestId = $callbackJson->requestId;
    error_log("EzfindOnBoardingCallbackHandler -  Received new video callback, Video id is: " . $requestId .
        "VIdeo URL is: " . $callbackJson->videoUrl . " \n");

    //search the lead from the CRM by video id
    $searchLeadResults = leadInSearchLead(3328, 105347, $requestId, 16018);
    if ($searchLeadResults['status'] != "success"){
        error_log("EzfindOnBoardingCallbackHandler -  Could not find lead with video id: " . $requestId . "\n");
        return;
    }
    //get the lead
    $getLeadResult = leadImGetLead(3328, $searchLeadResults['lead_id']);

    leadImUpdateLead(3328, $searchLeadResults['lead_id'], [105345 => $callbackJson->videoUrl , 105348 => "http://ezfind.co.il/personalvideo/?sku=" . $getLeadResult['lead']['fields']['105346']], true);
    if ($callbackJson->videoUrl == null){
        /*video is null failed to do create video...*/
        error_log("EzfindOnBoardingCallbackHandler -  Received null as video URL, will not send SMS...\n");
        return;
    }
    leadImSendSMS(3328, $searchLeadResults['lead_id'], 107307, 11017);
    error_log("EzfindOnBoardingCallbackHandler -  SMS sent to customer for request: " . $requestId . "\n");
} else {
    error_log("EzfindOnBoardingCallbackHandler -  Failed to parse Json from POST json str is : " . $jsonStr);
}


