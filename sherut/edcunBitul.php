<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 25/04/2018
 * Time: 13:57
 */
$configTypes = include('configTypes.php');
session_start();
$leadIdToCancel = "";
if($_SESSION["leadIdToCancel"]!==null){
    $leadIdToCancel =  $_SESSION["leadIdToCancel"];
}

?>
    <div class="row justify-content-center">
        <div class="col-12">
            <label for="sel1">מספר רשומה של הליד לביטול</label>
            <?php
            if ($_SESSION["leadIdToCancel"] !== ""){?>
                <input required type="text" class="input-group form-control" value = "<?php print $leadIdToCancel; ?>" name="leadIdToCancel" readonly/>
                <?php ;}
            else {
                echo '<input required type="text" class="input-group form-control" placeholder="מספר רשומה של הליד לביטול" name="leadIdToCancel"/>';
            };?>
        </div>
        </div>
<label for="sel1">? האם בוצעה גביה ראשונה</label>
<div class="input-group mb-3">
    <select class="custom-select"  id="firstPayment" name="firstPayment">
        <option selected>-- ? האם בוצעה גביה ראשונה --</option>
        <option value="כן">כן</option>
        <option value="לא">לא</option>
    </select>
    <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01">? האם בוצעה גביה ראשונה </label>
    </div>
</div>
        <div class="col-12">
            <label for="sel1"> משך חיי הפוליסה</label>
            <input required type="text" class="input-group form-control" value = "" name="policyLengthTime" />
        </div>
<div class="col-12">
    <br>
    <div class="input-group-prepend">
        <div class="btn-group">
            <button data-value="ביטולים באחריותנו" class="btn btn-secondary btn-sm dropdown-toggle bitulCategoryButton" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                ביטולים באחריותנו
            </button>
            <div class="dropdown-menu">
                <p  data-value="פיגור/חוב" class="dropdown-item">פיגור/חוב</p>
                <p  data-value="  שימור בחברה המבטלת" class="dropdown-item">  שימור בחברה המבטלת</p>
                <p  data-value="חזר לסוכן הישן (שימור)" class="dropdown-item">חזר לסוכן הישן (שימור)</p>
                <p  data-value="מכירה לקויה" class="dropdown-item">מכירה לקויה</p>
                <p  data-value="חיוב כפול" class="dropdown-item">חיוב כפול</p>
                <p  data-value="לא ברורה הסיבה" class="dropdown-item">לא ברורה הסיבה</p>
                <p  data-value="הכחשת עסקה" class="dropdown-item">הכחשת עסקה</p>
                <p  data-value="לקוח התחרט" class="dropdown-item">לקוח התחרט</p>
            </div>
        </div>
        <div class="btn-group">
            <button data-value="ביטולים תקינים" class="btn btn-secondary btn-sm dropdown-toggle bitulCategoryButton" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                ביטולים תקינים
            </button>
            <div class="dropdown-menu">
                <p data-value="הועבר לסוכן חדש" class="dropdown-item" >הועבר לסוכן חדש</p>
                <p data-value="הצעה טובה יותר" class="dropdown-item" >הצעה טובה יותר</p>
                <p data-value="הועבר לחברה אחרת" class="dropdown-item" >הועבר לחברה אחרת</p>
                <p data-value="בעיה כלכלית" class="dropdown-item" >בעיה כלכלית</p>
                <p data-value="תוספות חיתומיות" class="dropdown-item" >תוספות חיתומיות</p>
                <p data-value="עובד/ת לשעבר" class="dropdown-item" >עובד/ת לשעבר</p>
                <p data-value="לקוח התחרט" class="dropdown-item" >לקוח התחרט</p>
            </div>
        </div>
        <input type="text" class="input-group form-control" value="" name="" id ="bitulReasonText" readonly placeholder="בחר סיבת ביטול">
    </div>
</div>










<br>
<div class="row justify-content-center">
    <div class="col-2">
        <button type="submit" class="btn btn-primary" id="submit">הגש ביטול</button>
    </div>
</div>



