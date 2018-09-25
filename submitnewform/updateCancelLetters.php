<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 06/09/2018
 * Time: 12:33
 */

?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>

        <!-- Latest compiled and minified CSS -->
        <!--    <link rel="stylesheet" href="../css/bootstrap.min.css" crossorigin="anonymous">-->
        <!--    <!-- Optional theme -->
        <!--    <link rel="stylesheet" href="../css/bootstrap-theme.min.css" crossorigin="anonymous">-->
        <!--    <link rel="stylesheet" href="../css/style.css">-->
        <link rel="stylesheet" href="../css_bootstrap4/css/bootstrap-grid.css" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="../css_bootstrap4/css/bootstrap.css" crossorigin="anonymous">
        <link rel="stylesheet" href="../css_bootstrap4/css/bootstrap-reboot.css" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        <!--    <script src="../js/bootstrap.min.js" crossorigin="anonymous"></script>-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../css_bootstrap4/js/bootstrap.bundle.js" crossorigin="anonymous"></script>
        <script src="../css_bootstrap4/js/bootstrap.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script type="" charset="" src="js/helperFunctionSubmitPolicy.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.12.4.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <title>עדכון מכתבי ביטול</title>
    </head>
    <?php
    if ($_GET){
        $leadId = $_GET['recordNumber'];
        $crmAccountNumber = $_GET['crmAcccountNumber'];
        $agentId = $_GET['agentId'];
    }

    ?>
    <form>
        <input id = "leadId" type="hidden" class="input-group form-control" value="<?php print $leadId ?>" placeholder="מספר הליד" name="recordNumber"/>
        <input id = "crmAccountNumber" type="hidden" class="input-group form-control" value="<?php print $crmAccountNumber ?>" placeholder="מספר חשבון" name="crmAcccountNumber"/>
        <div class="container" role="main" id="back_form">
            <div class="row justify-content-center" style="text-align: center">
                <div class="col-12">
            <div class="text-center">
                <img src="logo3.png" class="rounded" style="width: 15%">
                <h4>עדכון מכתבי הביטול</h4>
            </div>
            <br/>
            <br/>

        <div class="row updateCancellationletters" id="updateCancellationletters0">
            <br>
            <br>
               <div class="col-sm" >
                     <label for="sel1">חברת הביטוח אליה ישלח הביטול</label>
                                <select required class="form-control updateCancelInsuranceCompany" id="updateCancelInsuranceCompany0" name="updateCancelInsuranceCompany">
                                        <option disabled selected value> -- לאיזו חברת ביטוח ישלח הביטול -- </option>
                                        <option value="הראל">הראל</option>
                                        <option value="הפניקס">הפניקס</option>
                                        <option value="מגדל">מגדל</option>
                                        <option value="מנורה">מנורה</option>
                                        <option value="כלל">כלל</option>
                                        <option value="הכשרה">הכשרה</option>
                                        <option value="שירביט">שירביט</option>
                                        <option value="שומרה">שומרה</option>
                                        <option value="דיקלה">דיקלה</option>
                                        <option value="איילון">איילון</option>
                                        <option value="AIG">AIG</option>
                                        <option value="IDI">IDI</option>
                                        <option value="פסגות">פסגות</option>
                                        <option value="שלמה ביטוח">שלמה ביטוח</option>
                                        <option value="אחר">אחר</option>
                                    </select>
                   </div>
               <div class="col-sm">
                     <label for="updateCancelfiles" style="cursor: pointer;">
                           <i class="material-icons" style="float: right;color:#e4606d">add_circle</i>צרף מכתב ביטול
                        </label>
                   <input aria-describedby="fileHelp" required type="file" class="form-control-file updateCancelfiles" name="updateCancelfiles[]" id="updateCancelfiles0"  multiple value=""/>
                 </div>
             <div class="w-100 d-none d-md-block"></div>
              <div class="col-md-6 offset-md-3">
                     <p class="addMoreUpdateCancellationletters" style="text-align: center"><u>להוספת מכתב ביטול נוסף </u></p>
<!--                     <p class="removeUpdateCancellationletters"  style="text-align: center"><u>להסרת מכתב הביטול</u></p>-->
                  </div>
            </div>
                    <br/>
            <button type="button" class="btn btn-info " id="submitUpdateCancelfiles">
                עדכן את מכתבי הביטול
            </button>
        </div>
            </div>
        </div>

    </form>
    <div class="alert alert-success" role="alert" id="response" style="visibility:hidden;margin: 0 auto;width: 80%">
עדכון מכתבי הביטול התבצע בהצלחה
    </div>
