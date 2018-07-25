<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 09/07/2018
 * Time: 11:05
 */


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>
    <link rel="stylesheet" href="css_bootstrap4/css/bootstrap-grid.css" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="css_bootstrap4/css/bootstrap.css" crossorigin="anonymous">
    <link rel="stylesheet" href="css_bootstrap4/css/bootstrap-reboot.css" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="css_bootstrap4/js/bootstrap.bundle.js" crossorigin="anonymous"></script>
    <script src="css_bootstrap4/js/bootstrap.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <title>העלאת הר ביטוח והוצאת ליד</title>
</head>
<body>
<?php
include_once ('generalUtilities/functions.php');
include_once ('generalUtilities/leadImFunctions.php');

$customerFullName = ""; $customerPhone = ""; $ssn =""; $email =""; $callCenterName = ""; $recordNumber = "";
$userName = ""; $userEmail = ""; $issueDate = ""; $customerFirstName = ""; $customerLastName="";
if ($_GET) {
    global $customerFullName,
           $customerPhone,
           $ssn,
           $email,
           $userName,
           $userEmail,
           $issueDate,
           $customerFirstName,
           $customerLastName;

    /*get lead information from the CRM*/
    $acc_id = $_GET['crmAcccountNumber'];
    $recordNumber = $_GET['recordNumber'];
    $leadToPopulateJson = getLeadJson($_GET['recordNumber'], $acc_id, $_GET['agentId']);
    $customerFullName = $leadToPopulateJson['lead']['fields']['94420']. " " . $leadToPopulateJson['lead']['fields']['102616'];
    $customerPhone = $leadToPopulateJson['lead']['fields']['94421'];
    $customerEmail = $leadToPopulateJson['lead']['fields']['94518'];
    $leadStatus = $leadToPopulateJson['lead']['status'];
    $userName = $leadToPopulateJson['user']['name'];
    $userEmail = $leadToPopulateJson['user']['email'];
}

?>

<div class="container" role="main" id="back_form">
    <div class="text-center">
        <img src="logo3.png" class="rounded">
    </div>
    <form enctype="multipart/form-data" id="main-form" onsubmit="return disableSubmit()" action="publishLeadHendler.php" class="" method="post" >
        <div class="form-group">
            <input type="hidden" class="input-group form-control" value="publishLead"  name="typeForm"/>
            <input type="hidden" class="input-group form-control" value="<?php print $customerFullName; ?>"  name="customerFullName"/>
            <input type="hidden" class="input-group form-control" value="<?php print $customerPhone; ?>" name="customerPhone"/>
            <input type="hidden" class="input-group form-control" value="<?php print $customerEmail ?>"  name="customerEmail"/>
            <input type="hidden" class="input-group form-control" value="<?php print $recordNumber ?>" name="recordNumber"/>
            <input type="hidden" class="input-group form-control" value="<?php print $userName ?>" name="userName"/>
            <input type="hidden" class="input-group form-control" value="<?php print $userEmail ?>" name="userEmail"/>
            <input type="hidden" class="input-group form-control" value="<?php print $acc_id ?>" name="crmAcccountNumber"/>
            <input type="hidden" class="input-group form-control" value="<?php if ($_GET['agentId']) { print $_GET['agentId']; } ?>"  name="agentId"/>
        </div>
        <div class="row justify-content-center" >
             <div class="col-12" style="text-align: right">
                  <label for="sel1" >: מספר ת.ז</label>
                 <input type="text" class="input-group form-control" placeholder="תעודת זהות" id="ssn" name="ssn" required/>
             </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12" style="text-align: right">
                <label for="sel1" >: תאריך הנפקת ת.ז</label>
                <input type="date" class="input-group form-control" placeholder="" id="issue-date" name="issue-date" required/>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12" style="text-align: right">
                <label for="sel1" >: מעשן / לא מעשן</label>
                <select required class="form-control" id="isSmoke" name="isSmoke">
                    <option disabled selected value> -- בחר מעשן/ לא מעשן -- </option>
                    <option value="1">מעשן</option>
                    <option value="0">לא מעשן</option>
                </select>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12" style="text-align: right">
                <label for="sel1" >: שכיר / עצמאי</label>
                <select required class="form-control" id="workStatus" name="workStatus">
                    <option disabled selected value> -- בחר שכיר / עצמאי -- </option>
                    <option value="lfv92295">שכיר</option>
                    <option value="lfv92294">עצמאי</option>
                </select>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12" style="text-align: right">
                <label for="sel1" >: קופת חולים</label>
                <select required class="form-control" id="kupa" name="kupa">
                    <option disabled selected value> -- בחר קופת חולים -- </option>
                    <option value="כללית">כללית</option>
                    <option value="מכבי">מכבי</option>
                    <option value="לאומית">לאומית</option>
                    <option value="מאוחדת">מאוחדת</option>
                    <option value="ללא קופת חולים">ללא קופת חולים</option>
                </select>
            </div>
        </div>

            <div class="col-12" style="text-align: right">
                <label for="exampleInputFile" >צרף קובץ הר ביטוח</label>
                <input aria-describedby="fileHelp" required type="file" class="form-control-file" name="file" id="InputFile" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
            </div>
        <br/>
        <div class="row justify-content-center">
            <div class="col-2">
                <button type="submit" class="btn btn-primary" id="submit">הגש ליד</button>
            </div>
        </div>
    </form>
</div>
<script>
        function disableSubmit() {
            if ($("#ssn").val() != "" && $("#issue-date").val() != "" && $("#InputFile").val() != "") {
                $("#submit").attr('disabled', 'disabled').val('פותח פניה ..');
                return true;
            }
        }

</script>
</body>
</html>