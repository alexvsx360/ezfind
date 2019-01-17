<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" h ref="css/bootstrap-theme.min.css">
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
include('../generalUtilities/functions.php');
include('../generalUtilities/leadImFunctions.php');
require '../vendor/autoload.php';
include_once('../generalUtilities/classes/ticket_classes/CreateTicket.php');

use Zendesk\API\HttpClient as ZendeskAPI;

$subdomain = "ezfind";
$username = "yaki@ezfind.co.il";
$token = "Bdt7m6GAv0VQghQ6CRr81nhCMXcjq2fIfZHwMjMW"; // replace this with your token
$client = new ZendeskAPI($subdomain, $username);
$client->setAuth('basic', ['username' => $username, 'token' => $token]);
$LOGGER = fopen("log.txt", "a");
$configTypes = include('configTypes.php');
//if policy from "masad yashan" there isn't 'callCenterManager' so take it by maping by callCenterName if there isnt callCenterName - doron
function setCallCenterMangerName()
{
    global $callCenterName;
    global $callCenterManger;
    global $configTypes;
    if ($callCenterManger !== "לא ידוע") {
        $callCenterManger = $callCenterManger;
    } else {
        if ($callCenterName !== "לא ידוע") {
            $callCenterManger = $configTypes['callCenterManagerName'][$callCenterName];
        } else {
            $callCenterManger = "דורון";
        }
    }
    return $callCenterManger;
}

function setCallCenterEmail()
{
    global $callCenterName;
    global $callCenterManger;
    global $configTypes;
    global $callCenterManagerEmail;
    if ($callCenterManger !== "לא ידוע") {
        $callCenterManagerEmail = $configTypes['callCenterManagerMail'][$callCenterManger];
    } else {
        if ($callCenterName !== "לא ידוע") {
            $callCenterManagerEmail = $configTypes['callCenterManagerMail'][$callCenterManger];
        } else {
            $callCenterManagerEmail = "doron1098@tgeg1.onmicrosoft.com";
        }
    }
    return $callCenterManagerEmail;
}

function InitiateDataFoTicket($supplierNameEmail)
{
    $callCenterManger = setCallCenterMangerName();
    global $savedInPastBy;
    global $moreDetailsOfBitul;
    global $cancelType;
    global $policyThreeMonthsPassed;
    global $viturShimur;
    global $tags;
    global $customerName;
    global $customerSsn;
    global $cancelInsurenceCompany;
    global $cancelPolicyType;
    global $actualPremia;
    global $collaborators;
    global $statusTicket;
    global $userName;
    global $userEmail;
    global $requesterName;
    global $requesterEmail;
    global $dataTicket;
    if ($supplierNameEmail[1] == "בקשה לביטול איש מכירות עזב") {
        $requesterName = $userName;
        $requesterEmail = $userEmail;
        $collaborators = ["michael@tgeg.co.il"];
        $statusTicket = 'solved';
        $dataTicket = "איש המכירות לא קיים עובר אוטומטית למחלקת שימור" . " \n" . " \n" .
            moreDetailsOfCancel($moreDetailsOfBitul, $cancelType, $savedInPastBy);
        $tags = [''];
    } else {
        $requesterName = $supplierNameEmail[1];
        $requesterEmail = $supplierNameEmail[0];
        $collaborators = [setCallCenterEmail(), "michael@tgeg.co.il"];
        $statusTicket = 'pending';
        $dataTicket =
            "הי " . " " . $callCenterManger . " " . "," . " " . $requesterName . " \n" .
            "התקבלה בקשה לביטול מאת לקוח : " . " " . $customerName . " \n" .
            "ת.ז :" . " " . $customerSsn . " \n" .
            "חברת ביטוח :" . " " . $cancelInsurenceCompany . " \n" .
            "כיסוי :" . " " . $cancelPolicyType . " \n" .
            "פרמיה חודשית בפועל:" . " " . $actualPremia . " \n" . " \n" .
            moreDetailsOfCancel($moreDetailsOfBitul, $cancelType, $savedInPastBy) . " \n" . " \n" .

            "יש לכם SLA של חמישה ימים קלנדרים לטפל בבקשת הביטול אחרת הטיקט נסגר והבקשה עוברת לשימור " . " \n" .
            "בהצלחה !";
        $tags = ['טיקט_ביטול_לאחר_עריכה', 'שימור_באחריות_המוקדים'];

    }
    if ($viturShimur == "נציג מוותר על זכות השימור" || $policyThreeMonthsPassed == "פוליסות מעל שלושה חודשים") {
        $requesterName = $userName;
        $requesterEmail = $userEmail;
        $collaborators = ["michael@tgeg.co.il"];
        $statusTicket = 'solved';
        $dataTicket = "נציג מכירות מוותר על זכות השימור" . " \n" . " \n" .
            moreDetailsOfCancel($moreDetailsOfBitul, $cancelType, $savedInPastBy);
        $tags = [''];
    }
    if ($policyThreeMonthsPassed == "פוליסות מעל שלושה חודשים") {
        $dataTicket = "פוליסה מעל שלושה חודשים, עובר אוטומטית למחלקת שימור" . " \n" . " \n" .
            moreDetailsOfCancel($moreDetailsOfBitul, $cancelType, $savedInPastBy);
    }

}

/**
 * @param $moreDetailsOfBitul
 * @param $cancelType
 * @param $savedInPastBy
 * @return string
 */
function moreDetailsOfCancel($moreDetailsOfBitul, $cancelType, $savedInPastBy): string
{
    return "פרטים נוספים: " . " \n" .
        "סיווג מכתב הביטול: " . $moreDetailsOfBitul . " \n" .
        "סוג הביטול: " . $cancelType . " \n" .
        'שומר בעבר ע"י: ' . $savedInPastBy;
}

function updeteLeadBitulInCrm($newLeadId, $supplierNameEmail)
{
    global $policyThreeMonthsPassed;
    global $viturShimur;
    if ($supplierNameEmail[1] == "בקשה לביטול איש מכירות עזב") {
        $status = "108086";
        $updateFieldsKeyValue = [107639 => "SLA_שימור_חלף", 111475 => "כן,בקשה_לביטול_איש_מכירות_עזב"];
        leadImUpdateLead(3694, $newLeadId, $updateFieldsKeyValue, true, $status);
    } elseif ($viturShimur == "נציג מוותר על זכות השימור") {
        $status = "108086";
        $updateFieldsKeyValue = [107639 => "SLA_שימור_חלף", 111475 => "כן,נציג_מוותר_על_זכות_השימור"];
        leadImUpdateLead(3694, $newLeadId, $updateFieldsKeyValue, true, $status);
    } elseif ($policyThreeMonthsPassed == "פוליסות מעל שלושה חודשים") {
        $status = "108086";
        $updateFieldsKeyValue = [107639 => "SLA_שימור_חלף", 111475 => "כן,פוליסות_מעל_שלושה_חודשים"];
        leadImUpdateLead(3694, $newLeadId, $updateFieldsKeyValue, true, $status);

    } else {
        $status = "103727";
        $updateFieldsKeyValue = [107639 => "הועבר_לנציג_מכירות"];
        leadImUpdateLead(3694, $newLeadId, $updateFieldsKeyValue, true, $status);
    }
}

function setDefaultValue($postValue)
{
    global $value;
    if ($postValue == "" || $postValue == null) {
        $value = "לא ידוע";
    } else {
        $value = $postValue;
    }
    return $value;
}

function updateTicket($collaborators, $dataTicket, $newLeadId)
{
    global $tags;
    global $client;
    global $cancelTicketNumber;
    global $customerName;
    global $customerSsn;
    global $phone;
    global $cancelInsurenceCompany;
    global $cancelPolicyType;
    global $callCenter;
    global $cancelMonthlyPremia;
    global $actualPremia;
    global $statusTicket;
    global $requesterEmail;
    global $requesterName;
    $allTags = array_merge($tags,[$customerSsn, $phone]);
    // Update a ticket
    $client->tickets()->update($cancelTicketNumber, [
        'tags' => $allTags,
        'requester' => array(
            'name' => $requesterName,
            'email' => $requesterEmail
        ),
        'subject' => "הלקוח מבקש לבטל:" . " " . $customerName . " " . $customerSsn . " " . $cancelInsurenceCompany . " " . $cancelPolicyType,
        'collaborators' => $collaborators,
        'custom_fields' => array(
            '114096462111' => "תור_ביטולים",
            '114096335892' => $callCenter,                 // מוקד ביטוח
            '114096371131' => $cancelPolicyType,                                                      //כיסוי ביטוחי
            '114096335852' => $cancelInsurenceCompany,                                // חברת ביטוח
            '114096335872' => $cancelMonthlyPremia,                                       //פרמיה
            '114096470871' => $actualPremia,
            '114101645711' => "ביטולים",
            '360005283771' => date('Y-m-d', strtotime(' + 6 days'))

        ),
        'assignee_id' => '360057374072',
        'status' => $statusTicket,
        'comment' => $dataTicket . " \n" .
            'קישור לרשומת הליד במסד נתונים (תפעול ושירות לקוחות) : ' . 'https://crm.ibell.co.il/a/3694/leads/' . $newLeadId
    ]);
}

function addSherutLeadToCustomerByLeadType($leadType, $newLeadId, $customerSsn, $crmAccountNumber)
{
    if ($leadType == 'bitul') {
        $searchBy = 102092;//number field of teudat zeut
        $campaign = 17992;//lakochot
        $CustomerLead = leadInSearchLead($crmAccountNumber, $searchBy, $customerSsn, $campaign);
        $CustomerLeadId = $CustomerLead['lead_id'];
        addSherutLeadToCustomer($CustomerLeadId, $newLeadId);

    } else {
        return addSherutLeadToCustomer($_POST['recordNumber'], $newLeadId);
    }
}

;

function generatePigurLeadPostData()
{
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

function generateBitulLeadData($supplierNameEmail, $extraDetailsToCancel)
{
    $postData = [
        'lm_form' => 18600,
        'lm_key' => "b15219b165",
        'lm_redirect' => "no",
        'lm_supplier' => $supplierNameEmail[2],
        'name' => $_POST['customerName'],
        'phone' => $_POST['customerPhone'],
        'id' => $_POST['customerSsn'],
        'email' => $_POST['customerEmail'],
        'callCenter' => $_POST['callCenterName'],
        'cancelDate' => strtotime($_POST['cancelDate']),
//        'cancelType' => $_POST['cancelType'],
        'cancelPolicyType' => $_POST['cancelPolicyType'],
        'cancelTicketNumber' => $_POST['cancelTicketNumber'],
        'cancelLink' => "https://ezfind.zendesk.com/agent/tickets/" . $_POST['cancelTicketNumber'],
        'cancelMonthlyPremia' => $_POST['cancelMonthlyPremia'],
        'cancelInsurenceCompany' => $_POST['cancelInsuranceCompany'],
        'salesMan' => $_POST['salesMan'],
        'leadIdToCancel' => $_POST['leadId'],
        'cancelPolicyNumber' => $_POST['cancelPolicyNumber'],
        'linkToCustomer' => 'https://crm.ibell.co.il/a/3694/leads/' . $_POST['recordNumber'],
        'moreDetailsOfBitul' => $_POST["moreDetailsOfBitul"],
        'savedInPastBy' => $_POST["savedInPastBy"]
    ];
    return array_merge($postData, $extraDetailsToCancel);
}

function generateDoublePayLeadData()
{
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


function getArrNumFieldCancelType($configTypes)
{
    $typeOfCancelArr = [];
    foreach ($_POST['cancelType'] as $key => $val) {
        $typeOfCancel = $configTypes["typeOfCancel"][$val];
        array_push($typeOfCancelArr, $typeOfCancel);
    }
    return $typeOfCancelArr;
}



function getExtraDetailsToCancel($crmAccountNumber, $recordNumber)
{

    try {
        $origPolicy = leadImGetLead($crmAccountNumber, $recordNumber);
        $dateTime = new DateTime();
        $dateTime1 = new DateTime();
        $policyProductionDate = $dateTime->setTimestamp($origPolicy['lead']['fields']['102218']);
        $insuranceStartDateAsTime = $dateTime1->setTimestamp($origPolicy['lead']['fields']['102140']);
        $cancelReceivedDateAsTime = new DateTime();
        $diffHafakaAndBitul = $cancelReceivedDateAsTime->diff($policyProductionDate);
        //echo $diffHafakaAndBitul->format('%m months');
        $record = array(
            'hadCancelLetter' => $origPolicy['lead']['fields']['102137'] == 102138 ? 'כן' : 'לא',
            'origLeadCampaig' => $origPolicy['lead']['fields']['110283'],
            'origLeadSupplier' => $origPolicy['lead']['fields']['110284'],
            'payingWidth' => $origPolicy['lead']['fields']['106839'],
            'premia' => $origPolicy['lead']['fields']['100100'],
            'actualPremia' => $origPolicy['lead']['fields']['102416'],
            'policyLiveMonth' => $diffHafakaAndBitul->y == 0 ? $diffHafakaAndBitul->format('%m') : ((12 * $diffHafakaAndBitul->y) + $diffHafakaAndBitul->format('%m')),
            'policyLiveDays' => $diffHafakaAndBitul->format('%a'),
        );
    } catch (Exception $e) {
        return [];
    }
    return $record;

}

if ($_POST) {
    $cancelTypeNumFieldAsArr = "";
    $torAvoda = "";
    $tags = "";
    $statusTicket = "";
    $dataTicket = "";
    $collaborators = "";
    $callCenterManagerEmail = "";
    $requesterEmail = "";
    $requesterName = "";
    $newLeadId = "";
    $openLeadData = "";
    $result = 0;
    $recordNumber = $_POST["recordNumber"];
    $crmAccountNumber = $_POST["crmAccountNumber"];
    $leadType = $_POST['leadType'];
    $userEmail = setDefaultValue($_POST['userEmail']);
    $userName = setDefaultValue($_POST['userName']);
    $callCenterManger = setDefaultValue($_POST['callCenterManger']);
    $customerName = setDefaultValue($_POST['customerName']);
    $phone = setDefaultValue($_POST['customerPhone']);
    $phone = normalizePhone($phone);
    $id = setDefaultValue($_POST['customerSsn']);
    $email = setDefaultValue($_POST['customerEmail']);
    $callCenterName = setDefaultValue($_POST['callCenterName']);
    $cancelDate = setDefaultValue($_POST['cancelDate']);
    $cancelPolicyType = setDefaultValue($_POST['cancelPolicyType']);
    $cancelTicketNumber = setDefaultValue($_POST['cancelTicketNumber']);
    $cancelLink = "https://ezfind.zendesk.com/agent/tickets/" . setDefaultValue($_POST['cancelTicketNumber']);
    $cancelMonthlyPremia = setDefaultValue($_POST['cancelMonthlyPremia']);
    $cancelInsurenceCompany = setDefaultValue($_POST['cancelInsuranceCompany']);
    $salesMan = setDefaultValue($_POST['salesMan']);
    $leadIdToCancel = setDefaultValue($_POST['leadId']);
    $cancelPolicyNumber = setDefaultValue($_POST['cancelPolicyNumber']);
    $linkToCustomer = 'https://crm.ibell.co.il/a/3694/leads/' . setDefaultValue($_POST['recordNumber']);
    $customerSsn = setDefaultValue($_POST['customerSsn']);
    $customerSsn = normalizeSsn($customerSsn);
    $actualPremia = ($_POST['actualPremia']) != "" ? ($_POST['actualPremia']) : 0;
    $supplierNameEmail = explode(";", setDefaultValue($_POST['supplierNameEmail']));
    $moreDetailsOfBitul = $_POST["moreDetailsOfBitul"];
    $viturShimur = $_POST['viturShimur'];
    $policyThreeMonthsPassed = $_POST['policyThreeMonthsPassed'];
    $savedInPastBy = $_POST["savedInPastBy"];
    $cancelTypeAsArr = setDefaultValue($_POST['cancelType']);
    $cancelType = implode(", ", $cancelTypeAsArr);

    switch ($_POST['leadType']) {
        case 'pigur':
            $openLeadData = generatePigurLeadPostData();
            break;
        case 'bitul':
            $extraDetailsToCancel = getExtraDetailsToCancel($crmAccountNumber, $recordNumber);
            $openLeadData = generateBitulLeadData($supplierNameEmail, $extraDetailsToCancel);
            $status = "107637";//התקבלה בקשה לביטול
            // update status of polica mekorit in crm
            $cancelTypeNumFieldAsArr = getArrNumFieldCancelType($configTypes);
            $updateFieldsKeyValue = [107639 => "התקבלה_בקשה_לביטול",
                103698 => $cancelTypeNumFieldAsArr];
            leadImUpdateLead($crmAccountNumber, $recordNumber, $updateFieldsKeyValue, false, $status);
            break;
        case 'doublePay':
            $openLeadData = generateDoublePayLeadData();
            break;
        default:
            echo '$_POST[\'leadType\'] is not set!! ' . $_POST['leadType'];
            break;
    }
    $newLeadId = openNewLead($openLeadData);
    $updateFieldsKeyValue = [103698 => $cancelTypeNumFieldAsArr];
    leadImUpdateLead($crmAccountNumber, $newLeadId, $updateFieldsKeyValue, true);
    $result = addSherutLeadToCustomerByLeadType($leadType, $newLeadId, $customerSsn, $crmAccountNumber);

    if ($_POST['leadType'] == 'bitul') {
        InitiateDataFoTicket($supplierNameEmail);
        updeteLeadBitulInCrm($newLeadId, $supplierNameEmail);
        updateTicket($collaborators, $dataTicket, $newLeadId);

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
                    <a target="_blank" href="https://crm.ibell.co.il/a/3694/leads/<?php print $_POST['recordNumber'] ?>"
                       class="btn btn-success">לצפיה בפוליסה המקורית </a>
                </div>
                <div class="col-xs-6 col-md-6 col-sm-6">
                    <a target="_blank" href="https://crm.ibell.co.il/a/3694/leads/<?php print $newLeadId ?>"
                       class="btn btn-success">לצפיה בפניה שנפתחה</a>
                </div>
            </fieldset>
        </div>
    </div>
</div>

</body>
</html>