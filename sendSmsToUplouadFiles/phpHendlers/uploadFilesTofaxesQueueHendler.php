<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 17/09/2018
 * Time: 12:28
 */
require '../vendor/autoload.php';

use Zendesk\API\HttpClient as ZendeskAPI;
include_once "../generalUtilities/classes/iBellConnect.php";
include_once "../generalUtilities/classes/ezfindConnect.php";
$ssn = $_POST['ssn'];
$castumerFirstName = $_POST['castumerFirstName'];
$castumerLastName = $_POST['castumerLastName'];
$typeOfTicket = $_POST['typeOfTicket'];

switch($typeOfTicket){
    case 'ezfind':
        $ticketconnect =  new iBellConnect();
        $tags = "פקס_בולוטין";
        break;
    case 'ezfind-sherut' :
        $ticketconnect =  new ezfindConnect();
        $tags = "איסוף_מסמכים";
        break;
    default:
        return null;
}
$subDomain = $ticketconnect->getSubDomain();
$userName =  $ticketconnect->getUserName();
$token = $ticketconnect->getToken();
$client = new ZendeskAPI($subDomain, $userName);
$client->setAuth('basic', ['username' => $userName, 'token' => $token]);
$arrayNameFiles = array();
$arrayTmpNameFiles = array();
$arrayTypeFiles = array();
$extension_files = array();
$new_name_files = array();
$array_targets = array();
$array_links = array();

foreach ($_FILES as $index => $fileName){
    $file = $_FILES[$index]["name"];
    array_push($arrayNameFiles, $file);
    $file = $_FILES[$index]["tmp_name"];
    array_push($arrayTmpNameFiles, $file);
    $file = $_FILES[$index]["type"];
    array_push($arrayTypeFiles, $file);
}


//to get the extension of the file.
foreach ($arrayNameFiles as $index => $file_name) {
    $extension = pathinfo($file_name, PATHINFO_EXTENSION);
    array_push($extension_files, $extension);
}

//to define a new name for each file.
foreach ($extension_files as $i => $extension_name) {
    $new_name = $typeOfTicket."_" . $ssn . "." . $i . "." . $extension_name;
    array_push($new_name_files, $new_name);
}

//send to new directory the files and save the new directory and types in arrays.
foreach ($new_name_files as $i => $newname) {
    move_uploaded_file($arrayTmpNameFiles[$i], '../documentsFilesToFaxQueue/' . $newname);
    $target = '../documentsFilesToFaxQueue/' . $newname;
    array_push($array_targets, $target);
    $link = "https://portal.ibell.co.il/documentsFilesToFaxQueue/". $newname;
    array_push($array_links, $link);
};
//save the uploaded file as zendesk attachment
$upload_token = "";
foreach ($arrayNameFiles as $i => $files) {
    $params = array(
        'file' => $array_targets[$i],
        'type' => $arrayTypeFiles[$i],
        'name' => $arrayNameFiles[$i]
    );
    if (isset($upload_token)) {
        $params['token'] = $upload_token;
    }
    $attachment = $client->attachments()->upload($params);
    $upload_token = $attachment->upload->token;
}




$newTicket = $client->tickets()->create([
    'tags' => $tags,
    'subject' => $castumerFirstName . ' '.$castumerLastName.' '. $ssn." -"."שלח מסמכים לתפעול",
    'comment' => [
        'body' => $castumerFirstName . ' '.$castumerLastName.' '. $ssn. " \n\n"."קבצים שנשלחו מהלקוח",
        'uploads'   => [$upload_token]

    ]
]);
$ticketId = $newTicket->ticket->id;
if ($ticketId!=0){
    echo "הקבצים נקלטו בהצלחה";
  }
else{
    echo "הקבצים לא נקלטו";
}