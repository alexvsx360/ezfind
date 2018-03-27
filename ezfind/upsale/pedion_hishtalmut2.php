
<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 20/03/2018
 * Time: 10:42
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
    <link rel="stylesheet" href="../css/newStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <!--    <script src="../js/bootstrap.min.js" crossorigin="anonymous"></script>-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../css_bootstrap4/js/bootstrap.bundle.js" crossorigin="anonymous"></script>
    <script src="../css_bootstrap4/js/bootstrap.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="" charset="" src="../js/helperFunction.js"></script>
    <title>פדיון השתלמות</title>
</head>
<body>
<?php

include_once ('../../generalUtilities/functions.php');
include_once ('../../generalUtilities/leadImFunctions.php');


$customerFullName = ""; $customerPhone = ""; $ssn =""; $email =""; $callCenterName = ""; $recordNumber = "";
$address = ""; $secondaryCustomerName = ""; $secondaryCustomerSsn = "";
$userName = ""; $userEmail = ""; $issueDate = ""; $sellingChannel=""; $birthDate = "";
$employyType=""; $jobsCount=""; $sex=""; $customerFirstName = ""; $customerLastName="";
if ($_GET) {
    global $customerFullName,
           $customerPhone,
           $ssn,
           $email,
           $secondaryCustomerSsn,
           $secondaryCustomerName,
           $address,
           $userName,
           $userEmail,
           $sellingChannel,
           $issueDate,
           $birthDate,
           $employyType,
           $jobsCount,
           $sex,
           $customerFirstName,
           $customerLastName,
           $callCenterName;

    /*get lead information from the CRM*/
    $acc_id = $_GET['crmAcccountNumber'];
    $recordNumber = $_GET['recordNumber'];
    $leadToPopulateJson = getLeadJson($_GET['recordNumber'], $acc_id, $_GET['agentId']);
    $customerPhone = getCustomerPhone($acc_id, $leadToPopulateJson);
    $customerFullName = getCustomerFullName($acc_id, $leadToPopulateJson);
    $ssn = getCustomerSsn($acc_id, $leadToPopulateJson);
    $email = getCustomerEmail($acc_id, $leadToPopulateJson);
    $callCenterName = getCallCenterName($acc_id, $leadToPopulateJson);
    $address = getCustomerAddress($acc_id, $leadToPopulateJson);
    $address = str_replace("'", "", $address);
    $userName = $leadToPopulateJson['user']['name'];
    $userEmail = $leadToPopulateJson['user']['email'];

    $issueDate = $leadToPopulateJson['lead']['fields']['94522'];
    $birthDate = $leadToPopulateJson['lead']['fields']['94951'];
    $customerFirstName = $leadToPopulateJson['lead']['fields']['94516'];
    $customerLastName = $leadToPopulateJson['lead']['fields']['94517'];
    $employyType = ($leadToPopulateJson['lead']['fields']['98378'] == 98379 ? 'עצמאי' : 'שכיר');
    $jobsCount = $leadToPopulateJson['lead']['fields']['98382']; $jobsCount = preg_replace('/[^0-9]/', '', $jobsCount);
    $sex = ($leadToPopulateJson['lead']['fields']['103089'] == 103090 ? 'זכר' : 'נקבה');



    $sellingChannel = $leadToPopulateJson['lead']['channel_name'];
    $secondaryCustomerName = getSecondaryCustomerName($acc_id, $leadToPopulateJson);
    $secondaryCustomerSsn = getSecondaryCustomerSsn($acc_id, $leadToPopulateJson);

}

?>

<div class="container" role="main" id="back_form">
    <div class="text-center">
        <img src="../logo3.png" class="rounded">
    </div>
    <form enctype="multipart/form-data" id="main-form" action="upsaleHandler.php" class="" method="post" >
        <div class="form-group">
            <input type="hidden" class="input-group form-control" value="pedion_hishtalmut"  name="typeForm"/>
            <input type="hidden" class="input-group form-control" value="<?php print $customerFullName; ?>"  name="customerName"/>
            <input type="hidden" class="input-group form-control" value="<?php print $customerPhone; ?>" name="customerPhone"/>
            <input type="hidden" class="input-group form-control" value="<?php print $ssn ?>"  name="customerSsn"/>
            <input type="hidden" class="input-group form-control" value="<?php print $email ?>"  name="customerEmail"/>
            <input type="hidden" class="input-group form-control" value="<?php print $callCenterName ?>" name="callCenterName"/>
            <input type="hidden" class="input-group form-control" value="<?php print $recordNumber ?>" name="recordNumber"/>
            <input type="hidden" class="input-group form-control" value="<?php print $secondaryCustomerName ?>" name="secondaryCustomerName"/>
            <input type="hidden" class="input-group form-control" value="<?php print $secondaryCustomerSsn ?>" name="secondaryCustomerSsn"/>
            <input type="hidden" class="input-group form-control" value="<?php print $address ?>" name="address"/>
            <input type="hidden" class="input-group form-control" value="<?php print $userName ?>" name="userName"/>
            <input type="hidden" class="input-group form-control" value="<?php print $userEmail ?>" name="userEmail"/>
            <input type="hidden" class="input-group form-control" value="<?php print $issueDate ?>" name="issueDate"/>
            <input type="hidden" class="input-group form-control" value="<?php print $sellingChannel ?>" name="sellingChannel"/>
            <input type="hidden" class="input-group form-control" value="<?php print $birthDate ?>" name="birthDate"/>
            <input type="hidden" class="input-group form-control" value="<?php print $employyType ?>" name="employyType"/>
            <input type="hidden" class="input-group form-control" value="<?php print $jobsCount ?>" name="jobsCount"/>
            <input type="hidden" class="input-group form-control" value="<?php print $sex ?>" name="sex"/>
            <input type="hidden" class="input-group form-control" value="<?php print $customerFirstName ?>" name="customerFirstName"/>
            <input type="hidden" class="input-group form-control" value="<?php print $customerLastName ?>" name="customerLastName"/>
            <input type="hidden" class="input-group form-control" value="פדיון השתלמות" name="operationType"/>
            <input type="hidden" class="input-group form-control" value="<?php if ($_GET['agentId']) { print $_GET['agentId']; } ?>"  name="agentId"/>
        </div>
        <div class="row justify-content-center">
            <div class="col-8">
                <label for="sel1"> למי נותנים  - מועמד ראשי או משני</label>
                <div class="btn-group row justify-content-center col-12" role="group" id="radioBtn"">
                    <button type="button" class="btn btn-secondary" data-toggle="happy" data-title="2">משני </button>
                    <button type="button" class="btn btn-secondary active" data-toggle="happy" data-title="1" checked>  ראשי </button>

                <input type="hidden" name="customerCount" id="customerCount" value="1">

            </div>
                <div class="row justify-content-center">
                    <div class="col-12">
                        <label for="sel1">הגוף המנהל</label>
                        <input required type="text" class="input-group form-control" placeholder="כתוב את הגוף המנהל " name="insuranceCompany"/>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-12">
                        <label for="sel1">מספר הקופה</label>
                        <input required type="text" class="input-group form-control" placeholder="מספר הקופה" name="programNumber"/>
                    </div>
                </div>
            <label for="sel1">מעמד הקופה</label>
            <div class="input-group mb-3">
                <select class="custom-select"  id="programStatus" name="programStatus">
                    <option selected>-- בחר את מעמד הקופה --</option>
                    <option value="עצמאי">עצמאי</option>
                    <option value="שכיר">שכיר</option>
                </select>
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">:מעמד הקופה</label>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12">
                    <label for="sel1">סכום לפדיון</label>
                    <input required type="number" class="input-group form-control" placeholder="סכום לפדיון" name="pedionAmount"/>
                </div>
            </div>
                <label for="sel1">סוג המשיכה</label>
                    <div class="input-group mb-3">
                        <select class="custom-select"  iid="pedionType" name="pedionType">
                            <option selected> -- בחר את סוג המשיכה -- </option>
                            <option value="ותק מעל שש שנים">ותק מעל שש שנים</option>
                            <option value="השתלמות">השתלמות</option>
                            <option value="ותק שלוש שנים">ותק שלוש שנים וגם גיל פרישה</option>
                        </select>
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">:סוג המשיכה</label>
                        </div>
                    </div>

                <div class="row justify-content-center">
                    <div class="col-12">
                        <label for="sel1">סכום העסקה</label>
                        <input required type="number" class="input-group form-control" placeholder="סכום העסקה" name="paymentSum"/>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12">
                        <label for="sel1">מספר תשלומים</label>
                        <input required type="number" class="input-group form-control " placeholder="מספר תשלומים" name="paymentCount"/>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12">
                        <label for="sel1">הערות להצעה:</label>
                        <textarea class="form-control" rows="4"  id="comments" name="insuranceComment"></textarea>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12">
                        <label for="exampleInputFile">צרף מסמכים רלוונטיים</label>
                        <input aria-describedby="fileHelp" required type="file" class="form-control-file" name="file[]" id="InputFile"  multiple/>
                    </div>
                </div>

                <br/>
                <div class="row justify-content-center">
                    <div class="col-2">
                        <button type="submit" class="btn btn-primary" id="submit">הגש מכירה</button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>



<script>

    jQuery(document).ready(function () {

        $('#radioBtn button').on('click', function(){
            var sel = $(this).data('title');
            var tog = $(this).data('toggle');
            $('#'+tog).prop('value', sel);
            $('#customerCount').val(sel);


            $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
            $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
        });




        jQuery("#back_to_form").click(function () {
            jQuery('#back_form').removeClass('hide');
            jQuery('#button_block').hide();
        });


        jQuery('select#category').on('change', function (e) {
            var optionSelected = jQuery("option:selected", this);
            var valueSelected = this.value;

            jQuery('.cat_name').val(optionSelected.text());
        });
        jQuery("#main-form").submit(function () {
            $(this).find(':submit').val("פותח פניה...").attr('disabled', 'disabled');
        });

        jQuery("#submit").click(function () {
            var ddd = jQuery("#InputFile").val();
            if (ddd == "") {
                jQuery('.error').show();
                return false;
            }
            else {
                jQuery('.error').hide();
                return true;
            }
        });
    });
</script>

</body>
</html>