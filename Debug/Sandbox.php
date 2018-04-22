<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/27/2017
 * Time: 9:11 PM
 */

include ('../functions.php');

/*createRecordInBIScreen(date('mm-dd-yyyy'), 1234, 'כלל', 120, "ירוק", "jacob", 'jacob', "channel"
                        ,"status", "anyType of insurance", 123456, 'my moked' );*/

/*$leadImKey = '3765d732472d44469e70a088caef3040';

$populateLeadPostData = [
    'key' => $leadImKey,
    'acc_id' => 3694,
    'searchby' => "102158",
    "campaign"  => "17967",
    'searchterm' => "14626"
];*/

/*$leadInfoStr = httpPost('http://proxy.leadim.xyz/apiproxy/acc3305/getlead.ashx' , $populateLeadPostData);*/
/*$leadInfoStr = httpPost('http://proxy.leadim.xyz/apiproxy/acc3305/searchlead.ashx' , $populateLeadPostData);
$leadToPopulateJson = json_decode($leadInfoStr, true);
$leadToPopulateJson['user']['name'];*/

$fieldMapper = [
    "3328" => [
        "totalHealth" => "106440",
        "totalLife" => "106441",
        "total" => "106442"
    ],
    "3327" => [
        "totalHealth" => "106947",
        "totalLife" => "106948",
        "total" => "106949"
    ]
];

$crmAccountNumber = "3327";
echo $fieldMapper[$crmAccountNumber]['totalHealth'];