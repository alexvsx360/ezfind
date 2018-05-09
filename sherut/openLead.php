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
require '../vendor/autoload.php';
include_once('../generalUtilities/classes/ticket_classes/CreateTicket.php');
use Zendesk\API\HttpClient as ZendeskAPI;
$subdomain = "ezfind";
$username  = "yaki@ezfind.co.il";
$token     = "Bdt7m6GAv0VQghQ6CRr81nhCMXcjq2fIfZHwMjMW"; // replace this with your token
$client = new ZendeskAPI($subdomain, $username);
$client->setAuth('basic', ['username' => $username, 'token' => $token]);
$LOGGER = fopen("log.txt", "a");

$configTypes = include('configTypes.php');
$dataTicket = "";
$collaborators = "";
$callCenterManagerMail = "";
$callCenterManger = "";


function updateTicket($collaborators,$dataTicket,$newLeadId){
    global $client;
    global $callCenterManagerMail;
    global $callCenterManger;
    // Update a ticket
    $client->tickets()->update($_POST['cancelTicketNumber'],[
        'requester' =>array(
            'name' => $callCenterManger,
            'email' => $callCenterManagerMail
        ),
        'subject' => "הלקוח מבקש לבטל:"." ".$_POST['customerName']." ".$_POST['customerSsn']." ".$_POST['cancelInsuranceCompany']." ".$_POST['cancelPolicyType'],
        'collaborators' => $collaborators,
        'custom_fields' => array(
            '114096462111' => "תור_ביטולים",
            '114096335892' => $_POST['callCenterName'],                 // מוקד ביטוח
            '114096371131' => $_POST['cancelPolicyType'],                                                      //כיסוי ביטוחי
            '114096335852' => $_POST['cancelInsuranceCompany'],                                // חברת ביטוח
            '114096335872' => $_POST['cancelMonthlyPremia']                                         //פרמיה
            //'114096405631' => $_POST['cancelPolicyNumber']  ,
            //'114096470871' => ""

        ),
        'status'  => 'pending',
        'comment'=> $dataTicket." \n".
                    'קישור לרשומת הליד במסד נתונים (תפעול ושירות לקוחות) : ' . 'https://crm.ibell.co.il/a/3694/leads/' . $newLeadId
    ]);
}
function addSherutLeadToCustomerByLeadType($leadType,$newLeadId,$customerSsn,$crmAccountNumber){
    if($leadType == 'bitul'){
        $searchBy = 102092;//number field of teudat zeut
        $campaign  = 17992;//lakochot
        $CustomerLead = leadInSearchLead($crmAccountNumber, $searchBy, $customerSsn, $campaign);
        $CustomerLeadId = $CustomerLead['lead_id'];
        addSherutLeadToCustomer($CustomerLeadId, $newLeadId);

    }else{
        return  addSherutLeadToCustomer($_POST['recordNumber'], $newLeadId);
    }
};

function generatePigurLeadPostData(){
    return [
        'lm_form' => 18492,
        'lm_key' => "c77fa08625",
        'lm_redirect' => "no",
        'name' => $_POST['customerName'],
        'phone' => $_POST['customerPhone'],
        'id' => $_POST['customerSsn'],
        'email' => $_POST['customerEmail'],
        'callCenter' => $_POST['callCenterName'],
        'insuranceCompanyPigur' => $_POST['insuranceCompany'],
        'pigurPolicy' => $_POST['pigurPolicy'],
        'premiaBepigur' => $_POST['premiaBepigur'],
        'pigurMonths' => $_POST['pigurMonths'],
        'linkToCustomer' => 'https://crm.ibell.co.il/a/3694/leads/' . $_POST['recordNumber']
    ];
}
function generateBitulLeadData(){
    return [
        'lm_form' => 18600,
        'lm_key' => "b15219b165",
        'lm_redirect' => "no",
        'name' => $_POST['customerName'],
        'phone' => $_POST['customerPhone'],
        'id' => $_POST['customerSsn'],
        'email' => $_POST['customerEmail'],
        'callCenter' => $_POST['callCenterName'],
        'cancelDate' => strtotime($_POST['cancelDate']),
        'cancelType' => $_POST['cancelType'],
        'cancelPolicyType' => $_POST['cancelPolicyType'],
        'cancelTicketNumber' => $_POST['cancelTicketNumber'],
        'cancelLink' => "https://ezfind.zendesk.com/agent/tickets/" . $_POST['cancelTicketNumber'],
        'cancelMonthlyPremia' => $_POST['cancelMonthlyPremia'],
        'cancelInsurenceCompany' => $_POST['cancelInsuranceCompany'],
        'salesMan' => $_POST['salesMan'],
        'leadIdToCancel' => $_POST['leadId'],
        'cancelPolicyNumber' => $_POST['cancelPolicyNumber'],
        'linkToCustomer' => 'https://crm.ibell.co.il/a/3694/leads/' . $_POST['recordNumber']
    ];
}

function generateDoublePayLeadData(){
    return [
        'lm_form' => 18602,
        'lm_key' => "8435ae41bc",
        'lm_redirect' => "no",
        'name' => $_POST['customerName'],
        'phone' => $_POST['customerPhone'],
        'id' => $_POST['customerSsn'],
        'email' => $_POST['customerEmail'],
        'callCenter' => $_POST['callCenterName'],
        'insuranceStarDate' => strtotime($_POST['insuranceStarDate']),
        'cancelStartDate' => strtotime($_POST['cancelStartDate']),
        'isCancelLetter' => $_POST['isCancelLetter'],
        'cancelInsuranceCompany' => $_POST['cancelInsuranceCompany'],
        'doublePaymentCount' => $_POST['doublePaymentCount'],
        'linkToCustomer' => 'https://crm.ibell.co.il/a/3694/leads/' . $_POST['recordNumber']
    ];
}

if ($_POST){
    $newLeadId ="";
    $openLeadData = "";
    $newLeadId = "";
    $result =0;
    $recordNumber = $_POST["recordNumber"];
    $crmAccountNumber = $_POST["crmAccountNumber"];
    $leadType = $_POST['leadType'] ;
    $customerSsn = $_POST['customerSsn'];
    $customerName = $_POST['customerName'];

//if policy from "masad yashan" there isn't 'callCenterManager' so take it by maping by callCenterName
    if($_POST['callCenterManager']!== ""){
        $callCenterManger = $_POST['callCenterManager'];
        $callCenterManagerMail  = $configTypes['callCenterManagerMail'][$_POST['callCenterManager']];
    }else{
        if ($_POST['callCenterName']!== ""){
        $callCenterManger = $configTypes['callCenterManagerName'][$_POST['callCenterName']];
        $callCenterManagerMail  = $configTypes['callCenterManagerMail'][$callCenterManger];
        }else{
            $callCenterManger = "doron";
            $callCenterManagerMail = "doron1098@tgeg1.onmicrosoft.com";
        }
    }

    //if supplier elad shimony/ callcenter not exist/ supplier not exist

    if ($_POST['supplier'] == '14416'||$_POST['supplier'] == 0 || $callCenterManger == null){//elad shimoni
        $collaborators = ["michael@tgeg.co.il"];//
        $dataTicket  = "איש המכירות לא קיים עובר אוטומטית למחלקת שימור";
        $callCenterManger = "doron";
        $callCenterManagerMail = "doron1098@tgeg1.onmicrosoft.com";
    }else{
        $collaborators = ["michael@tgeg.co.il"]; /*/mail to supllier/*/
        $dataTicket =
            "הי "." ".$callCenterManger." ".","." ". $_POST['salesMan']. " \n" .
            "התקבלה בקשה לביטול מאת לקוח : "." ".$_POST['customerName']. " \n" .
            "ת.ז :"." ". $_POST['customerSsn']. " \n" .
            "חברת ביטוח :"." ". $_POST['cancelInsuranceCompany']. " \n" .
            "כיסוי :"." ". $_POST['cancelPolicyType']. " \n" .
            "פרמיה חודשית :".$_POST['cancelMonthlyPremia']. " \n" .
            "יש לכם SLA של חמישה ימים קלנדרים לטפל בבקשת הביטול אחרת הטיקט נסגר והבקשה עוברת לשימור ". " \n" .
            "בהצלחה !";
    }
    switch ($_POST['leadType']){
    case 'pigur':
            $openLeadData = generatePigurLeadPostData();
        break;
        case 'bitul':
            $openLeadData = generateBitulLeadData();
            $status = "107637";//התקבלה בקשה לביטול
            $updateFieldsKeyValue = [107639 => "התקבלה_בקשה_לביטול"];
            leadImUpdateLead($crmAccountNumber, $recordNumber, $updateFieldsKeyValue, false,$status);
            break;
        case 'doublePay':
            $openLeadData = generateDoublePayLeadData();
            break;
        default:
        echo '$_POST[\'leadType\'] is not set!! ' . $_POST['leadType'];
        break;
    }
    $newLeadId = openNewLead($openLeadData);
    $result = addSherutLeadToCustomerByLeadType($leadType,$newLeadId,$customerSsn,$crmAccountNumber);

    if ($_POST['leadType']== 'bitul'){
       updateTicket($collaborators,$dataTicket,$newLeadId);
    }


}
?>
<div class="container" role="main" id="button_block">
    <div class="text-center">
        <img src="logo3.png" class="rounded">
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12 col-sm-12">
            <fieldset>
                <div class="col-xs-6 col-md-6 col-sm-6">
                    <a target="_blank" href="https://crm.ibell.co.il/a/3694/leads/<?php print $_POST['recordNumber'] ?>" class="btn btn-success">לצפיה בפוליסה המקורית </a>
                </div>
                <div class="col-xs-6 col-md-6 col-sm-6">
                    <a target="_blank" href="https://crm.ibell.co.il/a/3694/leads/<?php print $newLeadId ?>" class="btn btn-success">לצפיה בפניה שנפתחה</a>
                </div>
            </fieldset>
        </div>
    </div>
</div>

    </body>
</html>