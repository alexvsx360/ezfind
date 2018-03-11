<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/20/2017
 * Time: 2:34 PM
 */
include_once ('functions.php');

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
            if ($leadToPopulateJson['lead']['campaign_id'] == 19578)
                return "ezloans";
            return "ezfind";
        case 3694:
            return $leadToPopulateJson['lead']['fields']['100098'];
            break;
        default:
            return "";
    }
}