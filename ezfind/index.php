<?php
//ini_set('error_reporting', E_ALL);
//in/i_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>הגשת מכירה חדשה לאיזיפינד</title>
</head>
<body>
<?php

include ('../generalUtilities/functions.php');
include ('../generalUtilities/leadImFunctions.php');


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
        <img src="logo3.png" class="rounded">
    </div>
    <div class="row" >
        <form id="main-form" action="newSale.php" class="" method="post" >
            <div class="form-group">
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
                <input type="hidden" class="input-group form-control" value="<?php if ($_GET['agentId']) { print $_GET['agentId']; } ?>"  name="agentId"/>
            </div>
            <div class="row" >
                <div class="col-xs-4"></div>
                <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                    <div class="input-group">
                        <div id="radioBtn" class="btn-group">
                            <label for="sel1">תיק יחיד או זוגי?</label><br>
                            <a class="btn btn-primary btn-sm notActive" data-toggle="happy" data-title="2">זוגי</a>
                            <a class="btn btn-primary btn-sm active" data-toggle="happy" data-title="1">יחיד</a>
                        </div>
                        <input type="hidden" name="customerCount" id="customerCount" value="1">
                    </div>
                </div>
            </div>
            <div class="row" >
                <div class="col-xs-4 "></div>
                <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                    <label for="sel1">סכום העסקה</label>
                    <input required type="number" class="input-group form-control" placeholder="סכום העסקה" name="paymentSum"/>
                </div>
            </div>
            <div class="row" >
                <div class="col-xs-4 "></div>
                <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                    <label for="sel1">מספר תשלומים</label>
                    <input required type="number" class="input-group form-control" placeholder="משפר תשלומים" name="paymentCount"/>
                </div>
            </div>
            <div class="row" >
                <div class="col-xs-4 "></div>
                <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                    <input type="submit" class="btn btn-primary" id="submit" name="sendForm" value="הגש מכירה"/>
                </div>
            </div>
        </form>
    </div>



    <script>

        jQuery(document).ready(function () {

            $('#radioBtn a').on('click', function(){
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