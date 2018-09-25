<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13/08/2018
 * Time: 12:24
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>

    <!-- Latest compiled and minified CSS -->
    <!--    <link rel="stylesheet" href="../css/bootstrap.min.css" crossorigin="anonymous">-->
    <!--    <!-- Optional theme -->
    <!--    <link rel="stylesheet" href="../css/bootstrap-theme.min.css" crossorigin="anonymous">-->
    <!--    <link rel="stylesheet" href="../css/style.css">-->
    <link rel="stylesheet" href="../css_bootstrap4/css/bootstrap-grid.css" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="../css_bootstrap4/css/bootstrap.css" crossorigin="anonymous">
    <link rel="stylesheet" href="../css_bootstrap4/css/bootstrap-reboot.css" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <!--    <script src="../js/bootstrap.min.js" crossorigin="anonymous"></script>-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../css_bootstrap4/js/bootstrap.bundle.js" crossorigin="anonymous"></script>
    <script src="../css_bootstrap4/js/bootstrap.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="" charset="" src="js/helperFunctionSubmitPolicy.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <title>הגשת הצעה לתיפעול</title>
</head>
<form>
<?php

include_once ('../generalUtilities/functions.php');
include_once ('../generalUtilities/leadImFunctions.php');
$configTtpes = include('../generalUtilities/classes/configTypes.php');
include_once ('php/helperFunction.php');

$harBituahFile = null;
$origLeadCampaignName = null;
$origLeadSupplaier = null;

if ($_GET){
    $leadId = $_GET['recordNumber'];
    $crmAccountNumber = $_GET['crmAcccountNumber'];
    $agentId = $_GET['agentId'];
}
$leadToPopulateJson = leadImGetLead($crmAccountNumber, $leadId);
$fieldsValuesArray = $leadToPopulateJson['lead']['fields'];
// field's numbers of castumer name in crm
$fieldNumFirstNameCastumer = $configTtpes['castumerFirstNameByAccId'][$crmAccountNumber];
$fieldNumLastNameCastumer = $configTtpes['castumerLastNameByAccId'][$crmAccountNumber];
//castumer full-name
$fullName = $fieldsValuesArray[$fieldNumFirstNameCastumer]." ".$fieldsValuesArray[$fieldNumLastNameCastumer];
// field's numbers of castumer phone in crm
$fieldNumPhone = $configTtpes['castumerPhoneByAccId'][$crmAccountNumber];
//castumer phone
$pone = $fieldsValuesArray[$fieldNumPhone];
//channelName
$channelName = $leadToPopulateJson['lead']['channel_name'];
// field's numbers of HarBituahFile in crm
$fieldNumHarBituahFile = $configTtpes['harBituahFieldsByAccId'][$crmAccountNumber];
//HarBituahFile
$harBituahFile = $fieldsValuesArray[$fieldNumHarBituahFile];
//user details
$user = getUser($crmAccountNumber,$agentId);
$currentUserName = $user['result']['name'];
$currentUserEmail = $user['result']['email'];

if($crmAccountNumber == "3694"){
    $origLeadCampaignName = $fieldsValuesArray["110283"];
    $origLeadSupplaier = $fieldsValuesArray["110284"]; ;
}
else{
    // field's numbers of original lead in crm
    $fieldNumOrigLead = $configTtpes['originalLeadFieldsByAccId'][$crmAccountNumber];
    //record number of orig lead
    $origLead = $fieldsValuesArray[$fieldNumOrigLead];
    //get all details of original lead from marechet am
    $getLeadResult = leadImGetLead(3310, $origLead);
    $origLeadCampaignName = getLeadDataSource($getLeadResult);
    $origLeadSupplaier =  getLeadSuplaierName($getLeadResult);
}

if($harBituahFile == null || $harBituahFile == ""){
    echo
        '<div class="alert alert-danger" role="alert" style="text-align: center;margin-top: 25px">
                 עליך להעלות קודם את קובץ הר ביטוח של הליד ורק אחר כך תוכל להגיש את ההצעה
        </div>';
    return false;
}else{?>
    <div class="container" role="main" id="back_form">
        <div class="text-center">
            <img src="logo3.png" class="rounded" style="width: 15%">
            <h4>הגשת הצעה לתפעול</h4>
        </div>
        <form class = "form" enctype="multipart/form-data" id="main-form" onsubmit="return validateFileSize()" action="submitPolicyHandler.php" class="" method="post" >
            <div class="form-group">
                <input id = "leadId" type="hidden" class="input-group form-control" value="<?php print $leadId ?>" placeholder="מספר הליד" name="recordNumber"/>
                <input id = "crmAccountNumber" type="hidden" class="input-group form-control" value="<?php print $crmAccountNumber ?>" placeholder="מספר חשבון" name="crmAcccountNumber"/>
                <input id = "currentUserName" type="hidden" class="input-group form-control" value="<?php print $currentUserName ?>"placeholder="שם הנציג" name="userName""/>
                <input id = "currentUserEmail" type="hidden" class="input-group form-control" value="<?php print $currentUserEmail ?>" placeholder="אימייל של הנציג" name="userEmail"/>
                <input id = "leadChannel" type="hidden" class="input-group form-control" value="<?php print $channelName?>" placeholder="ערוץ הליד" name="leadChannel"/>
                <input id = "origLeadCampaignName" type="hidden" class="input-group form-control" value="<?php print $origLeadCampaignName ?>" name="origLeadCampaignName"/>
                <input id = "origLeadSupplaier" type="hidden" class="input-group form-control" value="<?php print $origLeadSupplaier?>" name="origLeadSupplaier"/>
                <input id = "agentId" type="hidden" class="input-group form-control" value="<?php print $agentId?>" name="agentId"/>
                <input id = "harBituahFile" type="hidden" class="input-group form-control" value="<?php print $harBituahFile?>" name="harBituahFile"/>

            </div>

    <div class="row justify-content-center" style="text-align: center">
        <div class="col-12">
            <button type="button" class="btn btn-info showCastumerDetails" id="showCastumerDetails">
                <i class="material-icons addIcon showCastumerDetails" id="showCastumerDetails">add_circle</i>&nbsp;פרטי הלקוח&nbsp;
            </button>
            <div id = "alertCastumerDetails" class="alertCastumerDetails"></div>
            <div class="castumerDetails" id="castumerDetails">
            <div class="row justify-content-center" >
                <div class="col-12">
                    <label for="sel1">שם הלקוח</label>
                    <input required type="text" class="input-group form-control" value="<?php  print $fullName; ?>" placeholder="שם הלקוח" id="customerName" name="customerName" style="text-align: center"/>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label for="sel1">מין</label>
                    <select required class="form-control" id="sex" name="sex">
                        <option value> -- בחר מין --</option>
                        <option value="זכר">זכר</option>
                        <option value="נקבה">נקבה</option>
                    </select>
                </div>
                <div class="col-sm">
                    <label for="sel1">מצב משפחתי</label>
                    <select required class="form-control" id="marriageStatus" name="marriageStatus">
                        <option value> -- בחר מצב משפחתי --</option>
                        <option value="רווק">רווק</option>
                        <option value="נשוי">נשוי</option>
                        <option value="גרוש">גרוש</option>
                        <option value="אלמן">אלמן</option>
                        <option value="אחר">אחר</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label for="sel1">תאריך לידה</label>
                    <input required type="date" class="input-group form-control date"  data-date-format="dd-mm-yyyy" placeholder="תאריך לידה" name="birthDate"/>
                </div>
                <div class="col-sm">
                    <label for="sel1">דואר אלקטרוני</label>
                    <input required type="email" class="input-group form-control" placeholder="דוא''ל" name="customerEmail""/>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label for="sel1">תעודת זהות</label>
                    <input required type="text" class="input-group form-control"  placeholder="תעודת זהות" id="customerId" name="customerId"/>
                </div>
                <div class="col-sm">
                    <label for="sel1">תאריך הנפקת ת.ז</label>
                    <input required type="date"  class="input-group form-control"  placeholder="תאריך הנפקת תעודת זהות" name="issueDate"/>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label for="sel1">כתובת מלאה</label>
                    <input required class="form-control" rows="4" placeholder="כתובת מלאה" name="customerAddress"  id="customerAddress">
                </div>
                <div class="col-sm">
                    <label for="sel1">נייד</label>
                    <input required type="text" class="input-group form-control" value="<?php  print $pone; ?>" placeholder="מספר נייד" name="customerPhone"/>
                </div>
            </div>
                <br>
<!--               <button type="button" class="btn btn-danger delete" >מחיקת פרטי לקוח</button>-->
                <button type="button" class="btn btn-primary" id="finishEditCastumerDetails">סיום עריכת פרטי לקוח</button>

            </div>

            <br>
            <button type="button" class="btn btn-info" id="showPolicyDetails" style="background:#218BC3;border: solid 0.5px #218BC3" >
                <i class="material-icons addIcon addPolicy">add_circle</i>פרטי הפוליסה&nbsp;
            </button>
    </div>
    </div>
   </div>
    </form>
<?php
}
?>
<div class="alert alert-success" role="alert" id="response" style="visibility:hidden;margin: 0 auto;width: 80%">
  הפוליסות נקלטו במערכת בהצלחה
</div>









