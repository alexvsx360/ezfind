
<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 17/05/2018
 * Time: 11:34
 */

session_start();
include_once("../generalUtilities/leadImFunctions.php");
$leadId = $_GET["recordNumber"];
$campaignId = $_GET["campaignId"];
$crmAccountNumber = $_GET["accountNum"];
$leadToPopulateJson = leadImGetLead($crmAccountNumber, $leadId);
if ($leadToPopulateJson['status'] == "success"){
    $ticketId = getTicketId($campaignId,$leadToPopulateJson);
    $leadName = $leadToPopulateJson['lead']['fields'][100086];
    $textToCustomer = $leadToPopulateJson['lead']['fields'][108912];
    $channelName = $leadToPopulateJson['lead']['channel_name'];
    $callCenterName = getCallCenterName($crmAccountNumber, $leadToPopulateJson);
    $supplierId = $leadToPopulateJson["lead"]["supplier_id"];
    $userDetails = getUser($crmAccountNumber,$supplierId);
    $userName = $userDetails["result"]["name"];
    $userEmail = $userDetails["result"]["email"];
}else{
    $leadName="";
}
$_SESSION['leadId']=$leadId;
$_SESSION['campaignId']=$campaignId;
$_SESSION['leadName']=$leadName;
$_SESSION['callCenterName'] = $callCenterName;
$_SESSION['channelName'] = $channelName;
?>
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
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand" rel="stylesheet">
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>צרף קבצים</title>
</head>
<body>
<br>
<div class="card text-center" id="infoDivToUploadFile">
    <div class="card-header">
       <b><?php print $leadName." " ?>שלום<br></b>
        <?php print $callCenterName." " ?> בהמשך לפניתך לקבוצת<br>
        ועל מנת להשלים את הטיפול בבקשת ה<?php print $channelName?><br>
        עליך לצרף את הקבצים הרצויים<br>
    </div>
    <?php if($textToCustomer!== ""){
        $textToCustomer = str_replace('_', ' ', $textToCustomer);?>
        <div class="card-header">
    <p id="printTextToCustomer"><b> :הודעה מאת הנציג</b><br> <?php print $textToCustomer." " ?> </p>
    </div>
    <?php } ?>
    <div class="card-body">
        <h5 class="card-title">בחר את הקבצים הרצויים ושלח</h5>
        <form action="" method="post" id="formPostFile">
            <div class="form-group"></div>
            <input type="hidden" class="form-control" value="<?php print $leadName; ?>" id="leadName" name="leadName">
            <input type="hidden" class="form-control" value="<?php print $userName; ?>" id="userName" name="userName">
            <input type="hidden" class="form-control" value="<?php print $userEmail; ?>" id="userEmail" name="userEmail">
            <input type="hidden" class="form-control" value="<?php print $crmAccountNumber; ?>" id="crmAccountNumber" name="crmAccountNumber">
            <input type="hidden" class="form-control" value="<?php print $ticketId; ?>" id="ticetId" name="ticetId">
            <input type="hidden" class="form-control" value="<?php print $leadId; ?>" id="recordNumber" name="recordNumber">
            <input type="hidden" class="form-control" value="<?php print $campaignId; ?>" id="campaignId" name="campaignId">
            <input type="hidden" class="form-control" value="zendesk" id="updateIn" name="updateIn">
            <div class="upload-btn-wrapper">
                <button class="btno" multiple accept="image/*" > לחץ כדי לצרף את הקבצים <i class="fa fa-paperclip"></i></button>
                <input required type="file" class="form-control-file inputFile inputfile btno" id="gallery-photo" accept="image/*"  multiple name="file[]">
            </div>
            <br>
            <div class="gallery"></div>
            <br>
            <textarea id="texFromCustomer" name="textFromCustomer" placeholder="כאן ניתן להוסיף הודעה... "></textarea>
            <br>
            <br>
            <button type="submit" id="submit" class="btn btn-primary SubmitButton">שלח את הקבצים</button>
    </div>
    </form>
</div>
<p class="alert alert-danger" role="alert" id ="alertNotFile">
</p>
<div class="card-footer text-muted">
    שים לב ניתן לצרף מספר קבצים יחד
    <i class="fa fa-asterisk" style="font-size:10px"></i>
</div>
</div>
</body>
<div class="modal fade" tabindex="-1" role="dialog" id="modal" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php print $leadName; ?> שלום </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="modal-body"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="fade"></div>
<div id="modalLoading">
    <img id="loader" src="../clock-loading.gif" />
</div>
</div>
</html>

