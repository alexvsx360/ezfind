<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="../css_bootstrap4/css/bootstrap-grid.css" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="../css_bootstrap4/css/bootstrap.css" crossorigin="anonymous">
<link rel="stylesheet" href="../css_bootstrap4/css/bootstrap-reboot.css" crossorigin="anonymous">
<script type="" charset="" src="../css_bootstrap4/js/bootstrap.js"></script>
<script type="" charset="" src="../css_bootstrap4/js/bootstrap.bundle.js"></script>
<script type="" charset="" src="../js/helperFunction.js"></script>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 21/06/2018
 * Time: 10:21
 */
session_start();
//$leadId = $_SESSION['leadId'];
//$campaignId = $_SESSION['campaignId'];
$leadName = $_SESSION['leadName'];
//$callCenterName = $_SESSION['callCenterName'];
//$channelName = $_SESSION['channelName'];
 ?>

<html lang="en">
<head>
    <meta charset="utf-8">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>הקבצים נקלטו</title>
</head>
    <body>
        <div class="jumbotron"  id="jumbotronSucsses">
                    <img src="logo3.png" alt="" width="120" height="80" class="d-inline-block align-top"/>
            <h1 class="display-4"> ! הקבצים נקלטו בהצלחה</h1>
            <p class="lead"> <?php print $leadName." " ?>הקבצים ששלחת נקלטו במערכת והם מועברים להמשך טיפול</p>
            <hr class="my-4">
            <p>.תודה על פניתך לחברתנו ובהצלחה</p>
        </div>
</body>