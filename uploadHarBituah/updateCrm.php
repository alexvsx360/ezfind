<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/24/2017
 * Time: 5:47 PM
 */

include_once ("../generalUtilities/functions.php");
var_dump($_REQUEST);
$req_dump = print_r($_REQUEST, TRUE);
$fp = fopen('request.log', 'a');
fwrite($fp, $req_dump ."\n");
;
$statusToFieldNumJson = [
    "מסלקות_פנסיוניות___בקשות_חדשות" => "100084",
    "מסלקות_פנסיוניות___נשלח_לחברת_הביטוח" => "100085",
];

$updateLeadUrl = "http://proxy.leadim.xyz/apiproxy/acc3305/updatelead.ashx?acc_id=3694";
$updateLeadUrl .= "&lead_ticket=" . $_GET['lead_ticket'];
if ($_GET['status'] == "Solved"){
    $updateLeadUrl .="&status=102340"; //הופק
} else {
    $updateLeadUrl .= "&status=" . $statusToFieldNumJson[$_GET['workingQueue']];
}

$updateLeadUrl .= "&update_fields[fld_id]=104484&update_fields[fld_val]=" . $_GET['status'];

fwrite($fp, $updateLeadUrl."\n" );
$response = httpGet($updateLeadUrl);
fwrite($fp, $response."\n" );
fclose($fp);

http_response_code(200);