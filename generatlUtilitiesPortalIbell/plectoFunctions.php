<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/24/2017
 * Time: 12:22 PM
 */

include_once ('functions.php');

function addLeadToPlecto($postData){
    $json_registration = json_encode($postData);

    $ch = curl_init("https://app.plecto.com/api/v2/registrations/");
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
    return $output;
}