<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/20/2017
 * Time: 2:34 PM
 */
include_once ('functions.php');

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
            break;
        default:
            return "";
    }
}

function getCustomerFullName($acc_id, $leadToPopulateJson){
    switch ($acc_id){
        case 3694:
            return $leadToPopulateJson['lead']['fields']['100086'];
            break;
        default:
            return "";
    }
}

function getCustomerSsn($acc_id, $leadToPopulateJson){
    switch ($acc_id){
        case 3694:
            return $leadToPopulateJson['lead']['fields']['102092'];
            break;
        default:
            return "";
    }
}

function getCustomerEmail($acc_id, $leadToPopulateJson){
    switch ($acc_id){
        case 3694:
            return $leadToPopulateJson['lead']['fields']['100091'];
            break;
        default:
            return "";
    }
}

function getCallCenterName($acc_id, $leadToPopulateJson){
    switch ($acc_id){
        case 3694:
            return $leadToPopulateJson['lead']['fields']['100098'];
            break;
        default:
            return "";
    }
}