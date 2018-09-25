<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13/08/2018
 * Time: 13:47
 */
function getLeadSuplaierName($getLeadResult){
    if ($getLeadResult['status'] == 'success' && $getLeadResult['lead']['supplier_id'] != 0){
        return getUser(3310, $getLeadResult['lead']['supplier_id'])['result']['name'];;
    }
    return "ללא ספק";
}

function getLeadDataSource($getLeadResult){
    if ($getLeadResult['status'] == 'success'){
        return $getLeadResult['lead']['channel_name'];
    }
    return "לא קיים במערכת אם";
}

