<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/23/2018
 * Time: 6:16 PM
 */

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

include ('../../../generalUtilities/functions.php');
include ('../../../generalUtilities/leadImFunctions.php');

$secondaryCustomerPhoneMapper = [
    '3305' => '90205', //mechirot bolotin
    '3325' => '93401', //elad shimoni
    '3326' => '93831', //mechirot eazy bituah
    '3328' => '94490' //ezfind
];
$key  = $secondaryCustomerPhoneMapper[$_POST['crmAcccountNumber']];
if ($_POST) {
    $result = leadImUpdateLead($_POST['crmAcccountNumber'], $_POST['recordNumber'], [$key => $_POST['phoneNumber']], true);
}
?>


<div class="container" role="main" id="">
    <br/>
    <br/>
    <div class="row justify-content-center" style="text-align: center">
        <div class="col-12">
            <?php if ($result == "OK"){ ?>
                <div class="alert alert-success" role="alert">
                    המספר עודכן בהצלחה!
                </div>
            <?php } else { ?>
                <div class="alert alert-danger" role="alert">
                    המספר לא עודכן!<br/>
                    <?php echo $result?>
                </div>
            <?php }?>

        </div>
    </div>
</div>

</body>
</html>