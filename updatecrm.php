<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/7/2017
 * Time: 3:19 PM
 */
include ('functions.php');

$paramIndex = 0;
$updateLeadUrl = "http://proxy.leadim.xyz/apiproxy/acc3305/updatelead.ashx?acc_id=3694";

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
/*            if (! empty($_GET['cancelationLetterExists'])){
            appendParameterToURL(102137,    ($_GET['cancelationLetterExists'] == 0 ? "lfv102139" : "lfv102138"));
            }
            if (! empty($_GET['cancelationLetterSent'])){
            appendParameterToURL(102141, ($_GET['cancelationLetterSent'] == 0 ? "lfv102143" : "lfv102142") );
            }*/

            /*Check if the ticket was transfered to תור_הפקות*/
            if (!empty($_GET['status']) && $_GET['status'] == "תור_הפקות"){
                //get lead status from lead im CRM
                $leadToPopulateJson = getPolicyLeadByTicketID(3694, $_GET['lead_ticket']);
                if ($leadToPopulateJson != null){
                    echo $leadToPopulateJson;
                    if ($leadToPopulateJson['lead']['status'] == 102338  || $leadToPopulateJson['lead']['status'] == 102337 ){
                        //מעבר מתור חיתום או תור חוסרים לתור הפקות
                        //need to update "תאריך השלמת חוסר" - 106545
                        appendParameterToURL(106545, time()); //current time milliseconds
                    } else if($leadToPopulateJson['lead']['status'] == 100084 || $leadToPopulateJson['lead']['status'] == 1){
                        //מעבר מתור בקרה לחברת הביטוח
                        //need to update field 106546 תאריך שליחה לחברת הביטוח
                        appendParameterToURL(106546, time()); //current time milliseconds
                    }
                }
            }

        fwrite($myfile, "Update URL is: " . $updateLeadUrl ."\n");
        /*Update the CRM*/
        httpGet($updateLeadUrl);
        /*Update the BI*/
        //updateRecordInBiScreen($_GET['lead_ticket'],  $statusToFieldNumJson[$_GET['status']], strtotime($_GET['productionDate']), $_GET['premia']);
        /*http://proxy.leadim.xyz/apiproxy/acc3305/updatelead.ashx?acc_id=3694&lead_ticket=4564&status=10084&update_fields[fld_id]=102145&update_fields[fld_val]=&update_fields[fld_id_1]=100100&update_fields[fld_val_1]=123456&update_fields[fld_id_2]=102416&update_fields[fld_val_2]=154&update_fields[fld_id_3]=102140&update_fields[fld_val_3]=2017-12-01&update_fields[fld_id_4]=102218&update_fields[fld_val_4]=2017-11-27&update_fields[fld_id_5]=102144&update_fields[fld_val_5]=2018-01-01&update_fields[fld_id_6]=102133&update_fields[fld_val_6]=ירוק*/
    }

