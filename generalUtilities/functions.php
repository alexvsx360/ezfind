<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/15/2017
 * Time: 8:10 AM

 */

function getLeadJson ($lead_id, $acc_id ,$lm_initializer_id){
    $leadImKey = '3765d732472d44469e70a088caef3040';
    $populateLeadPostData = [
        'key' => $leadImKey,
        'acc_id' => $acc_id,
        'lead_id' => $lead_id,
        'lm_initializer_id' => $lm_initializer_id
    ];
    $leadInfoStr = httpPost('http://proxy.leadim.xyz/apiproxy/acc3305/getlead.ashx', $populateLeadPostData);
    $leadToPopulateJson = json_decode($leadInfoStr, true);
    return $leadToPopulateJson;

}


function httpPostWithUserPassword ($url, $post, $username, $password){
    $process = curl_init($url);
    curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//curl_setopt($process, CURLOPT_HEADER, 1);
    curl_setopt($process, CURLOPT_USERPWD, $username . ":" . $password);
    curl_setopt($process, CURLOPT_TIMEOUT, 30);
    curl_setopt($process, CURLOPT_POST, 1);
    curl_setopt($process, CURLOPT_POSTFIELDS, $post /*array('ticket'=>json_encode($data, JSON_UNESCAPED_UNICODE))*/);
    curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
    $return = curl_exec($process);
    curl_close($process);
    return $return;
}


function getRecordInitializerdName($lead_id, $acc_id, $lm_initializer_id){
    $leadImKey = '3765d732472d44469e70a088caef3040';

    $populateLeadPostData = [
        'key' => $leadImKey,
        'acc_id' => $acc_id,
        'lead_id' => $lead_id,
        'lm_initializer_id' => $lm_initializer_id
    ];

    $leadInfoStr = httpPost('http://proxy.leadim.xyz/apiproxy/acc3305/getlead.ashx' , $populateLeadPostData);
    $leadToPopulateJson = json_decode($leadInfoStr, true);
    return  $leadToPopulateJson['user']['name'];

}

function httpGet($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    $content = trim(curl_exec($ch));
    curl_close($ch);
    return $content;
}


function httpPost($url, $post) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

function getCallCenterById($crmAccountNum)
{
    switch ($crmAccountNum) {
        case 3326:
            return "איזי_ביטוח";
        case 3474:
            return "אביב_בר_שי";
        case 3325:
            return "אלעד_שמעוני";
        case 3305:
            return "מוקד_בולוטין";
        default:
            return "מוקד לא ידוע!";
    }
}


function updateCustomer($policyId, $createCustomerPost, $customerPhone, $myfile){
    /*search lead by customer phone */
    $searchBaseUrl = "http://proxy.leadim.xyz/apiproxy/acc3305/searchlead.ashx";
    $searchPost = [
        "key" => "3765d732472d44469e70a088caef3040",
        "acc_id" => "3694",
        "searchby" => "100090",              // customer phone
        "searchterm" => $customerPhone,
        "campaign"  => "17992"            // customers campaign
        //"channel"   => "17993"

    ];
    $response = "";
    $isExists = httpPost($searchBaseUrl, $searchPost);
    $isExists = json_decode($isExists, true);
    if ($isExists['lead_id'] > 0){
        //customer exists - $isExists == customer lead id
        //update the original lead id
        $updateLeadUrl = "http://proxy.leadim.xyz/apiproxy/acc3305/updatelead.ashx?acc_id=3694" .
            "&lead_id=" . $isExists['lead_id'] . "&update_fields[fld_id]=102161&update_fields[fld_val]=https://crm.ibell.co.il/a/3694/leads/" . $policyId;
        $response = httpGet($updateLeadUrl);
        fwrite($myfile, "\nUpdate Lead URL " . $updateLeadUrl);
        fwrite($myfile, "\nResponse from Lead.im" . $response);
    } else if ($isExists['lead_id']  ==  0){
        //customer does not exist need to create new customer
        $newCustomerBaseUrl = "http://api.lead.im/v1/submit";
        $createCustomerPost['policies'] = "https://crm.ibell.co.il/a/3694/leads/" . $policyId;
        $response = httpPost($newCustomerBaseUrl, $createCustomerPost);
        fwrite($myfile, "Response from Lead.im" . $response);

    }

}

function getCollaboratorArrayById($crmAccountNum, $userEmail) {
    switch ($crmAccountNum) {
        case 3325:
        case 3326:
            return array( $userEmail);
        case 3474:
            return array( $userEmail, "meiravs@tgeg.co.il");
        case 3305:
            return array( $userEmail, "Eli@bolotin.co.il");
        default:
            return array($userEmail);
    }
}

function createRecordInBIScreen($saleDate, $agentId, $insuranceCompany, $premia, $hitum, $sellerName, $promoterName, $leadChannel, $productionStatus, $insuranceType, $recordId, $moked){
    $registration = array(
        'data_source' => 'ed3d7226947140b996ecf1bfbd19577e',    // Insurance Sales UUI
        //'member' => $agentId,                                   //either provide the member uuid or member_api_provider and member_api_id and member_name
        'member_api_provider' => 'lead im CRM',  # Use appropriate name for the system that use the below ID. Can also be e.g. salesforce, podio, pipedrive or the name of any external system.
        'member_api_id' => $agentId,  # Provide a user ID from the above system.
        'member_name' => $sellerName,  # Provide the user ID from the above system
        #'team': '<Team UUID>', #optional make registration for team
        'date' => date('Y-m-d\TH:i:s', $saleDate), // Optional, if not provided date is now (ISO-8601 format)
        'Insurance_Type' => $insuranceType,
        'Insurance_Company' => $insuranceCompany,
        'Monthly_Premia' => $premia,
        'Annual_Premia' => ($premia * 12),
        'hitum' => $hitum,
        'Seller_Name' => $sellerName,
        'Promoter_Name' => $promoterName,
        'Selling_Channel' => $leadChannel,
        'Production_Status' => $productionStatus,
        'Call_Center_name' => $moked,
        'Sale_Date' => date('Y-m-d\TH:i:s', $saleDate),
        'Production_Date' => date('Y-m-d\TH:i:s', $saleDate),
        'reference' => $recordId  // Change to a unique ID
    );
    updatePlecto($registration);
}

function updateRecordInBiScreen($recordId, $productionStatus, $productionDateAsTimestamp, $premia){

    $searchBaseUrl = "http://proxy.leadim.xyz/apiproxy/acc3305/searchlead.ashx";
    $searchPost = [
        "key" => "3765d732472d44469e70a088caef3040",
        "acc_id" => "3694",
        "searchby" => "102158",              // Ticket Number
        "searchterm" => $recordId,
        "campaign"  => "17967"            // Policy campaign
        //"channel"   => "17993"
    ];


    $leadInfoStr = httpPost($searchBaseUrl , $searchPost);
    $leadToPopulateJson = json_decode($leadInfoStr, true);
    $fieldsValuesJsonArray = array_values($leadToPopulateJson['lead']['fields']);
    $fullName = $fieldsValuesJsonArray[0] . " " . $fieldsValuesJsonArray[1];
    $phone =  $fieldsValuesJsonArray[3];
    $promoterName = $fieldsValuesJsonArray[16];
    $currentUserName = $leadToPopulateJson['user']['name'];
    $currentUserEmail = $leadToPopulateJson['user']['email'];
    $channelName = $leadToPopulateJson['lead']['channel_name'];





    $registration = array(
        'data_source' => 'ed3d7226947140b996ecf1bfbd19577e',    // Insurance Sales UUI
        //'member' => $agentId,                                   //either provide the member uuid or member_api_provider and member_api_id and member_name
        'member_api_provider' => 'lead im CRM',  # Use appropriate name for the system that use the below ID. Can also be e.g. salesforce, podio, pipedrive or the name of any external system.
        #'team': '<Team UUID>', #optional make registration for team
        'Monthry Premia' => $premia,
        'Annual Premia' => ($premia * 12),
        'Production Status ' => $productionStatus,
        'Production Date' => date('c', $productionDateAsTimestamp),
        'reference' => $recordId  // Change to a unique ID
    );
    updatePlecto($registration);
}

/**
 * @param $registration
 */
function updatePlecto($registration): void
{
    $json_registration = json_encode($registration);

    //$ch = curl_init("https://app.plecto.com/api/v2/registrations/");
    $ch = curl_init("http://proxy.leadim.xyz/logger.ashx");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "yaki@tgeg.co.il:" . "alma@102030");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8"));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_registration);

    $output = curl_exec($ch);

    $errno = curl_errno($ch);
    // Handle errors

    $output = json_decode($output, true);

    curl_close($ch);
}