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
    $customerPhone = getCustomerPhone($acc_id, $leadToPopulateJson);
    $customerFullName = getCustomerFullName($acc_id, $leadToPopulateJson);
    $ssn = getCustomerSsn($acc_id, $leadToPopulateJson);
    $email = getCustomerEmail($acc_id, $leadToPopulateJson);
    $callCenterName = getCallCenterName($acc_id, $leadToPopulateJson);
}

?>
    <div class="container" role="main" id="back_form">


        <div class="text-center">
            <img src="logo3.png" class="rounded">
        </div>
        <div class="row" >
            <form id="main-form" action="openLead.php" class="" method="post" >
                <div class="form-group">
                    <input type="hidden" class="input-group form-control" value="<?php print $customerFullName; ?>"  name="customerName"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $customerPhone; ?>" name="customerPhone"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $ssn ?>"  name="customerSsn"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $email ?>"  name="customerEmail"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $callCenterName ?>" name="callCenterName"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $recordNumber ?>" name="recordNumber"/>
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
                        <label for="sel1">פרמיה חודשית</label>
                        <input required type="number" class="input-group form-control" placeholder="פרמיה חודשית" name="cancelMonthlyPremia"/>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-xs-4 "></div>
                    <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                        <label for="sel1">חברת ביטוח</label>
                        <select required class="form-control" id="cancelInsurenceCompany" name="cancelInsurenceCompany">
                            <option disabled selected value> -- בחר חברת ביטוח -- </option>
                            <option value="כלל">כלל</option>
                            <option value="הראל">הראל</option>
                            <option value="איילון">איילון</option>
                            <option value="הפניקס">הפניקס</option>
                            <option value="הכשרה">הכשרה</option>
                        </select>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-xs-4 "></div>
                    <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                        <label for="sel1">כיסוי ביטוחי:</label>
                        <select required class="form-control" id="cancelPolicyType" name="cancelPolicyType">
                            <option disabled selected value> -- בחר כיסוי ביטוחי -- </option>
                            <option value="תאונות אישיות">תאונות אישיות</option>
                            <option value="אובדן כושר עבודה">אכ"ע</option>
                            <option value="מחלות קשות">מחלות קשות</option>
                            <option value="חיים">ריסק</option>
                            <option value="בריאות">בריאות</option>
                            <option value="ביטוח משכנתא">ריסק למשכנתא</option>
                            <option value="סיעודי">סיעודי</option>
                        </select>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-xs-4 "></div>
                    <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                        <label for="sel1">איש מכירות:</label>
                        <input required type="text" class="input-group form-control" placeholder="איש מכירות" name="salesMan"/>

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