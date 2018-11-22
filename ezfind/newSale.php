<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
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

// load Composer
require '../vendor/autoload.php';
include_once ('../generalUtilities/functions.php');
include_once ('../generalUtilities/leadImFunctions.php');
$data = "";
use Zendesk\API\HttpClient as ZendeskAPI;

$subdomain = "ezfind-sherut";
$username  = "yaki@tgeg.co.il";
$token     = "r0sQ2m9H37u6OOnmYagEM08cW11xKasCbNZspYaF"; // replace this with your token

$client = new ZendeskAPI($subdomain, $username);
$client->setAuth('basic', ['username' => $username, 'token' => $token]);


$LOGGER = fopen("log.txt", "a");
printRequestToFile($LOGGER);
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
        'name' => $_POST['customerName'],
        'phone' => $_POST['customerPhone'],
        'id' => $_POST['customerSsn'],
        'issueDate' => $_POST['issueDate'],
        'email' => $_POST['customerEmail'],
        'address' => $_POST['address'],
        'callCenter' => $_POST['callCenterName']
    ];
}

function getCallCenterManagerEmail(){
    if ($_POST['callCenterName'] == 'ezfind'){
        return "ziv.s@ezfind.co.il";
    }
    return 'shay@ezloans.co.il';
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
// init the Zendesk Client


/*save the file to the directory */
$info = pathinfo($_FILES['file']['name']);
$ext = $info['extension']; // get the extension of the file
$newname = "Power_of_Attorney_" . $_POST['recordNumber'] ."." .$ext;

$target = 'documents/'.$newname;
move_uploaded_file( $_FILES['file']['tmp_name'], $target);


//save the uploaded file as zendesk attachment
$attachment = $client->attachments()->upload([
    'file' => $target,
    'type' => $_FILES['file']['type'],
]);


//open new Ticket
$ticketUrl = "https://ezfind-sherut.zendesk.com/api/v2/tickets.json";
$data->subject = "בדיקה במסלקה פנסיונית (" . $_POST['recordNumber'] . ")";

$data->custom_fields = array('114102615553' => 'מסלקות_פנסיוניות___בקשות_חדשות');
$data->requester = array(
    'email' => 'a3328c18712@emails.lead.im',
    'name' => 'LeadIm Proxy'
);

generateTicketComment();
$data->collaborators = array( $_POST['userEmail'], "yaki@ezfind.co.il", getCallCenterManagerEmail());

//API to Zendesk to open the ticket
$create = json_encode(array('ticket' => $data));
//fwrite($myfile, "return value from Zendesk API is " . print_r($create, true));

$username = 'yaki@tgeg.co.il/token';
$password = 'r0sQ2m9H37u6OOnmYagEM08cW11xKasCbNZspYaF';

$return = httpPostWithUserPassword($ticketUrl, $create, $username, $password);
$ticketCreationResponse = json_decode($return, true);

// Update a ticket
$client->tickets()->update($ticketCreationResponse['ticket']['id'],[
    'comment' => [
        'body' => 'מצ"ב ייפוי כח',
        'uploads'   => [$attachment->upload->token]
        ]
]);


//create the mislaka
$mislakaPost = generateMislakeLead($ticketCreationResponse);
$newMislakaLeadId = openNewLead($mislakaPost);

$updateCustomerResponse = addOrCreateCustomerandUpdateNewSale($newMislakaLeadId, $_POST['customerPhone'], generateCustomerPostData());



/******************************START VOD REQUEST*************************************************/
function getAccessToken() {
    $postData = [
        'email' => 'yaki@tgeg.co.il',
        'password' => 'Alma@102030'
    ];
    $response = httpPostContentTypeJson('https://api.treepodia.com/rest/vod/v032016/auth', json_encode($postData));
    return json_decode($response);
}

function validateVodRequest (){
    //insert validation to this the request
    //first check all variables exists and have value in it
    if ( isset($_POST['birthDate']) && !empty($_POST['birthDate']) &&
         isset($_POST['customerSsn']) && !empty($_POST['customerSsn']) &&
         isset($_POST['customerFirstName']) && !empty($_POST['customerFirstName']) &&
         isset($_POST['employyType']) && !empty($_POST['employyType']) &&
         isset($_POST['jobsCount']) && !empty($_POST['jobsCount']) &&
         isset($_POST['sex']) && !empty($_POST['sex'])
    ) {
        //all variable exists and have values
        if ( !$_POST['jobsCount'] > 0 ) return false;
        if (!$_POST['callCenterName'] == "ezloans") return false;

        return true;
    }
    return false;
}

$isPassedVodValidation = validateVodRequest();
$isVideoRequestSuccess = false;
if ($isPassedVodValidation){
    global $isVideoRequestSuccess;

    fwrite($LOGGER, "VOD request for sku " . $_POST['customerSsn'] . " Passed validation, starting to build VOD request\n");

    $accessToken = getAccessToken();

    $bDate = new DateTime();
    $bDate->setTimestamp($_POST['birthDate']);

    $vodPostData = [
        'accessToken' => $accessToken->accessToken,
        'sku' => $_POST['customerSsn'],
        'templateId' => 2, /// todo continue here
        'requestData' => array(
            'name' => $_POST['customerFirstName'],
            'fname' => $_POST['customerLastName'],
            'ssn' => $_POST['customerSsn'],
            'bDate' => $bDate->getTimestamp(),
            'EmployeeType' => $_POST['employyType'],
            'jobsCount' => $_POST['jobsCount'],
            'sex' => $_POST['sex']
        ),
        'callback' => array(
            'url' => 'https://ezfind.frb.io/treepodia/EzfindOnBoardingCallbackHandler.php',
            'method' => 'POST',
            'contentType' => 'application/json',
            'body' => "{\"requestId\":\"{requestId}\",\"videoUrl\":\"{videoUrl}\"}",
        )
    ];


    $url = 'https://api.treepodia.com/rest/vod/v032016/acc/UA-EZFIND/requests';

    $response = httpPostContentTypeJson($url, json_encode($vodPostData));
    fwrite($LOGGER,"VOD request for sku " . $_POST['customerSsn'] . " sent to Trepodioa VOD - response is: " . $response . "\n" );

    $response = json_decode($response);
    $isVideoRequestSuccess = ($response->status == "SUCCESS");
    if ($isVideoRequestSuccess){
        leadImUpdateLead(3328, $_POST['recordNumber'], [ 105347 => $response->id, 105346 => $_POST['customerSsn']], true);
    }
} else {
    fwrite($LOGGER,"VOD request for sku " . $_POST['customerSsn'] . " FAILED validation!!\n" . print_r($_REQUEST, TRUE) . "\n");
}

/******************************END VOD REQUEST*************************************************/


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