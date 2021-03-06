<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css"  crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css"  crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Upload files</title>
</head>
<body>
<?php

include ('functions.php');
include_once ('leadImFunctions.php');

function createMainRecord ($result){
    $crmAccountNumberNameJson =[
        "3328" => "ezfind",
        "3326" => "ez ביטוח",
        "3474" => "אביב בר שי",
        "3325" => "אלעד שמעוני",
        "3305" => "מוקד בולוטין",
        "3313" => "מוקד פרחי",

    ];
    $salesmanName = getRecordInitializerdName($_POST['recordNumber'], $_POST['crmAcccountNumber'], $_POST['agentId']);
    $baseUrl = "http://api.lead.im/v1/submit";
    $postData['lm_form'] = "18573";
    $postData['lm_key'] = "fde1fae3d6";
    $postData['lm_redirect'] = "no";
    $postData['name'] = $_POST['name'];
    $postData['phone'] = $_POST['phone'];
    $postData['ssn'] = $_POST['ssn'];
    $postData['issue-date'] = $_POST['issue-date'];
    $postData['orig_lead_number'] = $_POST['recordNumber'];
    $postData['leader'] = $salesmanName;
    $postData['callCenterName'] = $crmAccountNumberNameJson[$_POST['crmAcccountNumber']];
    $postData['insurmt'] = "https://portal.ibell.co.il/user-upload/" . $_POST["recordNumber"] . "/" . $result->file;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $baseUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_exec($ch);
    curl_close($ch);
}

//print_r($_POST);
//print_r($_FILES);
$myfile = fopen("log.txt", "a");
$cfile = curl_file_create($_FILES['file']['tmp_name'], $_FILES['file']['type'], $_FILES['file']['name']);

//print_r('UPLOAD START');

if ($curl = curl_init()) {
//print_r('CURL START');
//curl_setopt($curl, CURLOPT_URL, 'http://xlsx_parse.webmind28.com/api.php');
//ladress 'http://192.168.150.223/api.php'
curl_setopt($curl, CURLOPT_URL,'http://199.203.203.237/api.php');//'http://212.143.233.53/api.php'
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
curl_setopt($curl, CURLOPT_POSTFIELDS, array(
    'crmAcccountNumber'=>$_POST['crmAcccountNumber'],
    'recordNumber'=>$_POST['recordNumber'],
    'agentId'=>$_POST['agentId'],
    'name'=>$_POST['name'],
    'phone'=>$_POST['phone'],
    'file_category'=>$_POST['file_category'],
    'cat_name'=>$_POST['cat_name'],
    'fileType'=>$_POST['fileType'],
    'file' => $cfile,
    'ssn' => $_POST['ssn'],
    'issue-date' => $_POST['issue-date'],
));
//print_r('CURL END');
$out = curl_exec($curl);
$result = json_decode(trim($out));
curl_error($curl);

fwrite($myfile, "\nPrinting the out parameter " . $out);

//   echo $out;
// if ($out!="Data saved successfully") {
//     print $out;
// }
if ($result->success != true) {
    // print_r($out);
}

if ($result->success == true) {
    $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/user-upload/'.$_POST['recordNumber'];
    if (!file_exists($uploadDir)) {
        $new_dir = mkdir ($uploadDir, 0775);
    }
    $fileName   = $uploadDir."/".$result->file;
    move_uploaded_file($_FILES['file']['tmp_name'], $fileName);

    createMainRecord($result);
    $today = strtotime('today');
    switch ($_POST['crmAcccountNumber']){
    case 3305:
        $updateFieldsKeyValue = [
            "90187" => $_POST['ssn'],
            "95896" => strtotime($_POST['issue-date']),
            "110122" => $today
        ];
        leadImUpdateLead($_POST['crmAcccountNumber'], $_POST['recordNumber'], $updateFieldsKeyValue, true);
    case 3317:
        $updateFieldsKeyValue = [ 110117 => "https://portal.ibell.co.il/user-upload/" . $_POST["recordNumber"] . "/" . $result->file];
        leadImUpdateLead($_POST['crmAcccountNumber'], $_POST['recordNumber'], $updateFieldsKeyValue, true);


    }

    ?>
    <script type="text/javascript">
        $(function() {

            var formData= new Object;
            formData['fld_id'] = <?php print $_POST['file_category']; ?>;
            //formData['fld_val']='/user-upload/<?php print $leadid; ?>/<?php print $newnameimg; ?>';
            formData['fld_val']='https://portal.ibell.co.il/user-upload/<?php print $_POST["recordNumber"]?>/<?php print $result->file ?>';

            console.log(<?php print $_POST['file_category']; ?>);
            $.ajax({
                url: 'https://proxy.leadim.xyz/apiproxy/acc3305/updatelead.ashx',
                type: "post",
                data: {'acc_id':<?php print $_POST['crmAcccountNumber']; ?>, 'usr_id':<?php print $_POST['agentId']; ?>, 'lead_id':<?php print $_POST['recordNumber']; ?>,'update_fields':formData},

                success: function(html){
                    console.log(html);
                }
            });
        })
    </script>

    <div class="container" role="main"id="button_block">
        <div class="row">
            <div class="col-xs-12 col-md-12 col-sm-12 logocenter-small">
                <img src="logo3.png" />
            </div>

            <div class="col-xs-12 col-md-12 col-sm-12">
                <fieldset>
                    <!--<div class="col-xs-4 col-md-4 col-sm-4">
                                    <a href="http://212.143.233.53/user-upload/<?php print $leadid; ?>/<?php print $newnameimg; ?>" class="button_center btn btn-default">הצג מסמך</a>
                                </div>-->
                    <div class="col-xs-6 col-md-6 col-sm-6">

                        <a href="javascript:history.back()" class="button_center btn btn-default"> הוסף מסמך נוסף</a>

                        <!-- <a href="<?php print (isset($_SERVER["HTTPS"]) ? "https://" : "http://") . $_SERVER['SERVER_NAME']."/".$_SERVER['REQUEST_URI']; ?>/?recordNumber=<?php print $leadid; ?>&crmAcccountNumber=<?php print $crmAccount; ?>&agentId=<?php print $agentid; ?>&fileType=<?php print $files ?>&name=<?php print $_POST['name']; ?>&phone=<?php print $_POST['phone']; ?>" class="button_center btn btn-default"> הוסף מסמך נוסף</a> -->

                        <!--<button type="button" id="back_to_form" class="button_center btn btn-default">הוסף מסמך נוסף</button>-->
                    </div>
                    <div class="col-xs-6 col-md-6 col-sm-6">
                        <a href="http://portal.ibell.co.il/user-upload/<?php print $_POST['recordNumber']; ?>/<?php echo $result->file; ?>" target="_blank" class="button_center btn btn-default"> הצג מסמך</a>
                        <!-- <a href="http://212.143.233.53/list.php" class="button_center btn btn-default"> List</a> -->

                        <!--<button type="button" id="back_to_form" class="button_center btn btn-default">הוסף מסמך נוסף</button>-->
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

<?php
} else if ($result->success==false){

if ($result->error)
{
$error=json_decode($result->error);

foreach($error as $it)
{

?>
    <div class="alert alert-danger">
        <?php print $it; ?>
    </div>
    <?php
}
}
}
?>



</body>
</html>
<?php
curl_close($curl);
}
