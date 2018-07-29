<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 1/4/2018
 * Time: 5:16 PM
 */
include_once "../../generalUtilities/leadImFunctions.php";
$ctcCounterFieldMapper = [
    '3305' => '110062',
    '3325' => '110407',
    '3326' => '110412',
    '3328' => '110423'
];

$callTimeFieldMapper = [
    '3305' => '110063',
    '3325' => '110408',
    '3326' => '110413',
    '3328' => '110425'
];

function getCallCount(){
    global $ctcCounterFieldMapper;
    $leadToUpdate = leadImGetLead($_POST['accountNumber'], $_POST['leadNumber']);
    if ($leadToUpdate['status'] != 'success'){
        return 0;
    }
    return $leadToUpdate['lead']['fields'][$ctcCounterFieldMapper[$_POST['accountNumber']]];

}
$str1 = @date('[d/M/Y:H:i:s]') . "ezfindLogger received new" . $_SERVER['REQUEST_METHOD'] . " request \n";
$str2 = @date('[d/M/Y:H:i:s]') . "URL is - http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$str3 = @date('[d/M/Y:H:i:s]') . "request parameters are " . print_r($_REQUEST, TRUE) . "\n";

error_log($str1);
error_log($str2);
error_log($str3);


// update 2 fields in the lead
$callCounter = getCallCount($_POST['accountNumber'], $_POST['leadNumber']);

$updateFields = [
    $ctcCounterFieldMapper[$_POST['accountNumber']] => ++$callCounter,
    $callTimeFieldMapper[$_POST['accountNumber']] => time()
];
leadImUpdateLead($_POST['accountNumber'], $_POST['leadNumber'], $updateFields, true);


