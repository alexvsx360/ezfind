<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/20/2017
 * Time: 2:34 PM
 */
//include_once ('functions.php');
require '../vendor/autoload.php';
use Zendesk\API\HttpClient as ZendeskAPI;

$subdomain = "ezfind-sherut";
$username  = "yaki@tgeg.co.il";
$token     = "WP5x5E4l3ZCVcaiDqFSJIQouL8WY0AdcX2Rpd7SH"; // replace this with your token
$client = new ZendeskAPI($subdomain, $username);
$client->setAuth('basic', ['username' => $username, 'token' => $token]);
$LOGGER = fopen("log.txt", "a");
function checkUpdate($result,$updateLeadUrl)
{
    global $client;
    if ($result != "OK") {
        for ($i = 0; $i < 3; $i++) {
            sleep(1);
            $result = httpGet($updateLeadUrl);
            if ($result == "OK") {
                break;
            } else {
                if ($i == 2 && $result != "OK") {
                    $result = json_decode($result, true);
                    // $file = fopen("error.txt","w");
                    $current_file_name = basename($_SERVER['PHP_SELF']);
                    $debug = debug_backtrace();
                    $debug = array_shift($debug);
//                  $sentfromServer = $_SERVER['SERVER_NAME'];
                    $sentfromServer = $_SERVER['HTTP_HOST'];
                    $parseUrl = parse_url($updateLeadUrl);
                    $sentToServer = $parseUrl['host'];
                    $prameters ="";
                    foreach($_GET as $key => $value){
                        $prameters.= $key . " : " . $value . "\n";
                    }
                    $newTicket = $client->tickets()->create([
                        'tags' => 'error',
                        'status' => 'new',
                        'subject' => 'error in update crm',
                        'requester' => array(
                            'name' => 'dina',
                            'email' => 'dina.r@ezfind.co.il'
                        ),
                        //   'collaborators' =>  ["Yaki@tgeg.co.il"],
                        'comment' => [
                            'body' => 'in date:' . date("d/m/Y") . " \n" .
                                'in file: ' . $current_file_name . " \n" .
                                'in line: ' . $debug["line"] . " \n" .
                                'prameters: ' . $prameters . " \n" .
                                'Error:' . $result['errmsg'] . " \n" .
                                'request sent from server :' . $sentfromServer . " \n" .
                                'to server:' . $sentToServer . " \n" .
                                'orignalUrl:' . $updateLeadUrl
                        ]
                    ]);
                }
            }
        }
    } else {
        return $result;
    }
}
function getStatusAsString($statusCode){
    $statusCodeToSrting = [
        '1' => "New",
        '100084' => "תור בקרה",
        '100085' => "נשלח לחברת הביטוח",
        '102337' => "חיתום",
        '102338' => "חוסרים",
        '102339' => "נדחה",
        '102340' => "הופק",
        '102700' => "נגנז",
        '103721' => "לא עונה 1",
        '103722' => "לא עונה 2",
        '103723' => "לא עונה 3",
        '103724' => "לא עונה 4",
        '103725' => "לא עונה 5 ויותר",
        '103726' => "נקבעה שיחת המשך",
        '103727' => "הועבר לטיפול נציג המכירות",
        '103728' => "ממתין למסמכים מהלקוח",
        '103729' => "נשלח מכתב ביטול",
        '103730' => "פניה סגורה",
        '103731' => "לקוח מבקש לבטל",
        '103732' => "עודכן אמצעי תשלום",
        '103733' => "שימור",
        '103734' => "ביטול",
        '104259' => "הופק ושומר",
        '2' => "Invalid",

    ];
    return $statusCodeToSrting[$statusCode];
}


function appendParameterToURL ($updateLeadUrl, $fieldToUpdate, $fieldValue, $paramIndex){
    if ($paramIndex == 0){
        $updateLeadUrl  = $updateLeadUrl . "&update_fields[fld_id]=" . $fieldToUpdate . "&update_fields[fld_val]=" . $fieldValue;
    } else {
        $updateLeadUrl  = $updateLeadUrl . "&update_fields[fld_id_" . $paramIndex . "]=" . $fieldToUpdate . "&update_fields[fld_val_" .$paramIndex . "]=" . $fieldValue;
    }
    return $updateLeadUrl;
}

function leadInSearchLead($crmAccountNumber, $searchBy, $searchTerm, $campaign, $mult = 0 ){
    if (! isset($crmAccountNumber) || ! isset($searchBy) || !isset($searchTerm) || !isset($campaign)){
        return [
            "errorMsg" => "All API parameters must exists"
        ];
    } else {
        $searchPost = [
            "key" => "3765d732472d44469e70a088caef3040",
            "acc_id" => $crmAccountNumber,
            "searchby" => $searchBy,
            "searchterm" => $searchTerm,
            "campaign"  => $campaign,            // customers campaign
            "mult" => $mult
            //"channel"   => "17993"

        ];
        return json_decode(httpPost("http://proxy.leadim.xyz/apiproxy/acc3305/searchlead.ashx", $searchPost), true);
    }
}

function leadImGetLead($crmAccountNumber, $leadId) {
    if (! isset($crmAccountNumber) || ! isset($leadId) ){
        return [
            "errorMsg" => "All API parameters must exists"
        ];
    } else {
        $searchPost = [
            "key" => "3765d732472d44469e70a088caef3040",
            "acc_id" => $crmAccountNumber,
            "lead_id" => $leadId,              // lead id
        ];
        return json_decode(httpPost("http://proxy.leadim.xyz/apiproxy/acc3305/getlead.ashx", $searchPost), true);
    }
}

function leadImUpdateLead($crmAccountNumber, $leadId, $updateFieldsKeyValue, $doLogFinalUrl, $status = null){
    if (! isset($crmAccountNumber) || ! isset($leadId)  || !isset($updateFieldsKeyValue)){
        return [
            "errorMsg" => "All API parameters must exists"
        ];
    } else {
        $url = "http://proxy.leadim.xyz/apiproxy/acc3305/updatelead.ashx?lead_id=" . $leadId . "&acc_id=" . $crmAccountNumber;
        $url = $status!= null ? $url. "&status=" . $status : $url;
        $index = 0;
        foreach($updateFieldsKeyValue as $key => $value){
            $url = appendParameterToURL($url, $key, $value, $index);
            $index++;
        }
        if ($doLogFinalUrl){
            error_log("leadImUpdateLead -  updating lead: " . $leadId . "UpdateUrl is: " .$url . "\n");
        }
        $result =  httpGet($url);
        checkUpdate($result,$url);
    }
}

function leadImSendSMS($crmAccountNumber, $leadId, $templateId, $userId){
    if (! isset($crmAccountNumber) || ! isset($leadId)  || !isset($templateId) || !isset($userId)){
        return [
            "errorMsg" => "All API parameters must exists"
        ];
    } else {
        $sendSMSPost = [
            "key" => "3765d732472d44469e70a088caef3040",
            "acc_id" => $crmAccountNumber,
            "lead_id" => $leadId,              // lead id
            "template_id" => $templateId,
            "user_id" => $userId,
        ];
        return json_decode(httpPost("http://proxy.leadim.xyz/apiproxy/acc3305/send_template_sms.ashx", $sendSMSPost), true);
    }
}

function addOrCreateCustomerandUpdateNewSale($saleId, $customerPhone, $createCustomerPost){
    /*search lead by customer phone */
    $searchBaseUrl = "http://proxy.leadim.xyz/apiproxy/acc3305/searchlead.ashx";
    $searchPost = [
        "key" => "3765d732472d44469e70a088caef3040",
        "acc_id" => "3694",
        "searchby" => "100090",              // customer phone
        "searchterm" => $customerPhone,
        "campaign"  => "17992"            // customers campaign
    ];

    $response="";
    $isExists = httpPost($searchBaseUrl, $searchPost);
    $isExists = json_decode($isExists, true);
    if ($isExists['lead_id'] > 0){
        //customer exists - $isExists == customer lead id
        //update the original lead id
        $updateLeadUrl = "http://proxy.leadim.xyz/apiproxy/acc3305/updatelead.ashx?acc_id=3694" .
            "&lead_id=" . $isExists['lead_id'] . "&update_fields[fld_id]=102161&update_fields[fld_val]=https://crm.ibell.co.il/a/3694/leads/" . $saleId;
        $response = httpGet($updateLeadUrl);
    } else if ($isExists['lead_id']  ==  0){
        //customer does not exist need to create new customer
        $newCustomerBaseUrl = "http://api.lead.im/v1/submit";
        $createCustomerPost['policies'] = "https://crm.ibell.co.il/a/3694/leads/" . $saleId;
        $response = httpPost($newCustomerBaseUrl, $createCustomerPost);

    }
    return $response;
}

function addSherutLeadToCustomer($CustomerLeadId, $NewLeadId){
    $updateLeadUrl = "http://proxy.leadim.xyz/apiproxy/acc3305/updatelead.ashx?acc_id=3694" .
        "&lead_id=" . $CustomerLeadId .
        "&update_fields[fld_id]=102162" .
        "&update_fields[fld_val]=https://crm.ibell.co.il/a/3694/leads/" . $NewLeadId;
    return httpGet($updateLeadUrl);
}

function openNewLead($postData){
    return httpPost('http://api.lead.im/v1/submit', $postData);
}


function getCustomerPhone($acc_id, $leadToPopulateJson){
    switch ($acc_id){
        case 3694:
            return $leadToPopulateJson['lead']['fields']['100090'];
        case 3328:
            return $leadToPopulateJson['lead']['fields']['94421'];
        default:
            return "";
    }
}

function getCustomerFullName($acc_id, $leadToPopulateJson){
    switch ($acc_id){
        case 3694:
            return $leadToPopulateJson['lead']['fields']['100086'];
        case 3328:
            return $leadToPopulateJson['lead']['fields']['94420'];
        default:
            return "";
    }
}

function getCustomerSsn($acc_id, $leadToPopulateJson){
    switch ($acc_id){
        case 3694:
            return $leadToPopulateJson['lead']['fields']['102092'];
        case 3328:
            return $leadToPopulateJson['lead']['fields']['94521'];
        default:
            return "";
    }
}

function getCustomerEmail($acc_id, $leadToPopulateJson){
    switch ($acc_id){
        case 3694:
            return $leadToPopulateJson['lead']['fields']['100091'];
        case 3328:
            $email = $leadToPopulateJson['lead']['fields']['94422'];
            if ($email == ""){
                $email = $leadToPopulateJson['lead']['fields']['94518'];
            } else {
                return $email;
            }
            return $email;
        default:
            return "";
    }
}


function getSecondaryCustomerName($acc_id, $leadToPopulateJson){
    switch ($acc_id){
        case 3328:
            return $leadToPopulateJson['lead']['fields']['94486'] . " " . $leadToPopulateJson['lead']['fields']['94487'];
        default:
            return "";
    }
}

function getCustomerAddress($acc_id, $leadToPopulateJson){
    switch ($acc_id){
        case 3328:
            return $leadToPopulateJson['lead']['fields']['94486'] . $leadToPopulateJson['lead']['fields']['95197'];
        default:
            return "";
    }
}

function getSecondaryCustomerSsn($acc_id, $leadToPopulateJson){
    switch ($acc_id){
        case 3328:
            return $leadToPopulateJson['lead']['fields']['94492'];
        default:
            return "";
    }
}

function getCallCenterName($acc_id, $leadToPopulateJson){
    switch ($acc_id){
        case 3328:
            if ($leadToPopulateJson['lead']['campaign_id'] == 19578 || $leadToPopulateJson['lead']['campaign_id'] == 20696){
                return "ezloans";
            }
            if ($leadToPopulateJson['lead']['campaign_id'] == 16018 || $leadToPopulateJson['lead']['campaign_id'] == 18571){
                return "ezfind";
            }
        case 3694:
            return $leadToPopulateJson['lead']['fields']['100098'];
            break;
        default:
            return "";
    }
}
function getUser($acc_id,$user_id){
    if (!isset($acc_id) || !isset($user_id)) {
        return [
            "errorMsg" => "All API parameters must exists"
        ];
    } else {
        $searchPost = [
            "key" => "3765d732472d44469e70a088caef3040",
            "acc_id" => $acc_id,
            "user_id" => $user_id
        ];
        return json_decode(httpPost("http://proxy.leadim.xyz/apiproxy/acc3305/getuser.ashx", $searchPost), true);

    }
}
function getActiveUsers($acc_id,$type){
    if (!isset($acc_id) || !isset($type)) {
        return [
            "errorMsg" => "All API parameters must exists"
        ];
    } else {
        $searchPost = [
            "key" => "3765d732472d44469e70a088caef3040",
            "acc_id" => $acc_id,
            "type" => $type
        ];
        return json_decode(httpPost("http://proxy.leadim.xyz/apiproxy/acc3305/getusers.ashx", $searchPost), true);

    }
}
