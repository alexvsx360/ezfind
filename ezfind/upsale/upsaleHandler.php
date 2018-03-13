<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="../js/bootstrap.min.js" crossorigin="anonymous"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>הפניה נתפחה בהצלחה!</title>
</head>
<body>

<?php
/*
 * Functions
 * */
function generateTitle($customerCount){
    if ($customerCount == 1){ //מועמד ראשי
        return $_POST['customerName'] . " " . $_POST['customerSsn'] . " " . $_POST['operationType'] . " " .  $_POST['pedionType'] . " " . $_POST['insuranceCompany'];
    } else { //מועמד משני
        return $_POST['secondaryCustomerName'] . " " . $_POST['secondaryCustomerSsn'] . " " . $_POST['operationType'] . " " .  $_POST['pedionType'] . " " . $_POST['insuranceCompany'];
    }
}

function generateCommentBody($customerCount){
    $customerName = ($customerCount == 1) ? $_POST['customerName'] : $_POST['secondaryCustomerName'];
    $customerSsn = ($customerCount == 1) ? $_POST['customerSsn'] : $_POST['secondaryCustomerSsn'];
    return 'שם מלא: ' . $customerName . " \n" .
    'תעודת זהות: ' . $customerSsn.  " \n" .
    'מוקד: ' . $_POST['callCenterName'] . " \n" .
    'איש מכירות: ' . $_POST['userName'] . " \n" .
    'פעולה לביצוע: ' . $_POST['operationType'] . " \n" .
    'סוג הקופה: ' . $_POST['pedionType'] . " \n" .
    'הגוף המנהל: ' . $_POST['insuranceCompany'] . " \n" .
    'מספר הקופה: ' . $_POST['programNumber'] . " \n" .
    'מעמד הקופה: ' . $_POST['programStatus'] . " \n" .
    'סכום לפדיון: ' . $_POST['pedionSum'] . " \n" .
    'האם הלקוח מודע לתשלום מס 35%?: ' . $_POST['taxAware'] . " \n" .
    'קישור לרשומת הליד המקורי (ממוקד המכירות) : ' . 'https://crm.ibell.co.il/a/3328/leads/' . $_POST['recordNumber'] . " \n\n" .
    'הערות להצעה: ' . $_POST['insuranceComment'];
}

function generatePedionLead($ticketNumber){
    return [
        'lm_form' => 19648,
        'lm_key' => "72c23068db",
        'lm_redirect' => "no",
        'lm_supplier' => $_POST['agentId'],
        'name' => $_POST['customerName'],
        'phone' => $_POST['customerPhone'],
        'id' => $_POST['customerSsn'],
        'issueDate' => $_POST['issueDate'],
        'email' => $_POST['customerEmail'],
        'address' => $_POST['address'],
        'callCenter' => $_POST['callCenterName'],
        'ticketNumber' => $ticketNumber,
        'zendeskLink' => 'https://ezfind-sherut.zendesk.com/agent/tickets/' . $ticketNumber,
        'sellerName' => $_POST['userName'],
        'paymentSum' => $_POST['paymentSum'],
        'mislakaPaymentCount' => $_POST['paymentCount'],
        'pedionType' => $_POST['pedionType'],
        'insuranceCompany' => $_POST['insuranceCompany'],
        'programNumber' => $_POST['programNumber'],
        'pedionSum' => $_POST['pedionSum'],
        'programStatus' => $_POST['programStatus'],
        'taxAware' => $_POST['taxAware'],
        'insuranceComment' => $_POST['insuranceComment'],
    ];
}

function generateCustomerPostData(){
    return [
        'lm_form' => '17993',
        'lm_key' => '6ebab5cef5',
        'lm_redirect' => 'no',
        'name' => $_POST['customerName'],
        'phone' => $_POST['customerPhone'],
        'id' => $_POST['customerSsn'],
        'issueDate' => $_POST['issueDate'],
        'email' => $_POST['customerEmail'],
        'address' => $_POST['address'],
        'callCenter' => $_POST['callCenterName']
    ];
}

/*End of FUNCTIONS*/
?>



<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/20/2017
 * Time: 3:32 PM
 */

// load Composer
require '../../vendor/autoload.php';
include_once ('../../generalUtilities/functions.php');
include_once ('../../generalUtilities/leadImFunctions.php');
$data = "";
use Zendesk\API\HttpClient as ZendeskAPI;

$subdomain = "ezfind-sherut";
$username  = "yaki@tgeg.co.il";
$token     = "r0sQ2m9H37u6OOnmYagEM08cW11xKasCbNZspYaF"; // replace this with your token

$client = new ZendeskAPI($subdomain, $username);
$client->setAuth('basic', ['username' => $username, 'token' => $token]);
$LOGGER = fopen("log.txt", "a");


/*save the file to the directory */
$info = pathinfo($_FILES['file']['name']);
$ext = $info['extension']; // get the extension of the file
$newname = "upsale_doc_" . $_POST['recordNumber'] ."." .$ext;

$target = '../documents/'.$newname;
move_uploaded_file( $_FILES['file']['tmp_name'], $target);


//save the uploaded file as zendesk attachment
$attachment = $client->attachments()->upload([
    'file' => $target,
    'type' => $_FILES['file']['type'],
]);


/*
 * 1. build the ticket
 * 2. add record to DB
 * 3. display result ot user*/

/*
 * customerCount = 1 ==> מועמד ראשי
 * customerCount = 2 ==> מועמד משני
 * */
$customerCount = $_POST['customerCount'];

$newTicket = $client->tickets()->create([
    'subject'  => generateTitle($customerCount),
    'custom_fields'  => [
        '114102615553' => 'בקשות_חדשות',
        '114102615353' => $_POST['operationType'],
        '114102602414' => $_POST['pedionType'],
    ],
    'requester' => [
        'email' => $_POST['userEmail'],
        'name' => $_POST['userName']
    ],
    'collaborators' =>[$_POST['userEmail'], 'yariv.d@ezfind.co.il'],
    'comment'  => [
        'body' => generateCommentBody($customerCount),
        'uploads'   => [$attachment->upload->token, $attachment->upload->token]
    ],
]);


//echo $newTicket->ticket->id;

//create the Lead
$pedionPostData = generatePedionLead($newTicket->ticket->id);
$newPedionLead = openNewLead($pedionPostData);
$updateCustomerResponse = addOrCreateCustomerandUpdateNewSale($newPedionLead, $_POST['customerPhone'], generateCustomerPostData());

//update the new lead in d
$client->tickets()->update($newTicket->ticket->id,[
    'comment' => [
        'body' => 'קישור לרשומת הליד במסד נתונים (תפעול ושירות לקוחות) : ' . 'https://crm.ibell.co.il/a/3694/leads/' . $newPedionLead . " \n\n",
    ]
]);

echo $newTicket->ticket->id;

?>
<div class="container" role="main" id="button_block">
    <div class="text-center">
        <img src="../logo3.png" class="rounded">
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