<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" h    ref="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>הפניה נתפחה בהצלחה!</title>
</head>
<body>

<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/20/2017
 * Time: 3:32 PM
 */
include ('../generalUtilities/functions.php');
include ('../generalUtilities/leadImFunctions.php');
$data = "";

function generateMislakeLead($ticketCreationResponse){
    return [
        'lm_form' => 18681,
        'lm_key' => "7fa3e74b41",
        'lm_redirect' => "no",
        'lm_supplier' => $_POST['agentId'],
        'name' => $_POST['customerName'],
        'phone' => $_POST['customerPhone'],
        'id' => $_POST['customerSsn'],
        'issueDate' => $_POST['issueDate'],
        'email' => $_POST['customerEmail'],
        'address' => $_POST['address'],
        'callCenter' => $_POST['callCenterName'],
        'ticketNumber' => $ticketCreationResponse['ticket']['id'],
        'zendeskLink' => 'https://ezfind-sherut.zendesk.com/agent/tickets/' .$ticketCreationResponse['ticket']['id'],
        'sellingChannel' => $_POST['sellingChannel'],
        'sellerName' => $_POST['userName'],
        'paymentSum' => $_POST['paymentSum'],
        'mislakaPaymentCount' => $_POST['paymentCount'],
        'customerCount' => $_POST['customerCount'],
        'customerType' => ($_POST['customerCount'] == 2 ? 'זוגי' : 'יחיד' ),
    ];
}

function generateCustomerPostData(){
    return [
        'lm_form' => '17993',
        'lm_key' => '6ebab5cef5',
        'lm_redirect' => 'no',
        /*'lm_supplier' => $agentId,*/
        'name' => $_POST['customerName'],
        'phone' => $_POST['customerPhone'],
        'id' => $_POST['customerSsn'],
        'issueDate' => $_POST['issueDate'],
        'email' => $_POST['customerEmail'],
        'address' => $_POST['address'],
        'callCenter' => $_POST['callCenterName']
    ];
}

function generateTicketComment(){
    global $data;
    if ($_POST['customerCount'] == 2){
        $data->comment = array(
            'body' =>   'מס\' ליד במע\':	 ' .$_POST['recordNumber'] . " \n" .
                'קישור ישיר לליד\':' . "https://crm.ibell.co.il/a/3328/leads/". $_POST['recordNumber']  ." \n" .
                'שם מלא:	' . $_POST['customerName'] . " \n" .
                'מס\' ת.ז.:' . $_POST['customerSsn'] . "\n" .
                'כתובת:' . $_POST['address'] . " \n" .
                'פרטי בן/בת זוג' .  " \n" .
                'שם מלא:' . $_POST['secondaryCustomerName'] . " \n" .
                'מס\' ת.ז.:' . $_POST['secondaryCustomerSsn'] . "\n" .
                'כתובת:' . $_POST['address'] . " \n"
        );
    }else{
        $data->comment = array(
            'body' =>   'מס\' ליד במע\':	 ' .$_POST['recordNumber'] . " \n" .
                'קישור ישיר לליד\':' . "https://crm.ibell.co.il/a/3328/leads/". $_POST['recordNumber']  ." \n" .
                'שם מלא:	' . $_POST['customerName'] . " \n" .
                'מס\' ת.ז.:' . $_POST['customerSsn'] . "\n" .
                'כתובת:' . $_POST['address'] . " \n"
        );
    }
}

/*open new Ticket*/
$ticketUrl = "https://ezfind-sherut.zendesk.com/api/v2/tickets.json";
$data->subject = "בדיקה במסלקה פנסיונית (" . $_POST['recordNumber'] . ")";

$data->custom_fields = array('114102615553' => 'מסלקות_פנסיוניות___בקשות_חדשות');
$data->requester = array(
    'email' => 'a3328c18712@emails.lead.im',
    'name' => 'LeadIm Proxy'
);
/*
$data->collaborators = getCollaboratorArrayById($crmAccount, $userEmail); */
generateTicketComment();
$data->collaborators = array( $_POST['userEmail'], "yaki@ezfind.co.il", "yariv.d@ezfind.co.il");

/*API to Zendesk to open the ticket*/
$create = json_encode(array('ticket' => $data)/*, JSON_UNESCAPED_UNICODE*/);
//fwrite($myfile, "return value from Zendesk API is " . print_r($create, true));

$username = 'yaki@tgeg.co.il/token';
$password = 'r0sQ2m9H37u6OOnmYagEM08cW11xKasCbNZspYaF';

$return = httpPostWithUserPassword($ticketUrl, $create, $username, $password);
$ticketCreationResponse = json_decode($return, true);



//create the mislaka
$mislakaPost = generateMislakeLead($ticketCreationResponse);
$newMislakaLeadId = openNewLead($mislakaPost);

$updateCustomerResponse = addOrCreateCustomerandUpdateNewSale($newMislakaLeadId, $_POST['customerPhone'], generateCustomerPostData());



?>
<div class="container" role="main" id="button_block">
    <div class="text-center">
        <img src="logo3.png" class="rounded">
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12 col-sm-12">
            <fieldset>
                <div class="col-xs-6 col-md-6 col-sm-6">
                    <a href="#" class="btn btn-success">הבקשה נשלחה כמו שצריך!</a>
                </div>
            </fieldset>
        </div>
    </div>
</div>

    </body>
</html>