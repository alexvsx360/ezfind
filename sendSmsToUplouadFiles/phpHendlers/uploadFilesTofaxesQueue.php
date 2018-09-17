<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 17/09/2018
 * Time: 11:39
 */
include_once("../generalUtilities/leadImFunctions.php");
$typeOfTicket = $_GET["typeOfTicket"];
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="../css_bootstrap4/css/bootstrap-grid.css" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="../css_bootstrap4/css/bootstrap.css" crossorigin="anonymous">
<link rel="stylesheet" href="../css_bootstrap4/css/bootstrap-reboot.css" crossorigin="anonymous">
<script type="" charset="" src="../css_bootstrap4/js/bootstrap.js"></script>
<script type="" charset="" src="../css_bootstrap4/js/bootstrap.bundle.js"></script>
<script type="" charset="" src="../js/uploadFilesTofaxesQueue.js"></script>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Poiret+One|Quicksand" rel="stylesheet">
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>צרף קבצים</title>
</head>
<body>
<br>
<div class="card-body">
    <h5 class="card-title">בחר את הקבצים הרצויים ושלח</h5>
    <form action="" method="post" id="formPostFile">
        <div class="form-group"></div>
        <input type="hidden" class="form-control" value="<?php print $typeOfTicket; ?>" id="typeOfTicket" name="typeOfTicket">

        <div class="upload-btn-wrapper">
            <button class="btno" multiple accept="image/*" > לחץ כדי לצרף את הקבצים <i class="fa fa-paperclip"></i></button>
            <input required type="file" class="form-control-file inputFile inputfile btno" id="gallery-photo" accept="image/*"  multiple name="file[]">
        </div>
        <br>
        <div class="gallery"></div>
        <br>
        <label for="sel1" class="label">שם פרטי</label>
        <input type="text" class="form-control castumerDetailsToFax"  id="castumerFirstName" name="castumerFirstName" placeholder="שם פרטי" required>
        <br>
        <label for="sel1" class="label">שם משפחה</label>
        <input type="text" class="form-control castumerDetailsToFax"  id="castumerLastName" name="castumerLastName" placeholder="שם משפחה" required>
        <br>
        <label for="sel1" class="label">מספר ת.ז</label>
        <input type="text" class="form-control castumerDetailsToFax"  id="ssn" name="ssn" placeholder="תעודת זהות" required>
        <br>
        <button type="submit" id="submit" class="btn btn-primary SubmitButton submitButtonToFax">שלח את הקבצים</button>
</div>
</form>
</div>
<p class="alert alert-danger" role="alert" id ="alertNotFile">
</p>
<div class="card-footer text-muted">
    שים לב ניתן לצרף מספר קבצים יחד
    <i class="fa fa-asterisk" style="font-size:10px"></i>
</div>
</div>
</body>
<div class="modal fade" tabindex="-1" role="dialog" id="modal" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> הקבצים לא נקלטו נא נסה שוב </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="modal-body"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="fade"></div>
<div id="modalLoading">
    <img id="loader" src="../clock-loading.gif" />
</div>
</div>
</html>