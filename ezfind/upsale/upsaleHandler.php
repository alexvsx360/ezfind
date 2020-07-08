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

$basicDataForLead=

    [ 'lm_supplier' => $_POST['agentId'],
    'name' => $_POST['customerName'],
    'phone' => $_POST['customerPhone'],
    'id' => $_POST['customerSsn'],
    'issueDate' => $_POST['issueDate'],
    'email' => $_POST['customerEmail'],
    'address' => $_POST['address'],
    'callCenter' => $_POST['callCenterName'],
    'paymentSum' => $_POST['paymentSum'],
    'mislakaPaymentCount' => $_POST['paymentCount'],
    'pedionType' => $_POST['pedionType'],
    'insuranceCompany' => $_POST['insuranceCompany'],
    'programNumber' => $_POST['programNumber'],
    'insuranceComment' => $_POST['insuranceComment'],
     'sellerName' => $_POST['userName'],
    ];


function generateTitle($customerCount){
if($_POST['typeForm'] == 'update_details'){
    if ($customerCount == 1){ //מועמד ראשי
        return $_POST['customerName'] . " " . $_POST['customerSsn'] . " " . $_POST['operationType'] . " " ;
    } else { //מועמד משני
        return $_POST['secondaryCustomerName'] . " " . $_POST['secondaryCustomerSsn'] . " " . $_POST['operationType'] . " " ;
    }
}else{
    if ($customerCount == 1){ //מועמד ראשי
        return $_POST['customerName'] . " " . $_POST['customerSsn'] . " " . $_POST['operationType'] . " " .  $_POST['pedionType'] . " " . $_POST['insuranceCompany'];
    } else { //מועמד משני
        return $_POST['secondaryCustomerName'] . " " . $_POST['secondaryCustomerSsn'] . " " . $_POST['operationType'] . " " .  $_POST['pedionType'] . " " . $_POST['insuranceCompany'];
    }
}

}
function echoProgramDetails(){
    $counter = 0;
    $allDetails="";
    if($_POST['typeForm'] == 'update_details'){
        $pedionType = $_POST['pedionType'];
        $insuranceCompany = $_POST['insuranceCompany'];
        $programNumber = $_POST['programNumber'];
        $length=count($pedionType);
        for($i=0;$i<$length;$i++){
            $counter++;
            $allDetails .=$counter.".".' הגוף המנהל:'." ".$insuranceCompany[$i] ."  "." . ".' סוג הקופה:'." ".$pedionType[$i] ." "." .".' מספר הקופה:'." ".$programNumber[$i] . " \n";
        }
        return $allDetails;
    }
    if($_POST['typeForm'] == 'update_beneficiaries'){
        $fullName= $_POST['fullName'];
        $IDNumber=$_POST['IDNumber'];
        $relation =$_POST['relation'];
        $percentBenefit =$_POST['percentBenefit'];
        $allDetails="";
        $length=count($fullName);
        for($i=0;$i<$length;$i++){
            $counter++;
            $allDetails .= $counter.".". ' שם מלא:'." ".$fullName[$i] ."  "." . ".' מס ת.ז:'." ".$IDNumber[$i] ."  "." . ".' קרבה:'." ".$relation[$i] ." "." .".' הטבה באחוזים:'." ".$percentBenefit[$i]. " \n";
        }
        return $allDetails;
    }
}
$programDetails = echoProgramDetails();

function generatePedionLead($ticketNumber){
    global $programDetails;
    global $basicDataForLead;
    switch ($_POST['typeForm']){
        case 'pedion':
              return
                array_merge($basicDataForLead,
                    ['lm_form' => 19648,
                     'lm_key' => "72c23068db",
                     'ticketNumber' => $ticketNumber,
                     'zendeskLink' => 'https://ezfind-sherut.zendesk.com/agent/tickets/' . $ticketNumber,
                     'pedionSum' => $_POST['pedionSum'],
                     'programStatus' => $_POST['programStatus'],
                     'taxAware' => $_POST['taxAware']
                    ]);
        case 'loan':
            return
                array_merge($basicDataForLead,
                    [ 'lm_form' => 19904,
                    'lm_key' => "bada9387d2",
                    'ticketNumber' => $ticketNumber,
                    'zendeskLink' => 'https://ezfind-sherut.zendesk.com/agent/tickets/' . $ticketNumber,
                    'sellerName' => $_POST['userName'],
                    'loanAmount' => $_POST['loanAmount'],
                    'loanMontlyPeriod' => $_POST['loanMontlyPeriod']
                    ]);
        case 'pedion_hishtalmut':
            return
                array_merge($basicDataForLead,
                    [ 'lm_form' => 	19944,
                    'lm_key' => "43615b9aeb",
                    'programStatus' => $_POST['programStatus'],
                    'ticketNumber' => $ticketNumber,
                    'zendeskLink' => 'https://ezfind-sherut.zendesk.com/agent/tickets/' . $ticketNumber,
                    'pedionSum' => $_POST['pedionAmount'],
                ]);
        case 'update_details':
            return
                array_merge($basicDataForLead,
                    [ 'lm_form' => 	19939,
                    'lm_key' => "4bca6e8f3a",
                    'ticketNumber' => $ticketNumber,
                    'zendeskLink' => 'https://ezfind-sherut.zendesk.com/agent/tickets/' . $ticketNumber,
                    'insuranceComment' =>  'פרטי הקופות:'. " \n". $programDetails. " \n"."הערות:". " \n".$_POST['insuranceComment'],
                ]);
        case  'update_beneficiaries':
            return
                array_merge($basicDataForLead,
                    [ 'lm_form' => 	19940,
                    'lm_key' => "29b09bfb8c",
                    'ticketNumber' => $ticketNumber,
                    'zendeskLink' => 'https://ezfind-sherut.zendesk.com/agent/tickets/' . $ticketNumber,
                    'insuranceComment' => $_POST['insuranceComment'],
                    'mutavim'=>$programDetails,
                    ]);
        case 'missing_deposits':
            return
                array_merge($basicDataForLead,
                    ['lm_form' => 	19942,
                    'lm_key' => "c68dc5d3f4",
                    'ticketNumber' => $ticketNumber,
                    'zendeskLink' => 'https://ezfind-sherut.zendesk.com/agent/tickets/' . $ticketNumber,
                    'reference_type' => $_POST['reference_type'],
                    'employer_name' => $_POST['employer_name'],
                    ]);
    }

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
include_once('../../generalUtilities/classes/ticket_classes/CreateTicket.php');
$data = "";
use Zendesk\API\HttpClient as ZendeskAPI;

$subdomain = "ezfind-sherut";
$username  = "yaki@tgeg.co.il";
$token     = "r0sQ2m9H37u6OOnmYagEM08cW11xKasCbNZspYaF"; // replace this with your token
$client = new ZendeskAPI($subdomain, $username);
$client->setAuth('basic', ['username' => $username, 'token' => $token]);
$LOGGER = fopen("log.txt", "a");


/*save the file to the directory */

$files = $_FILES["file"]["name"];
$extension_files = array();
$new_name_files =  array();
$array_types = array();
$array_targets = array();

//to get the extension of the file.
foreach ($files as $index => $file_name) {
    $extension =  pathinfo($file_name,PATHINFO_EXTENSION);
    array_push($extension_files,$extension);}

//to define a new name for each file.
foreach ($extension_files as $i => $extension_name) {
    $new_name ="upsale_doc_" . $_POST['recordNumber'].".".$i.".".$extension_name;
    array_push($new_name_files, $new_name);
}

//send to new directory the files and save the new directory and types in arrays.
foreach ($new_name_files as $i =>$newname) {
    move_uploaded_file($_FILES["file"]["tmp_name"][$i],'../documents/'.$newname);
    $target = '../documents/'.$newname;
    array_push($array_targets, $target);
    $type = $_FILES['file']['type'][$i];
    array_push($array_types, $type);
};
//save the uploaded file as zendesk attachment

$upload_token = "";
foreach ($files as $i => $files) {
    $params = array(
        'file' => $array_targets[$i],
        'type' => $array_types[$i],
        'name' =>  $files
);
    if (isset($upload_token)) {
        $params['token'] = $upload_token;
    }
    $attachment = $client->attachments()->upload($params);
    $upload_token = $attachment->upload->token;
}


/*
 * 1. build the ticket
 * 2. add record to DB
 * 3. display result ot user*/

/*
 * customerCount = 1 ==> מועמד ראשי
 * customerCount = 2 ==> מועמד משני
 * */
$customerCount = $_POST['customerCount'];
$Ticket = new CreateTicket();
$Ticket->createTicket($_POST['typeForm'], $customerCount, $programDetails);

$customerPhone = normalizePhone($_POST['customerPhone']);
$customerSsn = normalizeSsn($_POST['customerSsn']);

$newTicket = $client->tickets()->create([
    'tags' => [$customerPhone, $customerSsn],
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
    'collaborators' =>[$_POST['userEmail'], ""],
    'comment'  => [
        'body' => $Ticket->getTicket(),
        'uploads'   => [$upload_token]
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
httpGet('https://ibell.frb.io//api/leadim/economicGrowth/event/bchirimNewSale?recordId=' . $_POST['recordNumber'].'&newLead='.$newPedionLead);

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