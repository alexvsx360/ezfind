<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>

    <link rel="stylesheet" href="css_bootstrap4/css/bootstrap-grid.css" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="css_bootstrap4/css/bootstrap.css" crossorigin="anonymous">
    <link rel="stylesheet" href="css_bootstrap4/css/bootstrap-reboot.css" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="css_bootstrap4/js/bootstrap.bundle.js" crossorigin="anonymous"></script>
    <script src="css_bootstrap4/js/bootstrap.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


</head>
<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 09/07/2018
 * Time: 11:42
 */



$configTypes = include('configTypes.php');
include_once ('generalUtilities/functions.php');
include_once ('generalUtilities/leadImFunctions.php');

function createMainRecord ($result){
    $crmAccountNumberNameJson =[
        "3328" => "ezfind",
        "3326" => "ez ביטוח",
        "3327" => "ez ביטוח",
        "3474" => "אביב בר שי",
        "3325" => "אלעד שמעוני",
        "3305" => "מוקד בולוטין",
        "3313" => "מוקד פרחי",

    ];
    $salesmanName = getRecordInitializerdName($_POST['recordNumber'], $_POST['crmAcccountNumber'], $_POST['agentId']);
    $baseUrl = "http://api.lead.im/v1/submit";
    $postData['lm_form'] = "18573";
    $postData['lm_key'] = "fde1fae3d6";
    $postData['lm_redirect'] = "no";
    $postData['name'] = $_POST['customerFullName'];
    $postData['phone'] = $_POST['customerPhone'];
    $postData['ssn'] = $_POST['ssn'];
    $postData['issue-date'] = $_POST['issue-date'];
    $postData['leader'] = $salesmanName;
    $postData['callCenterName'] = $crmAccountNumberNameJson[$_POST['crmAcccountNumber']];
    $postData['insurmt'] = "https://portal.ibell.co.il/user-upload/" . $_POST["recordNumber"] . "/" . $result->file;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $baseUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_exec($ch);
    curl_close($ch);

}
function generateNewOfferLeadData($laedStatus,$leadToPopulateJson,$result,$campaignName){
    return [
        'lm_supplier' => $_POST["agentId"],
        'lm_form' => "17356",
        'lm_key' => "8082ae33d0",
        'lm_redirect' => "no",
        'name' => $_POST['customerFullName'],
        'phone' => $_POST['customerPhone'],
        'id' => $_POST['ssn'],
        'issue-date' => $_POST['issue-date'],
        'email' => $_POST['customerEmail'],
        'totalHealth' => $leadToPopulateJson['lead']['fields']['106440'],
        'totalLife' => $leadToPopulateJson['lead']['fields']['106441'],
        'totalInsurenceMountain' => $leadToPopulateJson['lead']['fields']['106442'],
        'iturStatus' => $laedStatus,
        'ezkamp' => $campaignName,
        'isSmoker' => $_POST['isSmoke'],
        'fld_92293' => $_POST['workStatus'],
        'kupa' => $_POST['kupa'],
        'insurmt' => "https://portal.ibell.co.il/user-upload/" . $_POST["recordNumber"] . "/" . $result->file];

}
function generateHarBituahLeadData($laedStatus,$leadToPopulateJson,$result,$campaignName){
    return [
        'lm_supplier' => $_POST["agentId"],
        'lm_form' => "16713",
        'lm_key' => "296e525f17",
        'lm_redirect' => "no",
        'name' => $_POST['customerFullName'],
        'phone' => $_POST['customerPhone'],
        'id' => $_POST['ssn'],
        'issue-date' => $_POST['issue-date'],
        'email' => $_POST['customerEmail'],
        'totalHealth' => $leadToPopulateJson['lead']['fields']['106440'],
        'totalLife' => $leadToPopulateJson['lead']['fields']['106441'],
        'totalInsurenceMountain' => $leadToPopulateJson['lead']['fields']['106442'],
        'iturStatus' => $laedStatus,
        'ezkamp' => $campaignName,
        'isSmoker' => $_POST['isSmoke'],
        'fld_92293' => $_POST['workStatus'],
        'kupa' => $_POST['kupa'],
        'insurmt' => "https://portal.ibell.co.il/user-upload/" . $_POST["recordNumber"] . "/" . $result->file
    ];
}
if ($_POST) {
    $crmAccountNumber = $_POST['crmAcccountNumber'];
    $recordNumber = $_POST['recordNumber'];
    $agentId = $_POST['agentId'];
    $name = $_POST['customerFullName'];
    $phone = $_POST['customerPhone'];
    $ssn = $_POST['ssn'];
    $issueDate = $_POST["issue-date"];
    $cfile = curl_file_create($_FILES['file']['tmp_name'], $_FILES['file']['type'], $_FILES['file']['name']);
    $myfile = fopen("log.txt", "a");
    $cfile = curl_file_create($_FILES['file']['tmp_name'], $_FILES['file']['type'], $_FILES['file']['name']);
    if ($curl = curl_init()) {
// Check if initialization had gone wrong*
        if ($curl === false) {
            throw new Exception('failed to initialize');
        }
        //http://192.168.150.223/api.phpכתובת חיצונית
        curl_setopt($curl, CURLOPT_URL, 'http://192.168.150.223/api.php');//הכתובת בשרת http://212.143.233.53/api.php
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
        curl_setopt($curl, CURLOPT_POSTFIELDS, array(
            'crmAcccountNumber' => $crmAccountNumber,
            'recordNumber' => $recordNumber,
            'agentId' => $agentId,
            'name' => $name,
            'phone' => $phone,
            'file_category' => '102008',
            'cat_name' => 'הר ביטוח',
            'fileType' => '{102008;94677;94678;94679;94680;94681;94682}',
            'file' => $cfile,
            'ssn' => $ssn,
            'issue-date' => $issueDate
        ));
        $out = curl_exec($curl);

        if ($out === false) {
            throw new Exception(curl_error($curl), curl_errno($curl));
        }
        $result = json_decode(trim($out));
        if($result == null){
            ?>
            <div class="container" role="main" id="">
                <br/>
                <br/>
                <div class="row justify-content-center" style="text-align: center">
                    <div class="col-12">
                        <div class="alert alert-danger" role="alert">
                            יש בעיה בקובץ שצירפת, נא נסה שוב
                        </div>
                    </div>
                </div>
            </div>
        <?php }

        curl_error($curl);
        if ($result->success != true) {
            if ($result->error == '["File already exist"]') {
                ?>
                 <div class="container" role="main" id="">
                     <br/>
                     <br/>
                    <div class="row justify-content-center" style="text-align: center">
                        <div class="col-12">
                            <div class="alert alert-danger" role="alert">
                            ! הקובץ כבר קיים
                            </div>
                        </div>
                    </div>
                 </div>
            <?php }
            fwrite($myfile, "\n" . "Failed to upload file to server - got this response " . $result->error);
        }
        if ($result->success == true) {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/user-upload/' . $_POST['recordNumber'];
            if (!file_exists($uploadDir)) {
                $new_dir = mkdir($uploadDir, 0775);
            }
            $fileName = $uploadDir . "/" . $result->file;
            move_uploaded_file($_FILES['file']['tmp_name'], $fileName);

            $mainRecordLead = createMainRecord($result);
            $updateFieldsKeyValue = ["102007" => "https://portal.ibell.co.il/user-upload/" . $recordNumber . "/" . $result->file];
            leadImUpdateLead($crmAccountNumber, $recordNumber, $updateFieldsKeyValue, true);
            $leadToPopulateJson = leadImGetLead($crmAccountNumber, $recordNumber);
            $salesPotential = $leadToPopulateJson['lead']['fields']['106442'];
            $laedStatus = $leadToPopulateJson['lead']['status'];
            $laedStatus = $configTypes['ezfindStatus'][$laedStatus];
            $campaignId = $leadToPopulateJson['lead']['campaign_id'];
            $campaignName = $configTypes['ezfindCampaignName'][$campaignId];
            if($salesPotential <= 100 ){
                $openLeadData = generateNewOfferLeadData($laedStatus, $leadToPopulateJson, $result,$campaignName);
            }else{
                $openLeadData = generateHarBituahLeadData($laedStatus, $leadToPopulateJson, $result,$campaignName);
            }
            $newLeadId = openNewLead($openLeadData);
?>

<div class="container" role="main" id="">
    <br/>
    <br/>
    <div class="row justify-content-center" style="text-align: center">
        <div class="col-12">
            <div class="alert alert-success" role="alert">
                ! המסמך עלה בהצלחה
            </div>
        </div>
    </div>
</div>
<?php
    }
  }
};
?>

