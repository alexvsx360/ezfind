
<?php
include_once ("generalUtilities/leadImFunctions.php");
include_once ("generalUtilities/functions.php");
$acc_id = $_GET['crmAcccountNumber'];
$recordNumber = $_GET['recordNumber'];
$leadToPopulateJson = getLeadJson($_GET['recordNumber'], $acc_id, $_GET['agentId']);
$campaignId = $leadToPopulateJson['lead']['campaign_id'];
$fields = $leadToPopulateJson['lead']['fields'];
$ticketId = getTicketId($campaignId,$leadToPopulateJson);
$leadName = getCustomerFullName($acc_id, $leadToPopulateJson);
$channelName = $leadToPopulateJson['lead']['channel_name'];
$callCenterName = getCallCenterName($acc_id, $leadToPopulateJson)

?>
<html>
<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <link rel="stylesheet" href="css_bootstrap4/css/bootstrap-grid.css" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="css_bootstrap4/css/bootstrap.css" crossorigin="anonymous">
    <link rel="stylesheet" href="css_bootstrap4/css/bootstrap-reboot.css" crossorigin="anonymous">
    <script type="" charset="" src="css_bootstrap4/js/bootstrap.js"></script>
    <script type="" charset="" src="css_bootstrap4/js/bootstrap.bundle.js"></script>
<!--   <script type="" charset="" src="js/helperFunction.js"></script>-->
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="main.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery/3.2.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" integrity="sha384-FzT3vTVGXqf7wRfy8k4BiyzvbNfeYjK+frTVqZeNDFl8woCbF0CYG6g2fMEFFo/i" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-JAW99MJVpJBGcbzEuXk4Az05s/XyDdBomFqNlM3ic+I=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<body>


<div class="row justify-content-center">
    <div class="col-10" id ="infoDiv">
        <div class="alert alert-info " role="alert">
            הדף הבא <i class="fa fa-comments-o"></i>
             משמש לשליחת אסמס ללקוח על מנת שיצרף קבצי תמונות והקבצים יתעדכנו ישירות בטיקט שלו
            <br> מספר הטיקט:<?php print $ticketId." " ?>
            <br>
            <br>
            <i class="fa fa-arrow-circle-o-down"></i>
        </div>
    </div>

    <div class="col-10" id ="mainInfoDiv">
    <div class="alert alert-dark" role="alert">
        <p>האסמאס שישלח ללקוח</p>
        <div class="card">
            <div class="card-header">
                <?php print $leadName." " ?>שלום<br>
                <?php print $callCenterName." " ?> בהמשך לפניתך לקבוצת<br>
                ועל מנת להשלים את הטיפול בבקשת ה<?php print $channelName?><br>
                עליך לצרף את הקבצים הרצויים
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <form enctype="multipart/form-data" method="post" action="phpHendlers/sendSmsHendler.php" id ="form">
                    <textarea name="texToCustomer" id="texToCustomer" placeholder="... כאן ניתן לכתוב הודעה אישית ממך ללקוח"></textarea>
                </blockquote>
            </div>
        </div>
    </div>
</div>
    <div class="col-10" id ="">
        <div class="alert alert-info " role="alert">
            על מנת לשלוח את האסמס עליך ללחוץ על כפתור השליחה
            <br>
            <br>
            <i class="fa fa-arrow-circle-o-down"></i>
        </div>
    </div>
</div>
<div class="container" role="main" id="back_form">
<!--    <form enctype="multipart/form-data" method="post" action="phpHendlers/sendSmsHendler.php" id ="form">-->
        <input type="hidden" name="ticketId" value="<?php print $ticketId ?>">
        <input type="hidden" name="campaignId" value="<?php print $campaignId ?>">
        <input type="hidden" name="leadId" value="<?php print $recordNumber ?>">
        <input type="hidden" name="crmAccountNumber" value="<?php print $acc_id ?>">
        <input type="hidden" name="sourceInformation" value="crm">
        <div class="row justify-content-center">
            <button type="submit" id="sendSMS" class="btn btn-info">send SMS</button>
        </div>
    </form>
</div>
<br>
    <div class="row justify-content-center">
        <div class="col-10" id ="infoDivSuccess">
             <div class="alert alert-success" role="alert">
              כעת האסמס נשלח ללקוח, <i class="fa fa-check-circle-o"></i>
                על הלקוח לפתוח את האסמס, ללחוץ על הלינק שקיבל, לצרף את הקבצים ולשלוח
              </div>
        </div>
        <div class="col-10" id ="infoDivFailure">
             <div class="alert alert-danger" role="alert">
                האסמס לא נשלח ללקוח, <i class="fa fa-times-circle-o"></i>
                    מספר הטלפון או פרט אחר של הליד שגוי, ודא שכל הפרטים נכונים ונסה לשלוח שוב
              </div>
          </div>
      </div>
</body>
</html>
