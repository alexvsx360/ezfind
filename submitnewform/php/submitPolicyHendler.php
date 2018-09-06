<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/08/2018
 * Time: 15:48
 */
use Zendesk\API\HttpClient as ZendeskAPI;
require '../../vendor/autoload.php';
$subdomain = "ezfind";
$username  = 'yaki@ezfind.co.il';
$token     = "Bdt7m6GAv0VQghQ6CRr81nhCMXcjq2fIfZHwMjMW"; // replace this with your token
$client = new ZendeskAPI($subdomain, $username);
$client->setAuth('basic', ['username' => $username, 'token' => $token]);
include_once ('../../generalUtilities/functions.php');
include_once ('../../generalUtilities/leadImFunctions.php');

$arrayLinksToFile=[];
$arrayLinksCancelFilesByCancelInsuranceCompany =[];
$fileLinksToTicket="";
$cancelLettersLinksToTicket="";
$arrayLinksCancelFiles = [];
$count = 0;

$yesNoJson = [
    "כן" => true,
    "לא" => false
];

$str = file_get_contents('../agentNumbersJson.json');
$agentNumbersJson =json_decode($str);

$policy = json_decode($_POST['policy'], true);
$castumerDetails = json_decode($_POST['castumerDetails'], true);

$myfile = fopen("log.txt", "a");

$policyName = $policy['policy'];
$insuranceCompany = $policy['insuranceCompany'];
$hitum = $policy['hitum'];
$premia = $policy['premia'];
$cancellationLetter = $policy['cancellationNumber'];
$insuranceStartDate = $policy['insuranceStartDate'];
$discount = $policy['discount'];
//$insuranceComment = $policy['insuranceComment'];
$saleDate = $policy['saleDate'];
$cancelPolicyNumber = $policy['cancelPolicy'];
$payingWith = $policy['payingWith'];

$customerName = $castumerDetails['customerName'];
$customerId = $castumerDetails['customerId'];
$leadid =$castumerDetails['leadId'];
$agentid=$castumerDetails['agentId'];
$crmAccount=$castumerDetails['crmAccountNumber'];
$origLeadCampaignName = $castumerDetails['origLeadCampaignName'];
$origLeadSupplaier = $castumerDetails['origLeadSupplaier'];
$userEmail = $castumerDetails['userEmail'];
$userName = $castumerDetails['userName'];
$birthDate = $castumerDetails['birthDate'];
$sex = $castumerDetails['sex'];
$marriageStatus = $castumerDetails['marriageStatus'];
$customerAddress = $castumerDetails['customerAddress'];
$customerPhone = $castumerDetails['customerPhone'];
$customerEmail = $castumerDetails['customerEmail'];
$leadChannel = $castumerDetails['leadChannel'];
$agentId = $castumerDetails['agentId'];
$harBituahFile = $castumerDetails['harBituahFile'];
$customerIdIssueDate = $castumerDetails['issueDate'];

if ($agentId == 11819){
    $callCenterName = "מוקד_טאלנטים";
}else{
    $callCenterName = getCallCenterById($crmAccount);
}
$linkInformation = array(
    'כלל'=> array(
        'תאונות_אישיות' => 'https://bit.ly/2H5CsFe',
        'בריאות' => 'https://bit.ly/2H2plnY',
        'מחלות_קשות' => 'https://bit.ly/2H2oXWM',
        'חיים' => 'https://bit.ly/2EbJ7dI',
        'ביטוח_משכנתא'=>'https://bit.ly/2J0av18',
        'אובדן_כושר_עבודה' => 'https://bit.ly/2qG1eDM',
        'סיעודי' => 'https://bit.ly/2H2plnY'
    ),
    'הראל'=>array(
        'תאונות_אישיות' => 'https://bit.ly/2pWEI9l',
        'בריאות' => 'https://bit.ly/2GoIXpo',
        'מחלות_קשות' => 'https://bit.ly/2Gul8Zn',
        'חיים' => 'https://bit.ly/2J9RTg9',
        'ביטוח_משכנתא' =>'https://bit.ly/2HHnANF',
        'אובדן_כושר_עבודה' => 'https://bit.ly/2qDT6UE',
        'סיעודי' => 'https://bit.ly/2JSVNdI'
    ),
    'איילון'=>array(
        'תאונות_אישיות' => 'https://bit.ly/2Gpi0SH',
        'בריאות' => 'https://bit.ly/2Gs5txB',
        'מחלות_קשות' => 'https://bit.ly/2Eb4uMi',
        'חיים' => 'https://bit.ly/2J8EFQG',
        'ביטוח_משכנתא' => 'https://bit.ly/2J2zNMc',
        'אובדן_כושר_עבודה' => 'https://bit.ly/2Hqp1Cp',
        'סיעודי' => 'https://bit.ly/2JTxa0A'
    )
);

function saveFilestoNewDirectoryAndGetLink($file,$nameFileInPost,$leadid,$directoryName){
    global $count;
    $count++;
    $nameFile = $file['name'];
    $extension =  pathinfo($nameFile,PATHINFO_EXTENSION);
    $newName = $leadid."_".$count.".".$extension;
    $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/'.$directoryName.'/'.$leadid."/";
    if (!file_exists($uploadDir)) {
        $new_dir = mkdir ($uploadDir, 0777);
    }
    $fileName   = $uploadDir."/".$newName;
    move_uploaded_file($file['tmp_name'], $fileName);
    $linkToUploadFile =  "https://".$_SERVER['SERVER_NAME'].'/'.$directoryName.'/'.$leadid."/".$newName;
    return $linkToUploadFile;
}


foreach ($_FILES as $key  => $val) {
    if (strpos($key, 'file') !== false) {
        $linkToFile = saveFilestoNewDirectoryAndGetLink($val, $key, $leadid, "upsale_doc");
        array_push($arrayLinksToFile, $linkToFile);
    } else {
        $linkToCancelFile = saveFilestoNewDirectoryAndGetLink($val, $key, $leadid, "cancel_files");
        $arrayLinksCancelFilesByCancelInsuranceCompany[$key] = $linkToCancelFile;
        array_push($arrayLinksCancelFiles,$linkToCancelFile);
    }
}


    foreach($arrayLinksToFile as $item){
        $fileLinksToTicket .= $item. " \n" ;
    }

    foreach ($arrayLinksCancelFilesByCancelInsuranceCompany as $key=>$value){
        $cancelInsuranceCompany = substr($key,18);
        $cancelLettersLinksToTicket .= "מכתב ביטול לחברת ".$cancelInsuranceCompany." : ".$value. " \n" ;
    }


//format date for the ticket from 'dd-mm-yy' to 'yy-mm-dd'.

$ticketInsuranceStartDate = date_create($_POST['insuranceStartDate']);
$ticketInsuranceStartDate = date_format($ticketInsuranceStartDate,"Y/m/d");
$ticketInsuranceStartDate = str_replace('/', '-', $ticketInsuranceStartDate);
$ticketCommentBody =
    'שם מלא: ' .$customerName . " \n" .
    'תעודת זהות: ' . $customerId . " \n" .
    'תאריך לידה: ' . $birthDate . " \n" .
    'מין: ' . $sex . " \n" .
    'מצב משפחתי: ' . $marriageStatus . " \n" .
    'כתובת מלאה: ' . $customerAddress . " \n" .
    'מספר נייד: ' . $customerPhone . " \n" .
    'אימייל של הלקוח: ' . $customerEmail . "n\n\n\n\n\n" .
    'מוקד: ' . $callCenterName . " \n" .
    'איש מכירות: ' . $userName . " \n" .
    'ערוץ מכירה : ' . $leadChannel . " \n" .
    'כיסוי ביטוחי : ' . $policyName . " \n" .
    'חברת ביטוח : ' . $insuranceCompany . " \n" .
    'פרמיה בש"ח : ' . $premia . " \n" .
    'הנחה באחוזים : ' . $discount . " \n" .
    'מסלול חיתום : ' . $hitum . " \n" .
    'תאריך תחילת ביטוח : ' .$insuranceStartDate. " \n" .
    'האם יש מכתב ביטול? : ' . $cancellationLetter  . " \n" .
    'מכתבי הביטול : ' . " \n" . $cancelLettersLinksToTicket  . " \n" .
    'מספר פוליסה לבטל : ' . $cancelPolicyNumber  . " \n" .
    'תאריך המכירה : ' . $saleDate  . " \n" .
    'אמצעי תשלום : ' . $payingWith  . " \n" .
    'גילוי נאות: '. $linkInformation[$insuranceCompany][$policyName]. " \n" .
    'לינק למסמכים : ' . " \n" . $fileLinksToTicket. " \n\n" .
    'קישור להר הביטוח : '. $harBituahFile."\n".
    'הערות להצעה: ' . $insuranceComment;

//create new ticket with new details to tor bakara (tiful)
fwrite($myfile, "before create ticket to lead id:".$leadid);

    $newTicket = $client->tickets()->create([
        'subject' => $customerName . ' ' . $customerId . ' ' . $policyName . ' ' . $insuranceCompany,
        'requester' => array(
            'name' => $userName,
            'email' => $userEmail,
        ),
        'collaborators' => getCollaboratorArrayById($crmAccount, $userEmail),
        'custom_fields' => array(
            '114100300592' => $hitum,                                          //מסלול חיתום
            '114096335892' => $callCenterName,                 // מוקד ביטוח
            '114096371131' => $policyName,                                                      //כיסוי ביטוחי
            '114096335852' => $insuranceCompany,                                // חברת ביטוח
            '114096335872' => $premia,                                          //פרמיה
            '114096401231' => $yesNoJson[$cancellationLetter],                               // האם יש מכתב ביטול?
            '114096372992' => $ticketInsuranceStartDate,                                                //תאריך תחילת ביטוח
            '114096462111' => "תור_בקרה"
        ),
        'comment' => [
            'body' => $ticketCommentBody,

        ]
    ]);


$cancelLettersJson =  json_encode($arrayLinksCancelFilesByCancelInsuranceCompany,JSON_UNESCAPED_UNICODE);
$ticketId = $newTicket->ticket->id;

fwrite($myfile, "ticket created ticket number is".$ticketId);

$policyPost = [
    'lm_form' => '17968',
    'lm_key' => 'e74d9a88fc',
    'lm_redirect' => 'no',
    'lm_supplier' => $agentId,
    'name' => $customerName,
    'phone' => $customerPhone,
    'id' => $customerId,
    'issueDate' => $customerIdIssueDate,
    'email' => $customerEmail,
    'birthDate' => $birthDate,
    'sex' => $sex,
    'familyStatus' => $marriageStatus,
    'address' => $customerAddress,
    'ticketNumber' => $ticketId,
    'zendeskLink' => 'https://ezfind.zendesk.com/agent/tickets/' . $ticketId,
    'callCenter' => $callCenterName,
    'sellingChannel' => $leadChannel,
    'sellerName' => $userName,
    'agentNumber' => $agentNumbersJson->$insuranceCompany->$callCenterName,
    'policy' => str_replace('_'," ", $policyName),
    'insuranceCompany' => $insuranceCompany,
    'premia' => $premia,
    'hitum' => $hitum,
    'insuranceStartDate' => $insuranceStartDate,
    'cancellationLetter' => $cancellationLetter,
    'cancelPolicyNumber' => $cancelPolicyNumber,
    'saleDate' => $saleDate,
    'payingWidth' => $payingWith ,
    'giluy_naot' => $linkInformation[$insuranceCompany][$policyName],
    'fld_103757'=> $harBituahFile,
    'origLeadCampaig' => $origLeadCampaignName,
    'origLeadSupplier' => $origLeadSupplaier,
    'cancelLettersJson' => $cancelLettersJson,
    'leadPromoter' => str_replace('_'," ",$origLeadSupplaier),
//    'cancelLettersLinks' => $arrayLinksCancelFiles[0]

];
//open new lead policat prat in tiful sherut
fwrite($myfile, "before open new lead in tiful sherut in crm");

$newLead = openNewLead($policyPost);

fwrite($myfile, "new lead opened with id: ".$newLead);

foreach ($arrayLinksCancelFiles as $link) {

    $updateFieldsKeyValue = [111679 => $link];
    leadImUpdateLead(3694,$newLead, $updateFieldsKeyValue, true);
    }

$costumerPost = [
    'lm_form' => '17993',
    'lm_key' => '6ebab5cef5',
    'lm_redirect' => 'no',
    /*'lm_supplier' => $agentId,*/
    'name' => $customerName,
    'phone' => $customerPhone,
    'id' => $customerId,
    'issueDate' => $customerIdIssueDate,
    'email' => $customerEmail,
    'birthDate' => $birthDate,
    'sex' => $sex,
    'familyStatus' => $marriageStatus,
    'address' => $customerAddress,
    'callCenter' => $callCenterName
];
updateCustomer($newLead, $costumerPost, $customerPhone, $myfile);
echo "נקלט בהצלחה ";


