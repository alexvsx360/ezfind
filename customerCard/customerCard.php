<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 17/07/2018
 * Time: 15:03
 *
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>
    <link rel="stylesheet" href="css_bootstrap4/css/bootstrap-grid.css" crossorigin="anonymous">
    <link rel="stylesheet" href="css_bootstrap4/css/bootstrap.css" crossorigin="anonymous">
    <link rel="stylesheet" href="css_bootstrap4/css/bootstrap-reboot.css" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="css_bootstrap4/js/bootstrap.bundle.js" crossorigin="anonymous"></script>
    <script src="css_bootstrap4/js/bootstrap.js" crossorigin="anonymous"></script>
    <title>תמונת לקוח</title>
</head>
<body>
<br/>
<br/>
<div class="alert alert-secondary" role="alert">
    כרטיס לקוח
</div>
<div class="container">


    <?php
    include_once 'leadImFunctions/leadImFunctions.php';
    include_once 'classes/PolicyFactory.php';
    include_once 'classes/TifulSherutFieldsValues.php';
    $configTypes = include ('configTypes.php');
    $allLeadsPolicy = [];
    $allLeadsMuzareyZmicha= [];
    if ($_GET){
        $accId = $_GET['crmAcccountNumber'];
        $leadId = $_GET['recordNumber'];
    }
    $leadToPopulateJson = leadImGetLead($accId, $leadId);
    $ssnFieldId = "";
    //customer card
    switch ($accId){
        case 3694:
            $ssnFieldId = 102092;
            break;
        case 3305:
            $ssnFieldId = 90187;
            break;
        case 3328:
            $ssnFieldId = 101651;
            break;
        case 3326:
            $ssnFieldId = 93814;
            break;
        case 3325:
            $ssnFieldId = 93384;
            break;
        case 3327:
            $ssnFieldId = 106860;
            break;
        case 3317:
            $ssnFieldId = 110113;
            break;
        case 3474:
            $ssnFieldId = 98689;
            break;
        case 4767:
            $ssnFieldId = 132572;
            break;
        case 4805:
            $ssnFieldId = 134839;
            break;
        default:
            null;
    }
    $ssn = $leadToPopulateJson['lead']['fields'][$ssnFieldId];
    $ssnToArray = str_split($ssn);
    if($ssnToArray[0]== 0){
        $ssnWithZero = $ssn;
        $leadsMuzareyZmichaWithZero = leadInSearchLead(3694, 102092, $ssnWithZero, 18679, $mult = 1 );
        $leadspolicyWithZero = leadInSearchLead(3694, 102092, $ssnWithZero, 17967, $mult = 1 );
        unset($ssnToArray[0]);
        $ssn = implode("",$ssnToArray);
        $leadsMuzareyZmicha = leadInSearchLead(3694, 102092, $ssn, 18679, $mult = 1 );// 18679 = campaign muzarey zmicha,102092=num field of ssn
        $leadsPolicy = leadInSearchLead(3694, 102092, $ssn, 17967, $mult = 1 );

    }else{
        $ssnWithZero = "0".$ssn;
        $leadsMuzareyZmicha = leadInSearchLead(3694, 102092, $ssn, 18679, $mult = 1 );// 18679 = campaign muzarey zmicha,102092=num field of ssn
        $leadsPolicy = leadInSearchLead(3694, 102092, $ssn, 17967, $mult = 1 );
//if there ara policies with ssn that begin with 0
        $leadsMuzareyZmichaWithZero = leadInSearchLead(3694, 102092, $ssnWithZero, 18679, $mult = 1 );
        $leadspolicyWithZero = leadInSearchLead(3694, 102092, $ssnWithZero, 17967, $mult = 1 );//17967 = campaign policy
    }
    $leadIdMuzareyZmicha = $leadsMuzareyZmicha['lead_id'];
    $leadsIdpolicy = $leadsPolicy['lead_id'];

    $leadsIdMuzareyZmichaWithZero = $leadsMuzareyZmichaWithZero['lead_id'];
    $leadsIdpolicyWithZero = $leadspolicyWithZero['lead_id'];

    $countLeadsIdpolicyWithZero = count($leadsIdpolicyWithZero);
    $countLeadsIdpolicy = count($leadsIdpolicy);
    $countLeadsIdMuzareyZmichaWithZero = count($leadsIdMuzareyZmichaWithZero);
    $countLeadIdMuzareyZmicha = count($leadIdMuzareyZmicha);

    if($countLeadsIdMuzareyZmichaWithZero > 0 && $countLeadIdMuzareyZmicha > 0) {
        $leadIdMuzareyZmicha = array_merge($leadIdMuzareyZmicha, $leadsIdMuzareyZmichaWithZero);
    }
    if($countLeadsIdMuzareyZmichaWithZero <= 0 && $countLeadIdMuzareyZmicha > 0) {
        $leadIdMuzareyZmicha = $leadIdMuzareyZmicha;
    }
    if($countLeadsIdMuzareyZmichaWithZero > 0 && $countLeadIdMuzareyZmicha <= 0) {
        $leadIdMuzareyZmicha = $leadsIdMuzareyZmichaWithZero;
    }

    if($countLeadsIdpolicy > 0 && $countLeadsIdpolicyWithZero > 0) {
        $leadsIdpolicy = array_merge($leadsIdpolicy,$leadsIdpolicyWithZero);
    }
    if($countLeadsIdpolicy <= 0 && $countLeadsIdpolicyWithZero > 0) {
        $leadsIdpolicy = $leadsIdpolicyWithZero;
    }
    if($countLeadsIdpolicy > 0 && $countLeadsIdpolicyWithZero <= 0) {
        $leadsIdpolicy = $leadsIdpolicy;
    }


    $lengtArrayleadsIdMuzareyZmicha = count($leadIdMuzareyZmicha);
    $lengtArrayleadsIdpolicy = count($leadsIdpolicy);

    for($i=0; $i<$lengtArrayleadsIdpolicy;$i++) {
        $leadPolicyToPopulateJson = leadImGetLead(3694, $leadsIdpolicy[$i]);
        $policy = PolicyFactory::create($leadPolicyToPopulateJson, $configTypes, 3694);
        if(!is_null($policy)) {
            $getPolicy = $policy->getArrayFieldsValues();
            array_push($allLeadsPolicy, $getPolicy);
        }
    }
    for($i=0; $i<$lengtArrayleadsIdMuzareyZmicha;$i++){
        $leadMuzareyZmichaToPopulateJson = leadImGetLead(3694, $leadIdMuzareyZmicha[$i]);
        $muzareyZmicha = PolicyFactory::create($leadMuzareyZmichaToPopulateJson,$configTypes,3694);
        if(!is_null($muzareyZmicha)) {
            $getMuzareyZmicha = $muzareyZmicha->getArrayFieldsValues();
            array_push($allLeadsMuzareyZmicha, $getMuzareyZmicha);
        }
    }
    if(count($allLeadsPolicy)>0) {

        echo '
    <div class="alert alert-success" role="alert">
        פוליסות
</div>';
        foreach($allLeadsPolicy as $value) {
            foreach ($value as $prameters) {
                $policyType = $value['policyType'];
                $supplier = $value['supplier'];
                $status = $value['status'];
                $dateCreateLead = $value['dateCreateLead'];
                $linkLeadRecord = $value['linkLeadRecord'];
                $ticketLink = $value['ticketLink'];
                $actualPremia = $value['actualPremia'];
                $monthPremia = $value['monthPremia'];
                $insuranceCompany = $value['insuranceCompany'];
                $channel = $value['channel'];
                $policyLiveMonth = $value['policyLiveMonth'];
                $policyLiveDays = $value['policyLiveDays'];
                $policyNumber =  $value['policyNumber'];
            }
            if ($status == 'הופק ובוטל') {
                echo '
    <div class="mainDetailsLead mainDetailsLeadPolicy" style="background-color:#e4606d">
        <b> ' . $channel . '-' . $policyType . '<br>ב: ' . $insuranceCompany . '<br>פרמיה חודשית: ' . $monthPremia . '  ש"ח 
         <br></b>
         <a class="btn-outline-success showMore" style="cursor: pointer">פרטים נוספים</a>
        <div class="moreDetailsLead"> 
            <b>ספק </b>' . $supplier . '<br>
            <b>סטטוס</b>' . ' ' . $status . '<br>
            <b>פרמיה בפועל</b>' . ' ' . $actualPremia . '<br> 
            <b>תאריך</b>' . ' ' . gmdate("d-m-Y", $dateCreateLead) . '<br>
            <a target="_blank" href=' . $linkLeadRecord . '>לינק לרשומת מסד מקורית</a>
            <br>
            <b>משך חיי הפוליסה בחודשים</b>' . ' ' . $policyLiveMonth . '<br> 
            <b>משך חיי הפוליסה בימים</b>' . ' ' . $policyLiveDays . '<br> 
            <b>מספר פוליסה</b>' . ' ' . $policyNumber . '<br> 
            <a target="_blank" href=' . $ticketLink . '>לינק לטיקט</a>
        </div>
    </div>';

            }


            if ($status == 'התקבלה בקשה לביטול') {
                echo '
    <div class="mainDetailsLead mainDetailsLeadPolicy" style="background-color:#EAD1DC">
        <b> ' . $channel . '-' . $policyType . '<br>ב: ' . $insuranceCompany . '<br>פרמיה חודשית: ' . $monthPremia . '  ש"ח 
         <br></b>
         <a class="btn-outline-success showMore" style="cursor: pointer">פרטים נוספים</a>
        <div class="moreDetailsLead"> 
            <b>ספק </b>' . $supplier . '<br>
            <b>סטטוס</b>' . ' ' . $status . '<br>
            <b>פרמיה בפועל</b>' . ' ' . $actualPremia . '<br> 
            <b>תאריך</b>' . ' ' . gmdate("d-m-Y", $dateCreateLead) . '<br>
            <a target="_blank" href=' . $linkLeadRecord . '>לינק לרשומת מסד מקורית</a>
            <br>
            <b>משך חיי הפוליסה בחודשים</b>' . ' ' . $policyLiveMonth . '<br> 
            <b>משך חיי הפוליסה בימים</b>' . ' ' . $policyLiveDays . '<br> 
            <b>מספר פוליסה</b>' . ' ' . $policyNumber . '<br> 

            <a target="_blank" href=' . $ticketLink . '>לינק לטיקט</a>
        </div>
    </div>';
            }
                    if($status !== 'התקבלה בקשה לביטול' && $status !== 'הופק ובוטל'){
            echo '
    <div class="mainDetailsLead mainDetailsLeadPolicy" >
        <b> '.$channel.'-'.$policyType.'<br>ב: '.$insuranceCompany.'<br>פרמיה חודשית: '.$monthPremia.'  ש"ח 
         <br></b>
         <a class="btn-outline-success showMore" style="cursor: pointer">פרטים נוספים</a>
        <div class="moreDetailsLead"> 
            <b>ספק </b>'.$supplier.'<br>
            <b>סטטוס</b>'.' '.$status.'<br>
            <b>פרמיה בפועל</b>'.' '.$actualPremia.'<br> 
            <b>תאריך</b>'.' '.gmdate("d-m-Y", $dateCreateLead).'<br>
            <a target="_blank" href='.$linkLeadRecord.'>לינק לרשומת מסד מקורית</a>
            <br>
            <b>משך חיי הפוליסה בחודשים</b>'.' '.$policyLiveMonth.'<br> 
            <b>משך חיי הפוליסה בימים</b>'.' '.$policyLiveDays.'<br> 
            <b>מספר פוליסה</b>' . ' ' . $policyNumber . '<br> 

            <a target="_blank" href='.$ticketLink.'>לינק לטיקט</a>
        </div>
    </div>';
        }
        }
    }else{
        echo '
    <div class="alert alert-success" role="alert">
        ללקוח זה אין פוליסות 
</div>';
    }
    if(count($allLeadsMuzareyZmicha)>0) {
        echo '
<br>
<div class="alert alert-info" role="alert">
   מוצרי צמיחה
</div>';

        foreach($allLeadsMuzareyZmicha as $valueMuzareyZmicha) {
            foreach ($valueMuzareyZmicha as $prametersMuzareyZmicha) {
                $supplier = $valueMuzareyZmicha['supplier'];
                $status = $valueMuzareyZmicha['status'];
                $dateCreateLead = $valueMuzareyZmicha['dateCreateLead'];
                $linkLeadRecord = $valueMuzareyZmicha['linkLeadRecord'];
                $ticketLink = $valueMuzareyZmicha['ticketLink'];
                $paymentSum = $valueMuzareyZmicha['paymentSum'];
                $channel = $valueMuzareyZmicha['channel'];
            }
            echo '
    <div class="mainDetailsLead mainDetailsLeadMuzareyZmicha">
     <b> ' . $channel . '</b><br><b>ספק </b>' . $supplier .'</b><br><b>תאריך המכירה</b>' . ' ' . gmdate("d-m-Y", $dateCreateLead) .  '<br>
        
        <a class="btn-outline-info showMore" style="cursor: pointer">פרטים נוספים</a>
        <div class="moreDetailsLead"> 
            <b>סטטוס</b>' . ' ' . $status . '<br>
            <b>סכום העסקה</b>' . ' ' . $paymentSum . '<br>
            <a target="_blank" href=' . $linkLeadRecord . '>לינק לרשומת מסד מקורית</a>
            <br>
            <a target="_blank" href=' . $ticketLink . '>לינק לטיקט</a>
        </div>
    </div>';
        }
    }else{
        echo '
<br>
<div class="alert alert-info" role="alert">
   ללקוח זה אין מוצרי צמיחה
</div>';
    }
    ?>

</div>
</div>

</body>
</html>
<script>
    $(document).ready(function(){
        $(".showMore").click(function(){
            $(this).next(".moreDetailsLead").slideToggle();
            $(this).text(($(this).text() == 'פרטים נוספים') ? 'פחות פרטים' : 'פרטים נוספים');
        });
    });
</script>
