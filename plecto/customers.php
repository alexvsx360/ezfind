<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/24/2017
 * Time: 11:29 AM
 */
include_once ('../generalUtilities/plectoFunctions.php');

/*log the request*/
//$myfile = fopen("log.txt", "a");
//fwrite($myfile, "new Lead arrived: " . print_r($_REQUEST, true) . " \n");
var_dump($_REQUEST);

$birthDate = $_GET['birthDate'];
$birthDate = str_replace("/","-", $birthDate);
$birthDate = new DateTime($birthDate . "09:00:00");

$leadDate = $_GET['date'];
$leadDate = str_replace("/","-", $leadDate);
$leadDate = new DateTime($leadDate);

$leadPostDate = [
    'date' => $leadDate->format(DateTime::ISO8601), // Updated ISO8601,
    'data_source' => '5161909315ff40bf8bb10a72eb6b12bd',
    'member_api_provider' => 'leadsProxy',
    'member_api_id' => '1234',
    'member_name' => 'Leads Proxy',
    'callcenterName' => $_GET['callcenterName'],
    'maridge' => $_GET['maridge'],
    'birthDate' => $birthDate->format(DateTime::ISO8601), // Updated ISO8601,
    'sex' => $_GET['sex'],
    'name' => $_GET['name'],
    'reference' => $_GET['recordId'],

];

$output = addLeadToPlecto($leadPostDate);


http_response_code(200);