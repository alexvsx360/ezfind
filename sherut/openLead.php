<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" h    ref="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>הפניה נתפחה בהצלחה!</title>
</head>
<body>

<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/20/2017
 * Time: 3:32 PM
 */
include ('../generalUtilities/functions.php');
include ('../generalUtilities/leadImFunctions.php');

function generatePigurLeadPostData(){
    return [
        'lm_form' => 18492,
        'lm_key' => "c77fa08625",
        'lm_redirect' => "no",
        'name' => $_POST['customerName'],
        'phone' => $_POST['customerPhone'],
        'id' => $_POST['customerSsn'],
        'email' => $_POST['customerEmail'],
        'callCenter' => $_POST['callCenterName'],
        'insuranceCompanyPigur' => $_POST['insuranceCompany'],
        'pigurPolicy' => $_POST['pigurPolicy'],
        'premiaBepigur' => $_POST['premiaBepigur'],
        'pigurMonths' => $_POST['pigurMonths'],
        'linkToCustomer' => 'https://crm.ibell.co.il/a/3694/leads/' . $_POST['recordNumber']
    ];
}
function generateBitulLeadData(){
    return [
        'lm_form' => 18600,
        'lm_key' => "b15219b165",
        'lm_redirect' => "no",
        'name' => $_POST['customerName'],
        'phone' => $_POST['customerPhone'],
        'id' => $_POST['customerSsn'],
        'email' => $_POST['customerEmail'],
        'callCenter' => $_POST['callCenterName'],
        'cancelDate' => strtotime($_POST['cancelDate']),
        'cancelType' => $_POST['cancelType'],
        'cancelPolicyType' => $_POST['cancelPolicyType'],
        'cancelTicketNumber' => $_POST['cancelTicketNumber'],
        'cancelLink' => "https://ezfind.zendesk.com/agent/tickets/" . $_POST['cancelTicketNumber'],
        'cancelMonthlyPremia' => $_POST['cancelMonthlyPremia'],
        'cancelInsurenceCompany' => $_POST['cancelInsurenceCompany'],
        'salesMan' => $_POST['salesMan'],
        'linkToCustomer' => 'https://crm.ibell.co.il/a/3694/leads/' . $_POST['recordNumber']
    ];
}

function generateDoublePayLeadData(){
    return [
        'lm_form' => 18602,
        'lm_key' => "8435ae41bc",
        'lm_redirect' => "no",
        'name' => $_POST['customerName'],
        'phone' => $_POST['customerPhone'],
        'id' => $_POST['customerSsn'],
        'email' => $_POST['customerEmail'],
        'callCenter' => $_POST['callCenterName'],
        'insuranceStarDate' => strtotime($_POST['insuranceStarDate']),
        'cancelStartDate' => strtotime($_POST['cancelStartDate']),
        'isCancelLetter' => $_POST['isCancelLetter'],
        'cancelInsuranceCompany' => $_POST['cancelInsuranceCompany'],
        'doublePaymentCount' => $_POST['doublePaymentCount'],
        'linkToCustomer' => 'https://crm.ibell.co.il/a/3694/leads/' . $_POST['recordNumber']
    ];
}

if ($_POST){
    $newLeadId ="";
    $openLeadData = "";
    $newLeadId = "";
    $result =0;
    switch ($_POST['leadType']){
    case 'pigur':
            $openLeadData = generatePigurLeadPostData();
        break;
        case 'bitul':
            $openLeadData = generateBitulLeadData();
            break;
        case 'doublePay':
            $openLeadData = generateDoublePayLeadData();
            break;
        default:
        echo '$_POST[\'leadType\'] is not set!! ' . $_POST['leadType'];
        break;
    }
    $newLeadId = openNewLead($openLeadData);
    $result = addSherutLeadToCustomer($_POST['recordNumber'], $newLeadId);
}
?>
<div class="container" role="main" id="button_block">
    <div class="text-center">
        <img src="logo3.png" class="rounded">
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12 col-sm-12">
            <fieldset>
                <div class="col-xs-6 col-md-6 col-sm-6">
                    <a target="_blank" href="https://crm.ibell.co.il/a/3694/leads/<?php print $_POST['recordNumber'] ?>" class="btn btn-success">לצפיה בכרטיס הלקוח</a>
                </div>
                <div class="col-xs-6 col-md-6 col-sm-6">
                    <a target="_blank" href="https://crm.ibell.co.il/a/3694/leads/<?php print $newLeadId ?>" class="btn btn-success">לצפיה בפניה שנפתחה</a>
                </div>
            </fieldset>
        </div>
    </div>
</div>

    </body>
</html>