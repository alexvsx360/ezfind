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
if ($_SESSION["leadIdToCancel"] !== null) {
    $leadIdToCancel = $_SESSION["leadIdToCancel"];
}

?>
<div class="row justify-content-center">
    <div class="col-12">
        <label for="sel1">מספר רשומה של הליד לביטול</label>
        <?php
        if ($_SESSION["leadIdToCancel"] !== "") {
            ?>
            <input required type="text" class="input-group form-control" value="<?php print $leadIdToCancel; ?>"
                   name="leadIdToCancel" readonly/>
            <?php ;
        } else {
            echo '<input required type="text" class="input-group form-control" placeholder="מספר רשומה של הליד לביטול" name="leadIdToCancel"/>';
        }; ?>
    </div>
</div>
<label for="sel1">? האם בוצעה גביה ראשונה</label>
<div class="input-group mb-3">
    <select required class="custom-select" id="firstPayment" name="firstPayment">
        <option value="">-- ? האם בוצעה גביה ראשונה --</option>
        <option value="כן">כן</option>
        <option value="לא">לא</option>
    </select>
    <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01">? האם בוצעה גביה ראשונה </label>
    </div>
</div>
<div class="row justify-content-center">
<div class="col-12">
    <label for="sel1"> משך חיי הפוליסה בחודשים</label>
    <input required type="number" id="policyLengthTime" class="input-group form-control" value=""
           name="policyLengthTime"/>
    <p id="num_alert" class="alert-danger" style="visibility: hidden">המספר חיב להיות גדול מ-0</p>
</div>
<div class="col-12">
    <label for="sel1">סיבת הביטול</label>
    <div class="input-group mb-3">
        <select required class="custom-select" id="bitulReason" name="bitulReason">
            <option value="">-- בחר את סיבת הביטול --</option>
            <option value="בעיה_כלכלית">בעיה כלכלית</option>

            <option value="אין_מענה">אין מענה</option>

            <option value="פיגור/חוב">פיגור/חוב</option>

            <option value="חיוב_כפול">חיוב כפול</option>

            <option value="שומר בחברה/_סוכנות_קודמת">שומר בחברה/ סוכנות קודמת</option>

            <option value="מכירה_לא_תקינה">מכירה לא תקינה</option>

            <option value="לא_משתף_פעולה">לא משתף פעולה</option>

            <option value="קיבל הצעה טובה יותר">קיבל הצעה טובה יותר</option>

        </select>
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">סיבת הביטול</label>
        </div>
    </div>
</div>

</div>
<br>
<div class="row justify-content-center">
    <div class="col-2">
        <button type="submit" class="btn btn-primary" id="submit">הגש ביטול</button>
    </div>
</div>



