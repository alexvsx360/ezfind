<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/7/2017
 * Time: 3:19 PM
 */
include ('functions.php');
require '../vendor/autoload.php';
use Zendesk\API\HttpClient as ZendeskAPI;

$subdomain = "ezfind-sherut";
$username  = "yaki@tgeg.co.il";
$token     = "WP5x5E4l3ZCVcaiDqFSJIQouL8WY0AdcX2Rpd7SH"; // replace this with your token
$client = new ZendeskAPI($subdomain, $username);
$client->setAuth('basic', ['username' => $username, 'token' => $token]);
$LOGGER = fopen("log.txt", "a");
$paramIndex = 0;
$fieldId = 0;
$updateLeadUrl = "http://proxy.leadim.xyz/apiproxy/acc3305/updatelead.ashx?acc_id=3694";
//$updateLeadUrl ="http://proxy.leadim.xyz/apiproxy/acc3305/updatelead.2.ashx?acc_id=3694";

function getFieldId($fieldNumber){
    global $updateLeadUrl;
    global $fieldId;
    if($fieldId < 1){
        $fieldId =  appendParameterToURL(109395, $fieldNumber);
        $fieldId =  $fieldId-1;
    }else{
        $updateLeadUrl = $updateLeadUrl ."&update_fields[fld_val_$fieldId]=$fieldNumber";
    }
}
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
$statusToFieldNumJson = [
    "תור_בקרה" => "100084",
    "תור_בקרה_להפקה_מהירה" => "100084",
    "תור_חיתום" => "102337",
    "תור_חוסרים" => "102338",
    "תור_הופק" => "102340",
    "תור_נדחה" => "102339",
    "תור_גנוזות" => "102700",
    "תור_הפקות" => "100085"
];

$hitumJson = [
  "ירוק"  => "102134",
  "אדום"  => "102135"
];

function appendParameterToURL ($fieldToUpdate, $fieldValue){
    global $updateLeadUrl, $paramIndex;
    if ($paramIndex == 0){
        $updateLeadUrl  = $updateLeadUrl . "&update_fields[fld_id]=" . $fieldToUpdate . "&update_fields[fld_val]=" . $fieldValue;
    } else {
        $updateLeadUrl  = $updateLeadUrl . "&update_fields[fld_id_" . $paramIndex . "]=" . $fieldToUpdate . "&update_fields[fld_val_" .$paramIndex . "]=" . $fieldValue;
    }
    $paramIndex ++;
    return $paramIndex;
}


    if ($_GET){
    global $updateLeadUrl, $paramIndex;
        print_r($_GET);
        $myfile = fopen("proxyLog.txt", "a");

        /*log the iURL get parameters to the file*/
        foreach($_GET as $key => $value){
            fwrite($myfile, $key . " : " . $value . "\n");
        }

        $updateLeadUrl = $updateLeadUrl . "&usr_id=11017&lead_ticket=" . $_GET['lead_ticket'] . "&status=" . $statusToFieldNumJson[$_GET['status']];
            if (! empty($_GET['policyNumber'])){
                appendParameterToURL(102145, $_GET['policyNumber']);
            }
            if (! empty($_GET['premia'])){
                appendParameterToURL(100100, $_GET['premia']);
            }
            if (! empty($_GET['actualPremia'])){
                appendParameterToURL(102416, $_GET['actualPremia']);
            }
            if (! empty($_GET['insuranceStartDate'])) {
                appendParameterToURL(102140, strtotime($_GET['insuranceStartDate']));
            }
            if (! empty($_GET['productionDate'])){
                appendParameterToURL(102218, strtotime($_GET['productionDate']));
            }
            if (! empty($_GET['firstPaymentDate'])){
                appendParameterToURL(102144, strtotime($_GET['firstPaymentDate'] ));
            }
            if (! empty($_GET['hitum'])){
                appendParameterToURL(102133, $hitumJson[$_GET['hitum']] );
            }
            if (!empty($_GET['pendingStatus'])){
                appendParameterToURL(104471, $_GET['pendingStatus'] );
            }
            if (!empty($_GET['ticketStatus'])) {
            appendParameterToURL(107639, $_GET['ticketStatus']);
            }
        if (!empty($_GET['reasonForDifferentPremia'])) {
            $reasonForDifferentPremiaString = $_GET['reasonForDifferentPremia'];
            $reasonForDifferentPremiaArray =  (explode(" ",$reasonForDifferentPremiaString));
            $reasonForDifferentPremiaArrayLength = count($reasonForDifferentPremiaArray);
            for($i=0;$i<$reasonForDifferentPremiaArrayLength;$i++){
                switch ($reasonForDifferentPremiaArray[$i]){
                    case "בעית_נציג_-_סימונים_לא_נכונים_במחולל":
                        getFieldId(118400);
                        break;
                    case "בעית_נציג_-_סימונים_לא_נכונים_בהצעה":
                        getFieldId(109396);
                       break;
                    case "בעית_נציג_-_גיל_ביטוחי":
                        getFieldId(109398);
                        break;
                    case "בעית_נציג_-_מעשן_/_לא_מעשן":
                        getFieldId(109397);
                        break;
                    case "בעית_נציג_-_תוספות_מקצועיות":
                        getFieldId(109400);
                        break;
                    case "בעית_נציג_-_הנחות_לא_מאושרות":
                        getFieldId(109401);
                        break;
                    case "בעית_תפעול_שלנו_-_לא_העבירו_דפי_הנחות":
                        getFieldId(109402);
                        break;
                    case "בעית_חברות_הביטוח_-_לא_עדכנו_הנחות":
                        getFieldId(109403);
                        break;
                    case "בעית_חברות_הביטוח_-_לא_סימנו_מוצר_נכון":
                        getFieldId(109404);
                        break;
                    case "בעית_חברות_הביטוח_-_טעות_בהקלדה_פרטים_של_הלקוח":
                        getFieldId(109405);
                        break;
                    case "פער_תקין_-_תוספות_חיתום_בלבד":
                        getFieldId(109406);
                        break;
                    case "אחד_המבוטחים_נדחה_לביטוח":
                        getFieldId(117803);
                        break;
                    case "ביטול_פוליסת_מבנה":
                        getFieldId(117805);
                        break;
                }

            }

        }

/*            if (! empty($_GET['cancelationLetterExists'])){
            appendParameterToURL(102137,    ($_GET['cancelationLetterExists'] == 0 ? "lfv102139" : "lfv102138"));
            }
            if (! empty($_GET['cancelationLetterSent'])){
            appendParameterToURL(102141, ($_GET['cancelationLetterSent'] == 0 ? "lfv102143" : "lfv102142") );
            }*/

            /*Check if the ticket was transfered to תור_הפקות*/
            if (!empty($_GET['status']) && ($_GET['status'] == "תור_הפקות" || $_GET['status'] == "תור_הופק")){
                $leadToPopulateJson = getPolicyLeadByTicketID(3694, $_GET['lead_ticket']);
                if ($_GET['status'] == "תור_הפקות"){
                    //get lead status from lead im CRM
                    if ($leadToPopulateJson != null) {
                        echo $leadToPopulateJson;
                        if ($leadToPopulateJson['lead']['status'] == 102338 || $leadToPopulateJson['lead']['status'] == 102337) {
                            //מעבר מתור חיתום או תור חוסרים לתור הפקות
                            //need to update "תאריך השלמת חוסר" - 106545
                            appendParameterToURL(106545, time()); //current time milliseconds
                        } else if ($leadToPopulateJson['lead']['status'] == 100084 || $leadToPopulateJson['lead']['status'] == 1) {
                            //מעבר מתור בקרה לחברת הביטוח
                            //need to update field 106546 תאריך שליחה לחברת הביטוח
                            appendParameterToURL(106546, time()); //current time milliseconds
                        }
                    }
                } else if ($_GET['status'] == "תור_הופק" && $leadToPopulateJson['lead']['status'] != 102340) {         /*check if status was changed to "הופק"*/
                    // dispach event
                    $dispachHufakEventUrl = "https://ibell.frb.io/leadIm/lead/hufak?date=" . time() .
                        "&recordNumber=" . $leadToPopulateJson['lead']['lead_id'] .
                        "&crmAcccountNumber=3694&method=update" .
                        "&campaign_id=" . $leadToPopulateJson['lead']['campaign_id'] .
                        "&channel_id=" . $leadToPopulateJson['lead']['channel_id'];
                    httpGet($dispachHufakEventUrl);
                }
            }

        fwrite($myfile, "Update URL is: " . $updateLeadUrl ."\n");
        /*Update the CRM*/
        $result = httpGet($updateLeadUrl);
        checkUpdate($result,$updateLeadUrl);
        /*Update the BI*/
        //updateRecordInBiScreen($_GET['lead_ticket'],  $statusToFieldNumJson[$_GET['status']], strtotime($_GET['productionDate']), $_GET['premia']);
        /*http://proxy.leadim.xyz/apiproxy/acc3305/updatelead.ashx?acc_id=3694&lead_ticket=4564&status=10084&update_fields[fld_id]=102145&update_fields[fld_val]=&update_fields[fld_id_1]=100100&update_fields[fld_val_1]=123456&update_fields[fld_id_2]=102416&update_fields[fld_val_2]=154&update_fields[fld_id_3]=102140&update_fields[fld_val_3]=2017-12-01&update_fields[fld_id_4]=102218&update_fields[fld_val_4]=2017-11-27&update_fields[fld_id_5]=102144&update_fields[fld_val_5]=2018-01-01&update_fields[fld_id_6]=102133&update_fields[fld_val_6]=ירוק*/
    }

