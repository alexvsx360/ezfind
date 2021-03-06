<?php
$configTypes = include('configTypes.php');
session_start();
$leadIdToCancel = "";
if ($_SESSION["leadIdToCancel"] !== null) {
    $leadIdToCancel = $_SESSION["leadIdToCancel"];
}

?>

<div class="row justify-content-center">
    <div class="col-12">
        <label for="sel1">מספר רשומה של הליד ששומר</label>
        <?php
        if ($_SESSION["leadIdToCancel"] !== "") {
            ?>
            <input required type="text" class="input-group form-control" value="<?php print $leadIdToCancel; ?>"
                   name="leadIdToCancel" readonly/>
            <?php ;
        } else {
            echo '<input required type="text" class="input-group form-control" placeholder="כתוב את מספר רשומה של הליד ששומר" name="leadIdToCancel"/>';
        }; ?>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12">
        <label for="sel1">תאריך שימור:</label>
        <input required type="date" class="input-group form-control date" name="saveDate"/>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12">
        <label for="sel1">שם המוכרן המשמר</label>
        <select required class="form-control" id="pedionType" name="sellerNameMeshamer">
            <option value=""> -- בחר את שם המוכרן --
            </option>
            <?php
            foreach ($configTypes['mochranMeshamer'] as $key => $value) {
                echo '<option value="' . $key . '">' . $value . '</option>';
            }
            ?>
        </select>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12">
        <label for="sel1">? האם יש לבטל פוליסה בחברה נגדית</label>
        <select required class="form-control" id="policyCanceledInOppositeCompany"
                name="policyCanceledInOppositeCompany">
            <option value=""> --? האם יש לבטל פוליסה בחברה נגדית --
            </option>
            <option value="כן">כן</option>
            <option value="לא">לא</option>
        </select>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12">
        <label for="sel1">פרמיה בפועל לאחר שימור</label>
        <input id="sumPremia" type="number" class="input-group form-control" placeholder="פרמיה בפועל לאחר שימור"
               name="premiaAferShimur"/>
        <p id="num_alert" class="alert-danger" style="visibility: hidden">הפרמיה חיבת להיות גדולה מ-0</p>
    </div>
</div>
<div class="row justify-content-center">
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
<div class="row justify-content-center">
    <div class="col-12">
        <label for="sel1">הערות לשימור</label>
        <textarea class="form-control" rows="4" id="comments" name="insuranceComment"></textarea>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12">
        <label for="exampleInputFile">צרף מסמכים רלוונטיים</label>
        <input aria-describedby="fileHelp" required type="file" class="form-control-file" name="file[]" id="InputFile"
               multiple/>
    </div>
</div>

<br/>
<div class="row justify-content-center">
    <div class="col-2">
        <button type="submit" class="btn btn-primary" id="submit">הגש שימור</button>
    </div>
</div>
