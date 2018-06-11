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

    <title>פתח פנית שירות לקוחות חדשה</title>
</head>
<body>
<?php

include ('../generalUtilities/functions.php');
include ('../generalUtilities/leadImFunctions.php');
$configTypes = include('configTypes.php');

$customerFullName = ""; $customerPhone = ""; $ssn =""; $email =""; $callCenterName = ""; $recordNumber = "";

if ($_GET) {
    global $customerFullName,
        $customerPhone,
        $ssn,
        $email,
        $callCenterName;

    /*get lead information from the CRM*/
    $acc_id = $_GET['crmAcccountNumber'];
    $recordNumber = $_GET['recordNumber'];
    $leadToPopulateJson = getLeadJson($_GET['recordNumber'], $acc_id, $_GET['agentId']);
    $leadId = $leadToPopulateJson['lead']['lead_id'];
    $customerPhone = getCustomerPhone($acc_id, $leadToPopulateJson);
    $customerFullName = getCustomerFullName($acc_id, $leadToPopulateJson);
    $ssn = getCustomerSsn($acc_id, $leadToPopulateJson);
    $email = getCustomerEmail($acc_id, $leadToPopulateJson);
    $callCenterName = getCallCenterName($acc_id, $leadToPopulateJson);
    $fields = $leadToPopulateJson['lead']['fields'];
    $callCenterManager =  $fields['104609'];
    $userEmail = $leadToPopulateJson['user']['email'];
    $userName = $leadToPopulateJson['user']['name'];
    $supplier = $leadToPopulateJson['lead']['supplier_id'];
    $cancelInsuranceCompany = $fields['102112'];
    $cancelInsuranceCompany = $configTypes['insuranceCompanyTypes'][$cancelInsuranceCompany];
    $cancelMonthlyPremia = $fields['100100'];
    $cancelPolicyType = $fields['102104'];
    $cancelPolicyType = $configTypes['cisuyTypes'][$cancelPolicyType];
    $cancelPolicyNumber = $fields['102145'];
    $actualPremia = $fields['102416'];
    $salesMan = $fields['100099'];
    $supplier_id = $leadToPopulateJson['lead']['supplier_id'];
   // $getUserJson  = getUser($acc_id,$supplier_id);
    $getActiveUsers  = getActiveUsers($acc_id,60);
  //  $supplierEmail  = $getUserJson['result']['email'];
}

?>
    <div class="container" role="main" id="back_form">


        <div class="text-center">
            <img src="logo3.png" class="rounded">
        </div>
        <div class="row" >
            <form id="main-form" action="openLead.php"  class="" method="post" >
                <div class="form-group">
                    <input type="hidden" class="input-group form-control" value="<?php print $leadId; ?>"  name="leadId"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $actualPremia; ?>"  name="actualPremia"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $cancelPolicyNumber; ?>"  name="cancelPolicyNumber"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $customerFullName; ?>"  name="customerName"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $customerPhone; ?>" name="customerPhone"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $ssn ?>"  name="customerSsn"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $email ?>"  name="customerEmail"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $recordNumber ?>" name="recordNumber"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $acc_id ?>" name="crmAccountNumber"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $callCenterManager ?>" name="callCenterManger"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $cancelMonthlyPremia ?>" name="cancelMonthlyPremia"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $cancelInsuranceCompany ?>" name="cancelInsuranceCompany"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $cancelPolicyType ?>" name="cancelPolicyType"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $userEmail ?>" name="userEmail"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $userName ?>" name="userName"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $supplier ?>" name="supplier"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $salesMan ?>" name="salesMan"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $callCenterName ?>" name="callCenterName"/>
                    <input type="hidden" class="input-group form-control" value="bitul" name="leadType"/>
                </div>
                <div class="row" >
                    <div class="col-xs-4"></div>
                    <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                        <label for="sel1">תאריך כניסת הביטול:</label>
                        <input required type="date" class="input-group form-control date"  name="cancelDate"/>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-xs-4 "></div>
                    <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                        <label for="sel1">סוג הביטול:</label>
                        <select required class="form-control" id="cancelType" name="cancelType">
                            <option disabled selected value> -- בחר את סוג הביטול -- </option>
                            <option value="מכתב ביטול">מכתב ביטול</option>
                            <option value="מינוי סוכן">מינוי סוכן</option>
                        </select>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-xs-4 "></div>
                    <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                        <label for="sel1">מספר טיקט של מכתב הביטול</label>
                        <input required type="number" class="input-group form-control" placeholder="מספר טיקט של מכתב הביטול" name="cancelTicketNumber"/>
                    </div>
                </div>

                <div class="row" >
                    <div class="col-xs-4 "></div>
                    <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                        <label for="sel1">שם הספק</label>
                        <select required class="form-control" id="" name="supplierNameEmail" placeholder="">
                            <option value ="אימייל;בקשה לביטול איש מכירות עזב;15348"> -- בחר את שם הספק --</option>

                            <?php
                            foreach($getActiveUsers['result'] as $key => $value){
                                echo '<option value="'.$value['email'].";".$value['name'].";".$value['id'].'">'.$value['name'].'</option>';}
                            ?>
                        </select>
                    </div>
                </div>
                    <div class="row" >
                        <div class="col-xs-5"></div>
                        <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                    <div class="checkbox">
                        <label><input type="checkbox" name = "viturShimur" value="נציג מוותר על זכות השימור">נציג מוותר על זכות השימור</label>
                    </div>
                    </div>
                    </div>

                <div class="row" >
                    <div class="col-xs-4 "></div>
                    <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                        <input type="submit" class="btn btn-primary" id="submit" name="sendForm" value="פתח פניה"/>
                    </div>
                </div>

            </form>
        </div>



    <script>
    jQuery(document).ready(function () {


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