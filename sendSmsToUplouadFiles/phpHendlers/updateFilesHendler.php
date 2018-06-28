<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/05/2018
 * Time: 00:26
 */

include_once ('../generalUtilities/classes/updateFilesInZendeskTicket.php');
include_once ('../generalUtilities/classes/sendSmsByLeadImFunctions.php');
$errors = array();
$data = array();// array to hold validation errors
if (empty($_FILES))
    $errors['files'] = 'files is required.';
if (empty($_POST['ticketId']))
    $errors['ticet-Id'] = 'ticetId is required.';
if (empty($_POST['updateIn']))
    $errors['updateIn'] = 'updateIn is required.';
if (empty($_POST['campaignId']))
    $errors['campaignId'] = 'campaignId is required.';
if (empty($_POST['recordNumber']))
    $errors['recordNumber'] = 'recordNumber is required.';
if (empty($_POST['crmAccountNumber']))
    $errors['crmAccountNumber'] = 'crmAccountNumber is required.';
if (empty($_POST['userName']))
    $errors['userName'] = 'userName is required.';
if (empty($_POST['userEmail']))
    $errors['userEmail'] = 'userEmail is required.';
// return a response ===========================================================

// if there are any errors in our errors array, return a success boolean of false
if (!empty($errors)) {
    // if there are items in our errors array, return those errors
    $data['success'] = false;
    $data['errors']  = $errors;
    $file = fopen("logErrors.txt", "a");
    fwrite($file,"in date: ". date("d/m/Y")." time: ".date("h:i:sa").print_r($errors,true)."\n");
    echo ("הקבצים לא נקלטו במערכת, נא נסה שוב");
} else {
    $data['success'] = true;
    $data['message'] = 'Success!';
    $updateIn = $_POST['updateIn'];
    switch($updateIn){
        case 'zendesk':
          return new updateFilesInZendeskTicket();
    }
}

