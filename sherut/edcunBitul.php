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
<div class="row justify-content-center">
    <div class="col-2">
        <button type="submit" class="btn btn-primary" id="submit">הגש ביטול</button>
    </div>
</div>
