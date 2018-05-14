<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 25/04/2018
 * Time: 11:02
 */
?>

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
    <!-- Latest compiled and minified JavaScript -->
    <!--    <script src="../js/bootstrap.min.js" crossorigin="anonymous"></script>-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../ezfind/css_bootstrap4/js/bootstrap.bundle.js" crossorigin="anonymous"></script>
    <script src="../ezfind/css_bootstrap4/js/bootstrap.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="" charset="" src="js/helperFunction.js"></script>
    <title>שימור או ביטול</title>
</head>
<body>
<?php
session_start();
include_once('../generalUtilities/functions.php');
include_once('../generalUtilities/leadImFunctions.php');
$configTypes = include('configTypes.php');

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

   // $leadToPopulateJson = leadInSearchLead($acc_id, $_GET['recordNumber'], $_GET['agentId'],	18600);
    //$leadToPopulateJson = leadImGetLead($acc_id,  $_GET['recordNumber']);
    $leadToPopulateJson = getLeadJson($_GET['recordNumber'], $acc_id, $_GET['agentId']);
    $customerPhone = getCustomerPhone($acc_id, $leadToPopulateJson);
    $userEmail = $leadToPopulateJson['user']['email'];
    $userName = $leadToPopulateJson['user']['name'];
    $customerFullName = getCustomerFullName($acc_id, $leadToPopulateJson);
    $ssn = getCustomerSsn($acc_id, $leadToPopulateJson);
    $email = getCustomerEmail($acc_id, $leadToPopulateJson);
    $callCenterName = getCallCenterName($acc_id, $leadToPopulateJson);
    $address = getCustomerAddress($acc_id, $leadToPopulateJson);
    $address = str_replace("'", "", $address);
    $cancelDate = $leadToPopulateJson['lead']['fields']['103693'];
    $cancelPolicyType = $leadToPopulateJson['lead']['fields']['103701'];
    $ticketNumber = $leadToPopulateJson['lead']['fields']['103694'];
    $salesMan =  $leadToPopulateJson['lead']['fields']['103714'];
    $callCenterManager =  $configTypes['callCenterManagerName'][$callCenterName];
    $callCenterManagerMail  = $configTypes['callCenterManagerMail'][$callCenterManager];
    $leadIdToCancel = $leadToPopulateJson['lead']['fields']['107737'];
    //$cancelPolicyNumber = $leadToPopulateJson['lead']['fields']['107754'];
    $_SESSION["leadIdToCancel"] = $leadIdToCancel;

}

?>

<div class="container" role="main" id="back_form">
    <div class="text-center">
        <img src="logo3.png" class="rounded">
    </div>
    <form enctype="multipart/form-data" id="main-form" onsubmit="return validateFileSize()" action="bitulOrShimurHandler.php" class="" method="post" >
        <div class="form-group">
            <input type="hidden" class="input-group form-control" value="<?php print $userEmail ?>" name="userEmail"/>
            <input type="hidden" class="input-group form-control" value="<?php print $userName ?>" name="userName"/>
            <input type="hidden" class="input-group form-control" value="<?php print $callCenterManager ?>" name="callCenterManager"/>
            <input type="hidden" class="input-group form-control" value="<?php print $callCenterManagerMail ?>" name="callCenterManagerMail"/>
            <input type="hidden" class="input-group form-control" value="<?php print $recordNumber ?>" name="recordNumber"/>
            <input type="hidden" class="input-group form-control" value="<?php print $callCenterName ?>" name="callCenterName"/>
            <input type="hidden" class="input-group form-control" value="<?php print $acc_id?>" name="accId"/>
            <input type="hidden" class="input-group form-control" value="bitulOrShimur"  name="typeForm"/>
            <input type="hidden" class="input-group form-control" value="<?php print $cancelDate?>" name="cancelDate"/>
            <input type="hidden" class="input-group form-control" value="<?php print $cancelPolicyType?>" name="cancelPolicyType"/>
            <input type="hidden" class="input-group form-control" value="<?php print $ticketNumber?>" name="ticketNumber"/>
            <input type="hidden" class="input-group form-control" value="<?php print $salesMan?>" name="salesMan"/>
            <input type="hidden" class="input-group form-control" value="<?php if ($_GET['agentId']) { print $_GET['agentId']; } ?>"  name="agentId"/>
        </div>
        <div class="row justify-content-center">
            <div class="col-10">
                <label for="sel1"> בחר  שומר / בוטל </label>
                <div class="btn-group row justify-content-center col-12" role="group" id="radioBtn"">
                <button type="button" class="btn btn-secondary active" data-toggle="happy" data-title="ביטול"  id ="butal" >  בוטל </button>
                    <button type="button" class="btn btn-secondary" data-toggle="happy" data-title="שימור" id ="shumar" checked>שומר</button>

                <input type="hidden" name="customerCount" id="customerCount" value="שימור">
            </div>
            <div id ="formToLoad"></div>
        </div>
    </form>
</div>
<script>

    jQuery(document).ready(function () {

        $('#radioBtn button').on('click', function () {
            var sel = $(this).data('title');
            var tog = $(this).data('toggle');
            $('#' + tog).prop('value', sel);
            $('#customerCount').val(sel);


            $('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('active').addClass('notActive');
            $('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('notActive').addClass('active');
        });

        $("#formToLoad").load("edcunShimur.php");
        $("#shumar").click(function () {
            $("#formToLoad").load("edcunShimur.php");
        });
        $("#butal").click(function () {
            $("#formToLoad").load("edcunBitul.php");
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

        $('#main-form').submit(function () {
          //  $(this).find("button[type='submit']").prop('disabled', true);
        });
        // Check if the premia is greater than 0.
        $("body").on('click', "#submit", function () {
            $("#num_alert").css("visibility", "hidden");
            var num = $("#sumPremia").val();
            if (num < 1) {
                $("#num_alert").css("visibility", "visible");
                return false;
            }
            ;
        })
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
        })
    })

</script>

</body>
</html>