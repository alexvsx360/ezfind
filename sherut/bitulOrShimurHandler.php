<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>
    <link rel="stylesheet" href="../ezfind/css_bootstrap4/css/bootstrap-grid.css" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="../ezfind/css_bootstrap4/css/bootstrap.css" crossorigin="anonymous">
    <link rel="stylesheet" href="../ezfind/css_bootstrap4/css/bootstrap-reboot.css" crossorigin="anonymous">
    <link rel="stylesheet" href="../ezfind/css/newStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../ezfind/css_bootstrap4/js/bootstrap.bundle.js" crossorigin="anonymous"></script>
    <script src="../ezfind/css_bootstrap4/js/bootstrap.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="" charset="" src="../js/helperFunction.js"></script>
    <title>שימור או ביטול</title>
</head>
<body>

<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 25/04/2018
 * Time: 14:33
 */
include_once('../generalUtilities/plectoFunctions.php');
include_once('../generalUtilities/functions.php');
include_once('../generalUtilities/leadImFunctions.php');
require '../vendor/autoload.php';
include_once('../generalUtilities/classes/ticket_classes/CreateTicket.php');
include_once('../generalUtilities/classes/LeadShimur.php');
include_once('../generalUtilities/classes/LeadToCancel.php');

use Zendesk\API\HttpClient as ZendeskAPI;
session_start();
$subdomain = "ezfind";
$username  = "yaki@ezfind.co.il";
$token     = "Bdt7m6GAv0VQghQ6CRr81nhCMXcjq2fIfZHwMjMW"; // replace this with your token
$client = new ZendeskAPI($subdomain, $username);
$client->setAuth('basic', ['username' => $username, 'token' => $token]);
$LOGGER = fopen("log.txt", "a");
$file = fopen('bitulOrShimurLog.txt',"a");
$configTypes = include('configTypes.php');
$dataBodyTicket = "";
$leadToPopulateJson = "";
$leadSugPolica = "";
$leadIdToCancel = "";
if ($_POST){
    $sellerMeshamerEmail = $_POST['userEmail'];
    $sellerMeshamerFromUserName = $_POST['userName'];
    $leadIdBitulim = $_POST['recordNumber'];//leadId in bitulim campaign
    $status = $_POST['customerCount'];
    $leadIdToCancel = $_POST['leadIdToCancel'];
    $crmAccountNumber = $_POST['accId'];
    $ticketNumber = $_POST['ticketNumber'];
    $cancelPolicyType = $_POST['cancelPolicyType'];
    $leadToPopulateJson = leadImGetLead($crmAccountNumber, $leadIdToCancel);
    $bitulReason = str_replace(' ', '_',$_POST["bitulReason"]);
//    $bitulCategory = str_replace(' ', '_',$_POST["bitulCategory"]);
    if ($leadToPopulateJson['status'] !== "failure" ){
         $leadSugPolica = $leadToPopulateJson['lead']['fields'][102104];
        switch ($status){
            case "שימור":
                fwrite($file,"מתחיל תהליך שימור!"."\n");
                $cancelPolicyType = $_POST['cancelPolicyType'];
                $premia = $_POST['premiaAferShimur'];
                $saveDate = $_POST['saveDate'];
                $insuranceComment = $_POST['insuranceComment'];
                $sellerNameMeshamerId = $_POST['sellerNameMeshamer'];
                $sellerNameMeshamer = $configTypes['sellerName'][$sellerNameMeshamerId];
                $callCenterName = $_POST['callCenterName'];
                $callCenterManagerMail = $_POST["callCenterManagerMail"];
                $supplierName = $_POST["supplierName"];
                $policyCanceledInOppositeCompany = $_POST['policyCanceledInOppositeCompany'];
                $moveToMokedShimur = $_POST["moveToMokedShimur"];
                /*save the file to the directory */
                $files = $_FILES["file"]["name"];
                $extension_files = array();
                $new_name_files = array();
                $array_types = array();
                $array_targets = array();

                //to get the extension of the file.
                foreach ($files as $index => $file_name) {
                    $extension = pathinfo($file_name, PATHINFO_EXTENSION);
                    array_push($extension_files, $extension);
                }

                //to define a new name for each file.
                foreach ($extension_files as $i => $extension_name) {
                    $new_name = "regret_doc_" . $_POST['recordNumber'] . "." . $i . "." . $extension_name;
                    array_push($new_name_files, $new_name);
                }

                //send to new directory the files and save the new directory and types in arrays.
                foreach ($new_name_files as $i => $newname) {
                    move_uploaded_file($_FILES["file"]["tmp_name"][$i], 'regretLetters/' . $newname);
                    $target = 'regretLetters/' . $newname;
                    array_push($array_targets, $target);
                    $type = $_FILES['file']['type'][$i];
                    array_push($array_types, $type);
                };
                fwrite($file,"!מעדכן ליד בCRM"."\n");
                //update status of leadBitul to "shimur"
                $updateFieldsKeyValue = [107639 => "שימור",108937 => $bitulReason];
                $status = 103733;//shimur
                leadImUpdateLead($crmAccountNumber, $leadIdBitulim, $updateFieldsKeyValue, false, $status);
                //update lead's policy in crm
                $updateFieldsKeyValue =//fildes to update
                    [
                        104608 => strtotime($_POST['saveDate']),//תאריך השימור
                        104604 => $_POST['sellerNameMeshamer'],//שם המוכרן המשמר
                        104607 => $_POST['premiaAferShimur'],//פרמיה בפועל לאחר שימור
                        105113 => $_POST['cancelDate'],//תאריך ביטול
                        107639 => "הופק_ושומר",
                        111475 => $_POST["moveToMokedShimur"],
                        108937 => $bitulReason, //סיבת הביטול
//                        108936 => $bitulCategory //קטגורית סיבת הביטול
                    ];
                $status = 104259; //ufak veshumar
                leadImUpdateLead($crmAccountNumber, $leadIdToCancel, $updateFieldsKeyValue, false, $status);
                fwrite($file,"!מאתחל נתונים לטיקט"."\n");
                //Initializing data returned from leadImGetLead function to use in ticket
                $leadFields = $leadToPopulateJson['lead']['fields'];
                $leadInsuranceCompany = $leadFields['102112'];
                $customerName = $leadFields['100086'];
                $customerId = $leadFields ['102092'];
                $birthDate = $leadFields ['102093'];
                $customerPhone = $leadFields['100090'];
                $customerEmail = $leadFields['100091'];
                $leadChannel = $leadFields['102131'];
                $hitum = $leadFields ['102133'];
                $payingWith = $leadFields['106839'];
                $dataBodyTicket = "הפוליסה שומרה";
                //save the uploaded file as zendesk attachment
                $upload_token = "";
                foreach ($files as $i => $files) {
                    $params = array(
                        'file' => $array_targets[$i],
                        'type' => $array_types[$i],
                        'name' => $files
                    );
                    if (isset($upload_token)) {
                        $params['token'] = $upload_token;
                    }
                    $attachment = $client->attachments()->upload($params);
                    $upload_token = $attachment->upload->token;
                }
                //Initializing the data to the ticket:
                $sugCisuyLead = $configTypes['cisuyTypes'][$leadSugPolica];
                $insuranceCompany = $configTypes['insuranceCompanyTypes'][$leadInsuranceCompany];
                //format date from timestamp to format :'Y-m-d'
                $createDate = new DateTime();
                $birthDate = $createDate->setTimestamp($birthDate);
                $birthDate = date_format($birthDate, 'Y-m-d');
                $hitum = $configTypes['hitumTypes'][$hitum];
                //format saveDate for the ticket from 'dd-mm-yy' to 'yy-mm-dd'.
                $saveDate = date_create($saveDate);
                $saveDate = date_format($saveDate, "Y/m/d");
                $saveDate = str_replace('/', '-', $saveDate);
                //remove underscore
                $callCenterNameNoUnderline = str_replace('_', ' ', $callCenterName);
                $sugCisuyLeadNoUnderline = str_replace('_', ' ', $sugCisuyLead);
                $ticketSubject = 'שימור:' . " " . $customerName . " " . $customerId . " " . $sugCisuyLead . " " . $insuranceCompany;

                $commentBodyNewTicket = 'שם מלא: ' . $customerName . " \n" .
                    'תעודת זהות: ' . $customerId . " \n" .
                    'תאריך לידה: ' . $birthDate . " \n" .
                    'מספר נייד: ' . $customerPhone . " \n" .
                    'אימייל של הלקוח: ' . $customerEmail . "n\n\n\n\n\n" .
                    'מוקד: ' . $callCenterNameNoUnderline . " \n" .
                    'מוכרן מקורי: '.$supplierName."\n".
                    'שם המוכרן המשמר: ' . $sellerNameMeshamer . " \n" .
                    'ערוץ מכירה : ' . $leadChannel . " \n" .
                    'כיסוי ביטוחי : ' . $sugCisuyLeadNoUnderline . " \n" .
                    'חברת ביטוח : ' . $insuranceCompany . " \n" .
                    'פרמיה לאחר שימור : ' . $premia . " \n" .
                    'מסלול חיתום : ' . $hitum . " \n" .
                    'תאריך השימור : ' . $saveDate . " \n" .
                    'אמצעי תשלום : ' . $payingWith . " \n" .
                    ' האם יש לבטל פוליסה בחברה נגדית ? : ' . $policyCanceledInOppositeCompany . " \n" .
                    'הערות להצעה: ' . $insuranceComment . " \n" .
                    'קישור לרשומת הליד במסד נתונים (תפעול ושירות לקוחות) : ' . 'https://crm.ibell.co.il/a/3694/leads/' . $leadIdToCancel . " \n\n";

                //create new ticket with new details to tor bakara (tiful)
                fwrite($file,"!יוצר טיקט חדש"."\n");
                $newTicket = $client->tickets()->create([
                    'subject' => $ticketSubject,
                    'requester' => array(
                        'name' => $sellerNameMeshamer,
                        'email' => $sellerMeshamerEmail
                    ),
                    'collaborators' =>  ["michael@tgeg.co.il", $callCenterManagerMail, "Tzvika@tgeg.co.il", "doron1098@tgeg1.onmicrosoft.com"],
                    'custom_fields' => array(
                        '114096462111' => "תור_בקרה",
                        '114100300592' => $hitum,                                          //מסלול חיתום
                        '114096335892' => $callCenterName,                 // מוקד ביטוח
                        '114096371131' => $sugCisuyLead,                                                      //כיסוי ביטוחי
                        '114096335852' => $insuranceCompany,                                // חברת ביטוח
                        '114096335872' => $premia,                                          //פרמיה
                        '114096372992' => $saveDate                                                //תאריך תחילת ביטוח
                    ),
                    'comment' => [
                        'body' => $commentBodyNewTicket,
                        'uploads' => [$upload_token]
                    ],
                    'assignee_id' => '360057374072'
                ]);
                //update crm with link to the new ticket of shimur policy
                $ticketId = $newTicket->ticket->id;
                fwrite($file,"מעדכן CRM 2"."\n");
                $updateFieldsKeyValue = [104157 => 'https://ezfind.zendesk.com/agent/tickets/' . $ticketId];
                leadImUpdateLead($crmAccountNumber, $leadIdToCancel, $updateFieldsKeyValue, false);

                fwrite($file,"יוצר ליד שימור בפלקטו"."\n");
                $leadToPopulateJson = getLeadJson($leadIdToCancel,$crmAccountNumber, $_POST['agentId']);
                $lead =  new LeadShimur($leadToPopulateJson);
                if (is_null($lead)){
                   // error_log("Received create Request but cannot instantiate Lead object for lead id: " . $leadIdToCancel);
                } else {
                    //error_log("Received create Request and instantiate Lead object: " . get_class($lead) ." for lead id: " . $leadIdToCancel);
                    $leadPostDate = $lead->generateShimurPolicyPostData();
                    /*update the BI and return a result code*/
                    $output = addLeadToPlecto($leadPostDate);
                }
                break;
            case "ביטול" :
                fwrite($file,"מתחיל תהליך ביטול"."\n");
                $policyLengthTime = str_replace(' ', '_',$_POST["policyLengthTime"]);
                $updateFieldsKeyValue = [
                        107639 => "ביטול",
                        108939 => $_POST["firstPayment"],//האם בוצעה גביה ראשונה
                        108938 => $policyLengthTime,//משך חיי הפוליסה
                        108937 => $bitulReason, //סיבת הביטול
//                        108936 => $bitulCategory //קטגורית סיבת הביטול
                ];
                $status = 103734; //bitul
                //update lead's status in lead bitul to "bitul"
                $update = leadImUpdateLead($crmAccountNumber, $leadIdBitulim, $updateFieldsKeyValue, false, $status);
                fwrite($file," מעדכן CRM עבור ליד".$leadIdBitulim." =".$update."\n");
                //update lead bitul in plecto
                $leadBitulToPopulateJson = leadImGetLead($crmAccountNumber,$leadIdBitulim,1);
                $lead = new LeadToCancel($leadBitulToPopulateJson);
                $leadPostDate = $lead->generateUpdatePolicyPostData();
                /*update the BI and return a result code*/
                $output = addLeadToPlecto($leadPostDate);
                fwrite($file," מעדכן פלקטו עבור ליד".$leadIdBitulim." =".$output."\n");
                //update lead's status in reshumat masad mekory to hufak vebutal
                $updateFieldsKeyValue = [107639 => "הופק_ובוטל"];
                $status = 104260; //hufak vebutal
                leadImUpdateLead($crmAccountNumber, $leadIdToCancel, $updateFieldsKeyValue, false, $status);
                $dataBodyTicket = "הפוליסה בוטלה";
        }
        // Update ticket bitul to solved

        try {
            $ll =   $client->tickets()->update($ticketNumber,[
                'status' => 'solved',
                'comment'  => $dataBodyTicket,
                'tags' => 'עדכון_סטטוס_ביטול_ב_api'
            ]);?>
            <div class="row">
            <div class="col-md-5 offset-md-5">
                <img src="logo3.png" class="rounded">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="alert alert-success" role="alert" id="requestAccepted" style="text-align: center">
                ! הבקשה נשלחה כמו שצריך
            </div>
            </div>
        </div>
      <?php  }catch (Zendesk\API\Exceptions\ApiResponseException $e) {?>
            <div class="row">
            <div class="col-md-5 offset-md-5">
                <img src="logo3.png" class="rounded">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="alert alert-success" role="alert" id="requestAccepted" style="text-align: center">
                ! הבקשה נשלחה כמו שצריך
            </div>
            </div>
        </div>
        <?php
        }



    }else{?>
        <div class="row">
            <div class="col-md-5 offset-md-5">
                <img src="logo3.png" class="rounded">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="alert alert-danger" role="alert" style="text-align: center">
                    שים לב, ליד מספר :<?php print $leadIdToCancel?> לא קיים במערכת, הבקשה לא התקבלה

                </div>
            </div>
        </div>
  <?php  }
}
?>





</body>
</html>



