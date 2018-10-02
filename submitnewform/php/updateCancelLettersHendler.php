<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/09/2018
 * Time: 10:42
 */
include_once ('../../generalUtilities/functions.php');
include_once ('../../generalUtilities/leadImFunctions.php');
$arrayLinksCancelFilesByCancelInsuranceCompany =[];
$arrayLinksCancelFiles= [];
$count = 0;
$formatArrayLinksCancelFilesByCancelInsuranceCompany =[];

$leadId = $_POST['leadId'];

function saveFilestoNewDirectoryAndGetLink($file,$nameFileInPost,$leadId,$directoryName){
    global $count;
    $count++;
    $nameFile = $file['name'];
    $extension =  pathinfo($nameFile,PATHINFO_EXTENSION);
    $newName = $leadId."_".$count.".".$extension;
    $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/'.$directoryName.'/'.$leadId."/";
    if (!file_exists($uploadDir)) {
        $new_dir = mkdir ($uploadDir, 0777);
    }
    $fileName   = $uploadDir."/".$newName;
    move_uploaded_file($file['tmp_name'], $fileName);
    $linkToUploadFile =  "https://".$_SERVER['SERVER_NAME'].'/'.$directoryName.'/'.$leadId."/".$newName;
    return $linkToUploadFile;
}


foreach ($_FILES as $key  => $val) {
    $linkToCancelFile = saveFilestoNewDirectoryAndGetLink($val, $key, $leadId, "cancel_files");
    $nameInArray = explode("-",$key);
    $nameString  = $nameInArray[1];
    $formatArrayLinksCancelFilesByCancelInsuranceCompany[$nameString][]= $linkToCancelFile;
    array_push($arrayLinksCancelFiles,$linkToCancelFile);

}

$cancelLettersJson =  json_encode($formatArrayLinksCancelFilesByCancelInsuranceCompany,JSON_UNESCAPED_UNICODE);
$updateFieldsKeyValue = [111678 => $cancelLettersJson];
leadImUpdateLead(3694,$leadId, $updateFieldsKeyValue, true);
$updateFieldsKeyValue = [111679 => '{reset}'];
leadImUpdateLead(3694,$leadId, $updateFieldsKeyValue, true);
foreach ($arrayLinksCancelFiles as $link) {
    $updateFieldsKeyValue = [111679 => $link];
    leadImUpdateLead(3694,$leadId, $updateFieldsKeyValue, true);
}
echo "נקלט בהצלחה ";

