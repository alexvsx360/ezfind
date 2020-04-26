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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>
    <title>פתח פנית שירות לקוחות חדשה</title>
</head>
<body>
<?php

include ('../generalUtilities/functions.php');
include ('../generalUtilities/leadImFunctions.php');
$configTypes = include('configTypes.php');

$customerFullName = ""; $customerPhone = ""; $ssn =""; $email =""; $callCenterName = ""; $recordNumber = "";


function savedInPastBy($selerMeshamer, $acc_id, $supplier_id)
{

    if ($selerMeshamer != "" && $selerMeshamer != "מוכרן מקורי") {
         return $selerMeshamer;
    } elseif ($selerMeshamer != "" && $selerMeshamer == "מוכרן מקורי") {
        $userJson = getUser($acc_id, $supplier_id);
        return $userJson['result']['name'];
    }
}
function isSaveInPast($savedInPastBy){
    if($savedInPastBy){
        return "כן";
    }else{
      return "לא";
    }
}
if ($_GET) {
    global
        $customerFullName,
        $customerPhone,
        $ssn,
        $email,
        $callCenterName;



    /*get lead information from the CRM*/
    $acc_id = $_GET['crmAcccountNumber'];
    $recordNumber = $_GET['recordNumber'];
    $agentId = $_GET['agentId'];
    $leadToPopulateJson = getLeadJson($_GET['recordNumber'], $acc_id, $_GET['agentId']);
    $leadId = $leadToPopulateJson['lead']['lead_id'];
    $customerPhone = getCustomerPhone($acc_id, $leadToPopulateJson);
    $customerFullName = getCustomerFullName($acc_id, $leadToPopulateJson);
    $ssn = getCustomerSsn($acc_id, $leadToPopulateJson);
    $email = getCustomerEmail($acc_id, $leadToPopulateJson);
    $callCenterName = getCallCenterName($acc_id, $leadToPopulateJson);
    $fields = $leadToPopulateJson['lead']['fields'];
    $callCenterManager =  $fields['104609'];
    $userEmail = $leadToPopulateJson['user']['email'];
    $userName = $leadToPopulateJson['user']['name'];
    $supplier = $leadToPopulateJson['lead']['supplier_id'];
    $cancelInsuranceCompany = $fields['102112'];
    $cancelInsuranceCompany = $configTypes['insuranceCompanyTypes'][$cancelInsuranceCompany];
    $cancelMonthlyPremia = $fields['100100'];
    $cancelPolicyType = $fields['102104'];
    $cancelPolicyType = $configTypes['cisuyTypes'][$cancelPolicyType];
    $cancelPolicyNumber = $fields['102145'];
    $actualPremia = $fields['102416'];
    $salesMan = $fields['100099'];
    $payWith = $fields['106839'];
    $sellingChannel = $fields['102131'];
    $supplier_id = $leadToPopulateJson['lead']['supplier_id'];
//    $getUserJson  = getUser($acc_id,$supplier_id);
    $getActiveUsers  = getActiveUsers($acc_id,60);
  //  $supplierEmail  = $getUserJson['result']['email'];
    $selerMeshamerFieldNum = $leadToPopulateJson['lead']['fields']['104604'];
    $selerMeshamer = $configTypes['sellerName'][$selerMeshamerFieldNum];
    $savedInPastBy = savedInPastBy($selerMeshamer, $acc_id, $supplier_id);
    $savedInPast = isSaveInPast($savedInPastBy);
    $isEverShumar = $leadToPopulateJson['lead']['fields']['125781'];
    $leadStatus = $leadToPopulateJson['lead']['status'];
    $premiaAfterShimur = $fields['104607'];
}


?>
    <div class="container" role="main" id="back_form">
        <div class="text-center">
            <img src="logo3.png" class="rounded">
        </div>
        <div class="row" >
            <form id="main-form" action="openLead.php"  class="" method="post" >
                <div class="form-group">
                    <input type="hidden" class="input-group form-control" value="<?php print $savedInPast; ?>"  name="savedInPast"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $payWith; ?>"  name="payWith"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $leadId; ?>"  name="leadId"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $savedInPastBy; ?>"  name="savedInPastBy"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $actualPremia; ?>"  name="actualPremia"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $cancelPolicyNumber; ?>"  name="cancelPolicyNumber"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $customerFullName; ?>"  name="customerName"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $customerPhone; ?>" name="customerPhone"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $ssn ?>"  name="customerSsn"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $sellingChannel ?>"  name="sellingChannel"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $email ?>"  name="customerEmail"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $recordNumber ?>" name="recordNumber"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $acc_id ?>" name="crmAccountNumber"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $callCenterManager ?>" name="callCenterManger"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $cancelMonthlyPremia ?>" name="cancelMonthlyPremia"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $cancelInsuranceCompany ?>" name="cancelInsuranceCompany"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $cancelPolicyType ?>" name="cancelPolicyType"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $userEmail ?>" name="userEmail"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $userName ?>" name="userName"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $supplier ?>" name="supplier"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $salesMan ?>" name="salesMan"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $callCenterName ?>" name="callCenterName"/>
                    <input type="hidden" class="input-group form-control" value="bitul" name="leadType"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $leadStatus ?>" name="leadStatus"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $isEverShumar ?>" name="isEverShumar"/>
                    <input type="hidden" class="input-group form-control" value="<?php print $premiaAfterShimur ?>" name="premiaAfterShimur"/>
                </div>
<!--                <div class="row" >-->
<!--                    <div class="col-xs-4 "></div>-->
<!--                    <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">-->
<!--                        <label for="sel1">שומר בעבר?</label>-->
<!--                        <select required class="form-control" id="saveInPast" name="saveInPast" placeholder="">-->
<!--                            <option value ="">--בחר האם שומר בעבר--</option>-->
<!--                            <option value ="כן">כן</option>-->
<!--                            <option value ="לא">לא</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="row" >
                    <div class="col-xs-4"></div>
                    <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                        <label for="sel1">תאריך כניסת הביטול:</label>
                        <input required type="date" class="input-group form-control date"  name="cancelDate"/>
                    </div>
                </div>
<!--                <div class="row" >-->
<!--                    <div class="col-xs-4 "></div>-->
<!--                    <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">-->
<!--                        <label for="sel1">סוג הביטול:</label>-->
<!--                        <select data-style="btn-default" required  id="cancelType" name="cancelType[]" class="selectpicker form-control" multiple  >-->
<!--                            <option value="שומר בעבר">שומר בעבר</option>-->
<!--                            <option value="מכתב ביטול">מכתב ביטול</option>-->
<!--                            <option value="מינוי סוכן">מינוי סוכן</option>-->
<!--                            <option value="ביטול הרשאה לחיוב">ביטול הרשאה לחיוב</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!--                </div>-->
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
                        <label for="sel1">שם הספק</label>
                        <select required class="form-control" id="" name="supplierNameEmail" placeholder="">
                            <option value ="אימייל;בקשה לביטול איש מכירות עזב;15348"> -- בחר את שם הספק --</option>
                            <?php
                            foreach($getActiveUsers['result'] as $key => $value){
                                echo '<option value="'.$value['email'].";".$value['name'].";".$value['id'].'">'.$value['name'].'</option>';}
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-xs-4 "></div>
                    <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                        <label for="sel1">סיווג מכתב ביטול</label>
                        <select required class="form-control" id="" name="moreDetailsOfBitul" placeholder="">
                            <option value ="">--סיווג מכתב ביטול--</option>
                            <option value ="טופס נחתם טלפונית">טופס נחתם טלפונית</option>
                            <option value ="אין מכתב ביטול">אין מכתב ביטול</option>
                            <option value ="לוגו של חברה מתחרה">לוגו של חברה מתחרה</option>
                            <option value ="נשלח על ידי סוכן">נשלח ע"י סוכן</option>
                            <option value ="הפניה משרות לקוחות">הפניה משרות לקוחות</option>
                            <option value ="נשלח על ידי מוקד -נחתם מרחוק">נשלח ע"י מוקד -נחתם מרחוק</option>
                        </select>
                    </div>
                </div>
                <br/>
                <div class="row" >
                    <div class="col-xs-4 "></div>
                    <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" style="width: 100%;">בחר את סוג הביטול
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="test" tabindex="-1" href="#">ביטול פוטנציאלי <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a type="הפניה מצוות חווית לקוח" tabindex="-1" href="#" class="potentialCancel">הפניה מצוות חווית לקוח</a></li>
                                        <li><a type="הפניה משרות הלקוחות" tabindex="-1" href="#" class="potentialCancel">הפניה משרות הלקוחות</a></li>
                                        <li><a type="הפניה ממוקד המכירות" tabindex="-1" href="#" class="potentialCancel">הפניה ממוקד המכירות</a></li>
                                        <li><a class="potentialCancel"  type="פיגור מתחילה" tabindex="-1" href="#">פיגור מתחילה<span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li><a class="pigurType" title="לבקשת_לקוח" tabindex="-1" href="#">לבקשת לקוח</a></li>
                                                <li><a class="pigurType" title="אין_הרשאה" tabindex="-1" href="#">אין הרשאה</a></li>
                                            </ul>
                                        </li>
                                        <li><a class="potentialCancel"  type="פיגור לאחר תשלום" tabindex="-1" href="#">פיגור לאחר תשלום<span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li><a class="pigurType" title="לבקשת_לקוח" tabindex="-1" href="#">לבקשת לקוח</a></li>
                                                <li><a class="pigurType" title="אין_הרשאה" tabindex="-1" href="#">אין הרשאה</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="test" tabindex="-1" href="#">ביטול יזום <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a type='חיתום בדיעבד שלא אישר' class="initiatedCancel" tabindex="-1" href="#">חיתום בדיעבד שלא אישר</a></li>
                                        <li><a type="העברת הלקוח לחברה אחרת" class="initiatedCancel" tabindex="-1" href="#">העברת הלקוח לחברה אחרת</a></li>
                                        <li><a type="הפוליסה הופסקה לקוח נפטר" class="initiatedCancel" tabindex="-1" href="#">הפוליסה הופסקה לקוח מפטר</a></li>
                                        <li><a type="מכירה לא תקינה" class="initiatedCancel" tabindex="-1" href="#">מכירה לא תקינה</a></li>
                                        <li><a type="פרויקט ישור קו CRM" class="initiatedCancel" tabindex="-1" href="#">פרויקט ישור קו CRM</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="test" tabindex="-1" href="#">ביטול רשמי<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a class="formalCancel" type="מכתב ביטול" tabindex="-1" href="#">מכתב ביטול</a></li>
                                        <li><a class="formalCancel" type="מינוי סוכן" tabindex="-1" href="#">מינוי סוכן</a></li>
                                        <li><a class="formalCancel"  type="ביטול מתחילה עקב פיגור" tabindex="-1" href="#">ביטול מתחילה עקב פיגור<span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a class="pigurType" title="לבקשת_לקוח" tabindex="-1" href="#">לבקשת לקוח</a></li>
                                            <li><a class="pigurType" title="אין_הרשאה" tabindex="-1" href="#">אין הרשאה</a></li>
                                        </ul>
                                            </li>
                                        <li><a class="formalCancel"  type="ביטול עקב פיגור לאחר תשלום" tabindex="-1" href="#">ביטול עקב פיגור לאחר תשלום<span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li><a class="pigurType" title="לבקשת_לקוח" tabindex="-1" href="#">לבקשת לקוח</a></li>
                                                <li><a class="pigurType" title="אין_הרשאה" tabindex="-1" href="#">אין הרשאה</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-xs-4 "></div>
                    <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                <input required type="text" id="cancelType" class="input-group form-control readonly"
                       name="cancelType"/>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-xs-4 "></div>
                    <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                <input required type="text" class="input-group form-control readonly"
                       name="cancelTypeDetails" id="cancelTypeDetails" />
                    </div>
                </div>
                    <div class="row" >
                        <div class="col-xs-5"></div>
                        <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                    <div class="checkbox" style="margin-right: 20px">
                        <label><input type="checkbox" name = "viturShimur" value="נציג מוותר על זכות השימור">נציג מוותר על זכות השימור</label><br>
                        <label><input type="checkbox" name = "policyThreeMonthsPassed" value="פוליסות מעל שלושה חודשים">פוליסות מעל שלושה חודשים</label>

                    </div>
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
        $(".readonly").keydown(function(e){
            e.preventDefault();
        });

        //new code for cancel type 26/03/19
        $('.dropdown a.test').on("click", function (e) {
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
        });
        $('.dropdown-menu a.formalCancel').on("click", function (e) {
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
        });
        $('.dropdown-menu a.potentialCancel').on("click", function (e) {
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
        });

        $(".potentialCancel").click(function () {
            $("#cancelType").val("ביטול פוטנציאלי");
            $("#cancelTypeDetails").val(this.type.split(' ').join('_'));
        });
        $(".initiatedCancel").click(function () {
            $("#cancelType").val("ביטול יזום");
            $("#cancelTypeDetails").val(this.type.split(' ').join('_'));
        });
        $(".formalCancel").click(function () {
            $("#cancelType").val("ביטול רשמי");
            $("#cancelTypeDetails").val(this.type.split(' ').join('_'));
            console.log($("#cancelTypeDetails").val());

        });
        $(".pigurType").click(function () {
            var cancelTypeDetails = $("#cancelTypeDetails").val();
            var cancelTypeWithOutPigurType = cancelTypeDetails.split(',_')[0];
            console.log(cancelTypeWithOutPigurType);
            $("#cancelTypeDetails").val(cancelTypeWithOutPigurType+",_"+ this.title);
        });
            ///////////////////////////////////

            $('input:checkbox').click(function() {
                $('input:checkbox').not(this).prop('checked', false);
            });


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