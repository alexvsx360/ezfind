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
    <link rel="stylesheet" href="../css/bootstrap.min.css" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="../css/bootstrap-theme.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="../js/bootstrap.min.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>עדכון מספר טלפון למבוטח משני</title>
</head>
<body>
<?php


$crmAcccountNumber =""; $recordNumber="";



if ($_GET) {
    global $recordNumber, $crmAcccountNumber;
    /*get lead information from the CRM*/
    $crmAcccountNumber = $_GET['crmAcccountNumber'] ?? "";
    $recordNumber = $_GET['recordNumber'] ?? "";

?>

<div class="container" role="main" id="back_form">


    <div class="text-center">
        <img src="../logo3.png" class="rounded">
    </div>
    <div class="row" >
        <form id="main-form" action="updateHandler.php" class="" method="post" >
            <div class="form-group">
                <input type="hidden" class="input-group form-control" value="<?php print $crmAcccountNumber; ?>"  name="crmAcccountNumber"/>
                <input type="hidden" class="input-group form-control" value="<?php print $recordNumber ?>" name="recordNumber"/>
                <input type="hidden" class="input-group form-control" value="90205" name="key"/>

            </div>
            <div class="row" >
                <div class="col-xs-4 "></div>
                <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                    <label for="sel1">מספר טלפון מבוטח משני</label>
                    <input required type="text" class="input-group form-control" placeholder="מספר טלפון מבוטח משני" name="phoneNumber"/>

                </div>
            </div>
            <div class="row" >
                <div class="col-xs-4 "></div>
                <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                    <input type="submit" class="btn btn-primary" id="submit" name="sendForm" value="עדכן מספר טלפון"/>
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

    <?php
    }
     ?>

</body>
</html>