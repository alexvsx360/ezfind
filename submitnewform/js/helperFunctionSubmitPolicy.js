var empty = "";
var policyArray = [];
var numberId ="";
var itemCount=0;
var checkIfChangeOrPushToPolicyArray = true;
var indexOfValuesArray;
var filesFromPolicy;
var arrayIdOfMainDivCancelLetters = [];
var arrayIdOfallInputsCancelLattersFiles =[];
var arrayIdOfallInputscancelInsuranceCompany = [];
var arrayidOfInputsUpdateCancelInsuranceCompany =["updateCancelInsuranceCompany0"];
var arrayidOfInputsUpdateCancelLattersFiles=["updateCancelfiles0"];
var arrayidOfMainDivUpdateCancellationletters=["updateCancellationletters0"];
var cancelLettersFiles;
var cancellationNumber;
var castumerDetailsArray ={};
var textError = "";
deletePolicy = false;
itemCountUpdateCancellationletters = 0;

function validateBeforeSubmit(num,tempDate){
    // Check if the premia is greater than 0.
 //   var num = $("#sum_premia").val();
    if (num < 1) {
        textError = "הפרמיה חיבת להיות גדולה מ-0"
        return textError;
    }
    //check that the insurance start date starts from now

    var dateNow = Date.now();
    dateNow = new Date(dateNow);
    dateNow.setHours(0, 0, 0, 0);
   //var formatStartDate = new Date(newformattedDate);
    tempDate.setHours(0, 0, 0, 0);

    if (tempDate >= dateNow) {
            return true;
        } else {
        textError = "תאריך תחילת הביטוח יהיה מהיום והלאה"
            return textError;
        }
    //valdite of file size

    // var file = $('input[type="file"]').get(0).files;
    // $(file).each(function (index, value) {
    //     if (Math.round((value.size / 1024)) > 7000) {
    //         textError =("גודל הקובץ: " + value.name + " " + " גדול מידי, ולכן לא ניתן להעלותו, עליך להקטינו לפני ההעלאה");
    //         return textError;
    //     } else {
    //         textError = "";
    //     }
    //     return textError;
    // });

}
function checkEmptyFields(){
    var fleg="";
    empty = $("#back_form").find('[required]').filter(function () {
        return this.value === "";
    });
    if (empty.length == 0) {
        var fleg = true;
    } else {
        var fleg = false;
    }
    return fleg;
}

function showEmptyFields(empty) {
    $(empty).css("border", "solid red 1px").on("change", function() {
        $(this).css("border", "solid #b9bbbe 0.5px")
    });
}
function ssnValidate (ssn) {
    var flag = "";
    var arrayDoubledNumbers = [];
    var arrayNumbersToSum = [];
    var ssnToArray = ssn.split('');
    // להכפיל לסרוגין באחד ובשתיים
    for (i = 0; i < ssnToArray.length; i++) {
        if (i % 2 == 0) {
            arrayDoubledNumbers.push((ssnToArray[i] * 1));
        } else {
            arrayDoubledNumbers.push((ssnToArray[i] * 2));
        }
    }
    //כדי לחבר יחד את כל הספרות :1. מודולו עשר כדי לקבל את ספרת האחדות  2. חילוק בעשר כדי לקבל את ספרת העשרות
    for (i = 0; i < arrayDoubledNumbers.length; i++) {
        var singleNumber = arrayDoubledNumbers[i]%10;
        arrayNumbersToSum.push(singleNumber);
        var tensNumber = parseInt((arrayDoubledNumbers[i])/10);
        arrayNumbersToSum.push(tensNumber);
    }
    //חיבור כל הספרות במערך
    function getSum(total, num) {
        return total + num;
    }
    var sum =  arrayNumbersToSum.reduce(getSum);
    // בדיקה אם המספר שהתקבל מתחלק בעשר ללא שארית המספר תקין
    if(sum%10 == 0){
        flag = true;
    }else {
        flag = false;
    }
    return flag;
}
$(document).ready(function() {
    function addHtmlTOCancelLetters(){
        if ($("#yesCancelLetters").val() == "כן") {
            //itemCount++;
            var idOfMainDivCancelLetters = "addcancellationletters" + itemCount;
            var idOfInputsCancelLattersFiles = "cancelfiles" + itemCount;
            var idOfInputsCancelInsuranceCompany = "cancelInsuranceCompany" + itemCount;
            arrayIdOfallInputsCancelLattersFiles.push(idOfInputsCancelLattersFiles);
            arrayIdOfMainDivCancelLetters.push(idOfMainDivCancelLetters);
            arrayIdOfallInputscancelInsuranceCompany.push(idOfInputsCancelInsuranceCompany);
            var htmlAddcancellationletters =

                '<div class="row addcancellationletters" id="addcancellationletters' + itemCount + '" >\n' +
                '<br>\n' +
                '<br>\n' +
                '   <div class="col-sm" >\n' +
                '     <label for="sel1">חברת הביטוח אליה ישלח הביטול</label>\n' +
                '                <select required class="form-control" id="cancelInsuranceCompany' + itemCount + '" name="cancelInsuranceCompany">\n' +
                '                    <option disabled selected value> -- לאיזו חברת ביטוח ישלח הביטול -- </option>\n' +
                '                    <option value="הראל">הראל</option>\n' +
                '                    <option value="הפניקס">הפניקס</option>\n' +
                '                    <option value="מגדל">מגדל</option>\n' +
                '                    <option value="מנורה">מנורה</option>\n' +
                '                    <option value="כלל">כלל</option>\n' +
                '                    <option value="הכשרה">הכשרה</option>\n' +
                '                    <option value="שירביט">שירביט</option>\n' +
                '                    <option value="שומרה">שומרה</option>\n' +
                '                    <option value="דיקלה">דיקלה</option>\n' +
                '                    <option value="איילון">איילון</option>\n' +
                '                    <option value="AIG">AIG</option>\n' +
                '                    <option value="IDI">IDI</option>\n' +
                '                    <option value="פסגות">פסגות</option>\n' +
                '                    <option value="שלמה ביטוח">שלמה ביטוח</option>\n' +
                '                    <option value="אחר">אחר</option>\n' +
                '                </select>\n' +
                '   </div>\n' +
                '   <div class="col-sm">\n' +
                '     <label for="cancelfiles" style="cursor: pointer;">\n' +
                '        <i class="material-icons" style="float: right;color:#e4606d">add_circle</i>צרף מכתב ביטול&nbsp\n' +
                '    </label>\n' +
                '    <input aria-describedby="fileHelp" required type="file" class="form-control-file cancelfiles" name="cancelfiles[]" id="cancelfiles' + itemCount + '"  multiple value=""/>\n' +
                '  </div>\n' +
                ' <div class="w-100 d-none d-md-block"></div>' +
                '  <div class="col-md-6 offset-md-3">\n' +
                '     <p class="addMorecancellationletters" ><u>להוספת מכתב ביטול נוסף </u></p>' +
                '     <p class="removecancellationletters" ><u>להסרת מכתב הביטול</u></p>' +
                '  </div>' +
                '</div>' +
                '</div>\n';
            $(htmlAddcancellationletters).insertAfter($("#lastElement"));
            $("#cancelInsuranceCompany").prop('required', true);
            console.log(arrayIdOfMainDivCancelLetters);
        }
    }
    //When the page is loaded, the form is cleared from each comment
    $(".castumerDetails").hide();
    $("#showPolicyDetails").hide();
    //When you click on the button 'customer details' or on the div of customer details
    $("body").on('click', ".showCastumerDetails", function () {
        $(".summeryDetailsPolicy").css("pointer-events", "none");
        $(".summeryDetailsPolicy").css('opacity', '0.4');
        $('#addPolicy').attr('disabled', true);
        $('#submitPolicy').attr('disabled', true);
        $(".alertCastumerDetails").hide();
        //The customer details form is displayed
        $(".castumerDetails").show();
        $("#showPolicyDetails").css('display', 'none');
    });
    //  When the form is changed, the alerts are deleted
    $("body").on('change', "input", function () {
        $(".alert-danger").hide();
    });
    $("body").on('change', "select", function () {
        $(".alert-danger").hide();
    });
    $("body").on('change', ".cancellationNumber", function () {
        if ($(this).val() == "לא") {
            $(".addcancellationletters").remove();
            arrayIdOfallInputsCancelLattersFiles = [];
            arrayIdOfMainDivCancelLetters = [];
            arrayIdOfallInputscancelInsuranceCompany = [];
            itemCount = 0;
            console.log(arrayIdOfMainDivCancelLetters);
            console.log(itemCount);
        }
        if ($(this).val() == "כן") {
            addHtmlTOCancelLetters()
        }
    });
    $("body").on('click', ".addMorecancellationletters", function () {
        if ($('select[name="cancelInsuranceCompany"]').val() != "" && $('input[name="cancelfiles[]"]').val() != "") {
            itemCount++;
            var idOfMainDivCancelLetters = "addcancellationletters" + itemCount;
            var idOfInputsCancelLattersFiles = "cancelfiles" + itemCount;
            var idOfInputsCancelInsuranceCompany = "cancelInsuranceCompany" + itemCount;
            arrayIdOfallInputsCancelLattersFiles.push(idOfInputsCancelLattersFiles);
            arrayIdOfMainDivCancelLetters.push(idOfMainDivCancelLetters);
            arrayIdOfallInputscancelInsuranceCompany.push(idOfInputsCancelInsuranceCompany);
            var htmlAddcancellationletters =

                '<div class="row addcancellationletters" id="addcancellationletters' + itemCount + '" >\n' +
                '<br>\n' +
                '<br>\n' +
                '   <div class="col-sm" >\n' +
                '     <label for="sel1">חברת הביטוח אליה ישלח הביטול</label>\n' +
                '                <select required class="form-control" id="cancelInsuranceCompany' + itemCount + '" name="cancelInsuranceCompany">\n' +
                '                    <option disabled selected value> -- לאיזו חברת ביטוח ישלח הביטול -- </option>\n' +
                '                    <option value="הראל">הראל</option>\n' +
                '                    <option value="הפניקס">הפניקס</option>\n' +
                '                    <option value="מגדל">מגדל</option>\n' +
                '                    <option value="מנורה">מנורה</option>\n' +
                '                    <option value="כלל">כלל</option>\n' +
                '                    <option value="הכשרה">הכשרה</option>\n' +
                '                    <option value="שירביט">שירביט</option>\n' +
                '                    <option value="שומרה">שומרה</option>\n' +
                '                    <option value="דיקלה">דיקלה</option>\n' +
                '                    <option value="איילון">איילון</option>\n' +
                '                    <option value="AIG">AIG</option>\n' +
                '                    <option value="IDI">IDI</option>\n' +
                '                    <option value="פסגות">פסגות</option>\n' +
                '                    <option value="שלמה ביטוח">שלמה ביטוח</option>\n' +
                '                    <option value="אחר">אחר</option>\n' +
                '                </select>\n' +
                '   </div>\n' +
                '   <div class="col-sm">\n' +
                '     <label for="cancelfiles" style="cursor: pointer;">\n' +
                '        <i class="material-icons" style="float: right;color:#e4606d">add_circle</i>צרף מכתב ביטול&nbsp\n' +
                '    </label>\n' +
                '    <input aria-describedby="fileHelp" required type="file" class="form-control-file cancelfiles" name="cancelfiles[]" id="cancelfiles' + itemCount + '"  multiple value=""/>\n' +
                '  </div>\n' +
                ' <div class="w-100 d-none d-md-block"></div>' +
                '  <div class="col-md-6 offset-md-3">\n' +
                '     <p class="addMorecancellationletters" ><u>להוספת מכתב ביטול נוסף </u></p>' +
                '     <p class="removecancellationletters" ><u>להסרת מכתב הביטול</u></p>' +
                '  </div>' +
                '</div>' +
                '</div>\n';
            $(htmlAddcancellationletters).insertAfter($("#lastElement"));
            console.log(arrayIdOfMainDivCancelLetters);
        } else {
            var emptyFields = checkEmptyFields();
            if (!emptyFields) {
                showEmptyFields(empty);
            }
        }
    });
    $("body").on('click', ".removecancellationletters", function () {

        $(this).parent().parent().remove();

        var idOfMainDivCancelLettersToRemove = $(this).parent().parent().attr('id');
        var stringId = 'addcancellationletters';
        var numberId = idOfMainDivCancelLettersToRemove.replace(stringId, '');
        arrayIdOfMainDivCancelLetters.splice(numberId, 1, " ");
        for (i = 0; i < arrayIdOfMainDivCancelLetters.length; i++) {
            if (arrayIdOfMainDivCancelLetters[i] !== " ") {
                $("#yesCancelLetters").prop("checked", true);
                break;
            } else {
                $("#noCancelLetters").prop("checked", true);


            }
        }
        if ($("#noCancelLetters").is(':checked')) {
            arrayIdOfallInputsCancelLattersFiles = [];
            arrayIdOfMainDivCancelLetters = [];
            arrayIdOfallInputscancelInsuranceCompany = [];
            itemCount = 0;
            console.log(itemCount);
        }
        //   $("#noCancelLetters").prop("checked", true);
        console.log(arrayIdOfMainDivCancelLetters);

    });
    // $("body").on('change', "#cancelfiles", function() {
    //     var cancelfiles = $(this)[0].files;
    //     var countFiles = cancelfiles.length;
    //     $(this).labels().html('<i class="fa fa-check-circle addIcon" style="font-size:24px;color: forestgreen;margin-left: 5px;"></i>'+' '+' '+'נבחרו '+countFiles +' '+'קבצים');
    // });
    //View Customer Summary
    function summaryCustomerDetails() {
        //hide the button 'display policy details'
        $("#showPolicyDetails").css('display', 'none');
        //hide the form of castumer details
        $(".castumerDetails").hide();
        //remove the button 'castumer details'
        $("#showCastumerDetails").remove();
        //display div with details castumer
        var castumerName = $("#customerName").val();
        var customerId = $("#customerId").val();
        $(".alertCastumerDetails").html("<div class='alert alert-info' role='alert'><i class=\"fa fa-drivers-license-o\" style=\"font-size:24px\"></i>שם :" + castumerName + "<br><span id='editCastumerDetails' ><u>לעריכת פרטי הלקוח</u></span>" + "ת.ז:" + " " + customerId + "</div>");
        $(".alertCastumerDetails").show();
        //add to this div class 'showCastumerDetails' in order to display the castumer details when its clicked
        $(".alertCastumerDetails").addClass("showCastumerDetails")
    }

//When clicking on "Details of the Policy"...
    $("body").on('click', "#showPolicyDetails", function () {

        $("#alertCastumerDetails").css('pointer-events', "none");
        $("#alertCastumerDetails").css('opacity', '0.4');
        $(htmlInputsPolicy).insertAfter("#showPolicyDetails");
        if (deletePolicy == false) {
            $(htmlButtonPolicy).insertAfter(".detailsPolicy");
        }

        addHtmlTOCancelLetters();
        $('#addPolicy').css('display', 'none');
        $('#submitPolicy').css('display', 'none');

        summaryCustomerDetails();
    });

    $("body").on('click', "#finishEditCastumerDetails", function () {
        //Checks if all customer details are complete
        var emptyFields = checkEmptyFields();
        if (!emptyFields) {
            var html = '<div class="alert alert-danger" role="alert" style="">עליך למלאות  את כל פרטיו האישיים של הלקוח  </div>';
            $(".alertCastumerDetails").html(html)
            $(".alertCastumerDetails").show();
            showEmptyFields(empty);
            console.log(empty);
        } else {
            var ssn = $("#customerId").val();
            var ssnAfterValidate = ssnValidate(ssn);
            if (ssnAfterValidate !== true) {
                var html = '<div class="alert alert-danger" role="alert" style="">מספר תעודת הזהות לא תקין</div>';
                $(".alertCastumerDetails").html(html)
                $(".alertCastumerDetails").show();
            } else {

                $(".summeryDetailsPolicy").css("pointer-events", "auto");
                $(".summeryDetailsPolicy").css('opacity', '1');
                summaryCustomerDetails();
                $('#addPolicy').attr('disabled', false);
                $('#submitPolicy').attr('disabled', false);
                $("#castumerDetails :input").each(function () {
                    key = $(this).attr('name');
                    value = $(this).val();
                    castumerDetailsArray[key] = value;
                })
                console.log("castumerDetailsArray", castumerDetailsArray);
                //Displays the 'policy details' button
                if (policyArray.length <= 0) {
                    $("#showPolicyDetails").show();
                    $('#addPolicy').attr('disabled', true);
                    $('#submitPolicy').attr('disabled', true);
                }
            }
        }
    })

    $("body").on('click', "#finishEditPolicyDetails", function () {
        var arrayCancelInsuranceCompanyAndCancelLetters = {};
        if ($('input.yesCancelLetters').is(':checked')) {
            var fileInputCancelLetters;
            var cancelLettersValue;
            for (i = 0; i < arrayIdOfMainDivCancelLetters.length; i++) {
                if (arrayIdOfMainDivCancelLetters[i] != " ") {
                    var fileListOfCancelLetters = [];
                    var fileCancelLettersId = arrayIdOfallInputsCancelLattersFiles[i];
                    var cancelInsuranceCompanyId = arrayIdOfallInputscancelInsuranceCompany[i];
                    var cancelInsuranceCompanyKey = $("#" + cancelInsuranceCompanyId).val();
                    fileInputCancelLetters = document.getElementById(fileCancelLettersId);
                    for (var y = 0; y < fileInputCancelLetters.files.length; y++) {
                        fileListOfCancelLetters.push(fileInputCancelLetters.files[y]);
                        console.log(fileListOfCancelLetters);
                    }
                }
                cancelLettersValue = fileListOfCancelLetters;
                arrayCancelInsuranceCompanyAndCancelLetters[cancelInsuranceCompanyKey] = cancelLettersValue;
            }
        }

        console.log("arrayCancelInsuranceCompanyAndCancelLetters", arrayCancelInsuranceCompanyAndCancelLetters);
        var valuesArray = {};
        var i = 0;
        var fileInput = document.getElementById('InputFile');
        var fileList = [];
        var emptyFields = checkEmptyFields();

        if (!emptyFields) {
            $(".alert-danger").remove();
            var html = '<div class="alert alert-danger" role="alert" style="text-align: center;margin-top: 25px">עליך למלאות את פרטי הפוליסה </div>';
            $(html).insertBefore(".detailsPolicy:first");
            ;
            showEmptyFields(empty);
            console.log(empty);
        } else {
            var num = $("#sum_premia").val();
            var tempDate = $('#insurance_start_date').val();
            var dateEntered = new Date(tempDate);
            //var file = $('input[type="file"]').get(0).files;

            var validate = validateBeforeSubmit(num, dateEntered);
            if (validate !== "" && validate !== true) {
                var html = '<div class="alert alert-danger" role="alert" style="text-align: center;margin-top: 25px">' + validate + ' </div>';
                $(html).insertBefore(".detailsPolicy:first");
            } else {
                $('#addPolicy').css('display', 'inline-block');
                $('#submitPolicy').css('display', 'inline-block');
                $('#addPolicy').attr('disabled', false);
                $('#submitPolicy').attr('disabled', false);
                if (policyArray.length <= 0) {
                    $("#detailsPolicy :input").each(function () {
                        key = $(this).attr('name');
                        value = $(this).val();
                        valuesArray[key] = value;
                        if (key == "file[]") {
                            for (var j = 0; j < fileInput.files.length; j++) {
                                fileList.push(fileInput.files[j])
                            }
                            ;
                            valuesArray["file[]"] = fileList;

                        }
                        if (($('input.yesCancelLetters').is(':checked'))) {
                            valuesArray["cancelfiles[]"] = arrayCancelInsuranceCompanyAndCancelLetters;
                            valuesArray["cancellationNumber"] = "כן";
                        } else if (($('input.noCancelLetters').is(':checked'))) {
                            valuesArray["cancellationNumber"] = "לא";
                            valuesArray["cancelfiles[]"] = "לא";
                        }
                    })
                } else {
                    var elementId = $(this).parent().attr('id');
                    $("#" + elementId + " :input").each(function () {
                        key = $(this).attr('name');
                        value = $(this).val();
                        valuesArray[key] = value;
                        if (key == "file[]") {
                            for (var j = 0; j < fileInput.files.length; j++) {
                                fileList.push(fileInput.files[j])
                            }
                            ;
                            valuesArray[key] = fileList

                        }
                        if (($('input.yesCancelLetters').is(':checked'))) {
                            valuesArray["cancelfiles[]"] = arrayCancelInsuranceCompanyAndCancelLetters;
                            valuesArray["cancellationNumber"] = "כן";
                        } else if (($('input.noCancelLetters').is(':checked'))) {
                            valuesArray["cancellationNumber"] = "לא";
                            valuesArray["cancelfiles[]"] = "לא";
                        }
                    })
                    console.log('valuesArray', valuesArray);
                }
                console.log(valuesArray);
                if ((policyArray.length <= 0) || (checkIfChangeOrPushToPolicyArray == true)) {
                    policyArray.push(valuesArray);
                    console.log("policyArray1", policyArray);
                    indexOfValuesArray = policyArray.indexOf(valuesArray);
                } else {
                    valuesArray['cancelfiles[]'] = cancelLettersFiles;
                    valuesArray['cancellationNumber'] = cancellationNumber;
                    //change or add files to policy
                    if ($('input.addFile').is(':checked')) {
                        console.log("valuesArray['file[]']", valuesArray['file[]']);
                        console.log('filesFromPolicy', filesFromPolicy);
                        var allFiles = $.merge(valuesArray['file[]'], filesFromPolicy);
                        console.log('allFiles', allFiles);
                        valuesArray['file[]'] = allFiles;
                    }
                    if (!$('input.addFile').is(':checked') && (!$('input.changeFile').is(':checked'))) {
                        valuesArray['file[]'] = filesFromPolicy;
                    }
                    policyArray.splice(numberId, 1, valuesArray);
                    console.log("policyArray2", policyArray)
                    indexOfValuesArray = policyArray.indexOf(valuesArray);
                }
                var insuranceCompany = $("#insuranceCompany").val();
                var policy = $("#policy").val();
                var allhtmlDetailsPolicy = "<div class='alert alert-info summeryDetailsPolicy' role='alert' id='detailsPolicy" + indexOfValuesArray + "'><i class='fa fa-file-text-o' style='font-size: 24px'></i>פוליסת :" + policy + "<br><span id='editPolicyDetails'><u>לעריכת פרטי הפוליסה</u></span>ב: " + insuranceCompany + "</div>";
                $(allhtmlDetailsPolicy).insertAfter(".alertCastumerDetails");
                $('.detailsPolicy').css('display', 'none');
                $("#alertCastumerDetails").css('pointer-events', 'auto');
                $("#alertCastumerDetails").css('opacity', '1');
                $(".summeryDetailsPolicy").css("pointer-events", "auto");
                $(".summeryDetailsPolicy").css('opacity', '1');
                arrayIdOfMainDivCancelLetters = [];
                arrayIdOfallInputscancelInsuranceCompany = [];
                arrayIdOfallInputsCancelLattersFiles = [];

            }
        }
    });
    $("body").on('click', "#addPolicy", function () {
        $('#addPolicy').attr('disabled', true);
        $('#submitPolicy').attr('disabled', true);
        var emptyFields = checkEmptyFields();
        if (!emptyFields) {
            $(".alert-danger").remove();
            var html = '<div class="alert alert-danger" role="alert" style="text-align: center;margin-top: 25px">עליך למלאות את פרטי הפוליסה </div>';
            $(html).insertBefore(".detailsPolicy:first");
            showEmptyFields(empty);
            console.log(empty);
        } else {
            $("#alertCastumerDetails").css('pointer-events', "none");
            $("#alertCastumerDetails").css('opacity', '0.4');
            $(".summeryDetailsPolicy").css("pointer-events", "none");
            $(".summeryDetailsPolicy").css('opacity', '0.4');

            checkIfChangeOrPushToPolicyArray = true;
            numberId = policyArray.length;
            var count = policyArray.length;
            var elementId = 'detailsPolicy' + count;
            $(htmlInputsPolicy).insertAfter("#showPolicyDetails").attr('id', elementId);
            $('<button type="button" class="btn btn-danger delete" >מחיקת פוליסה</button>\n').insertAfter("#finishEditPolicyDetails");
        }
    })
    $("body").on('click', "input:checkbox", function () {
        $('input:checkbox').not(this).prop('checked', false);
    });

    $("body").on('click', ".delete", function () {
        arrayIdOfMainDivCancelLetters = [];
        arrayIdOfallInputscancelInsuranceCompany = [];
        arrayIdOfallInputsCancelLattersFiles = [];
        deletePolicy = true;
        $(".alert-danger").hide();
        policyArray.splice(numberId, 1, " ");
        var elementId = "detailsPolicy" + numberId;
        $("#" + elementId).remove();
        $('#addPolicy').attr('disabled', false);
        $('#submitPolicy').attr('disabled', false);
        $("#alertCastumerDetails").css('pointer-events', 'auto');
        $("#alertCastumerDetails").css('opacity', '1');
        $(".summeryDetailsPolicy").css("pointer-events", "auto");
        $(".summeryDetailsPolicy").css('opacity', '1');


    });
    $("body").on('click', ".summeryDetailsPolicy", function () {

        checkIfChangeOrPushToPolicyArray = false;
        $('#addPolicy').attr('disabled', true);
        $('#submitPolicy').attr('disabled', true);
        summaryCustomerDetails();
        $("#alertCastumerDetails").css('pointer-events', 'none');
        $("#alertCastumerDetails").css('opacity', '0.4');
        $(this).remove();
        var stringId = $(this)[0].id;
        var string = 'detailsPolicy';
        numberId = stringId.replace(string, '');
        var policyFromArray = policyArray[numberId];
        $('.castumerDetails').css('display', 'none');
        $(htmlInputsPolicy).insertAfter("#showPolicyDetails").attr('id', stringId);
        $('<button type="button" class="btn btn-danger delete" >מחיקת פוליסה</button>\n').insertAfter("#finishEditPolicyDetails");
        for (var key in policyFromArray) {
            if ($('input[name="file[]"]')) {
                filesFromPolicy = policyFromArray["file[]"];
                $('input[name="file[]"]').remove;
                $(".file").remove();
            }
            if ($('input[name="cancelfiles[]"]')) {
                $('input[name="cancelfiles[]"]').remove();
                cancelLettersFiles = policyFromArray["cancelfiles[]"];
                cancellationNumber = policyFromArray["cancellationNumber"];
                console.log('cancelLettersFiles', cancelLettersFiles);
                $('.cancellationNumber').remove();
                $("#lastElement").children().remove();
            }

            $('input[name="' + key + '"]').val(policyFromArray[key]);
            $('select[name="' + key + '"]').val(policyFromArray[key]);
        }

        var htmlRadioButtonFile = '<br><div class="row">\n' +
            '  <div class="col-sm file">\n' +
            '     <label for="sel1">להחלפת הקבצים הקימים</label>\n' +
            '        <input type="checkbox" class="changeFile" name="changeFile" value="changeFiles" >\n' +
            '   </div>\n' +
            '  <div class="col-sm file">\n' +
            '     <label for="sel1">להוספת קבצים חדשים </label>\n' +
            '        <input type="checkbox" class="addFile" name="addFile" value="addFiles" >\n' +
            '   </div>\n';

        $(htmlRadioButtonFile).insertAfter("#lastElement");
        $('input:checkbox').click(function () {
            $('input[name="file[]"]').remove();
        })
        $('input:checkbox').change(
            function () {
                if ($(this).is(':checked')) {
                    $('input[name="file[]"]').remove();
                    var htmlFileInput =
                        '<input aria-describedby="fileHelp"  type="file" class="form-control-file" name="file[]" id="InputFile"  required multiple />';
                    $(htmlFileInput).insertAfter(this);
                }
            });
        $(".summeryDetailsPolicy").css("pointer-events", "none");
        $(".summeryDetailsPolicy").css('opacity', '0.4');
        console.log(policyArray);
        console.log(policyFromArray);

    });
    var d = new Date();

    var month = d.getMonth() + 1;
    var day = d.getDate();
    var dateNow = (day < 10 ? '0' : '') + day + '/' +
        (month < 10 ? '0' : '') + month + '/' +
        d.getFullYear();


    var htmlInputsPolicy = '<div class="detailsPolicy" id="detailsPolicy" >\n' +
        '        <div class="row">\n' +
        '            <div class="col-sm">\n' +
        '                <label for="sel1">כיסוי ביטוחי</label>\n' +
        '                <select required class="form-control" id="policy" name="policy">\n' +
        '                    <option disabled selected value> -- בחר כיסוי ביטוחי -- </option>\n' +
        '                    <option value="תאונות_אישיות">תאונות אישיות</option>\n' +
        '                    <option value="אובדן_כושר_עבודה">אכ"ע</option>\n' +
        '                    <option value="מחלות_קשות">מחלות קשות</option>\n' +
        '                    <option value="חיים">ריסק</option>\n' +
        '                    <option value="בריאות">בריאות</option>\n' +
        '                    <option value="ביטוח_משכנתא">ריסק למשכנתא</option>\n' +
        '                    <option value="סיעודי">סיעודי</option>\n' +
        '                </select>\n' +
        '            </div>\n' +
        '            <div class="col-sm">\n' +
        '                <label for="sel1">חברת ביטוח</label>\n' +
        '                <select required class="form-control" id="insuranceCompany" name="insuranceCompany">\n' +
        '                    <option disabled selected value> -- בחר חברת ביטוח -- </option>\n' +
        '                    <option value="כלל">כלל</option>\n' +
        '                    <option value="הראל">הראל</option>\n' +
        '                    <option value="איילון">איילון</option>\n' +
        '                    <option value="הפניקס">הפניקס</option>\n' +
        '                    <option value="הכשרה">הכשרה</option>\n' +
        '                </select>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '        <div class="row">\n' +
        '            <div class="col-sm">\n' +
        '                <label for="sel1">פרמיה בש"ח</label>\n' +
        '                <input type="number" required class="form-control" rows="4" placeholder="פרמיה בשח" name="premia"  id="sum_premia">\n' +
        '            </div>\n' +
        '            <div class="col-sm">\n' +
        '                <label for="sel1">אחוז הנחה</label>\n' +
        '                <input required type="text" class="input-group form-control"  placeholder="אחוז הנחה" name="discount"/>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '        <div class="row">\n' +
        '            <div class="col-sm">\n' +
        '                <label for="sel1">מסלול חיתום:</label>\n' +
        '                <select required class="form-control" id="hitum" name="hitum">\n' +
        '                    <option disabled selected value> -- בחר מסלול חיתום -- </option>\n' +
        '                    <option value="ירוק">ירוק</option>\n' +
        '                    <option value="אדום">אדום</option>\n' +
        '                </select>\n' +
        '            </div>\n' +
        '            <div class="col-sm">\n' +
        '                <label for="sel1">אמצעי תשלום:</label>\n' +
        '                <select required class="form-control" id="payingWith" name="payingWith">\n' +
        '                    <option disabled selected value> -- בחר אמצעי תשלום -- </option>\n' +
        '                    <option value="אשראי">אשראי</option>\n' +
        '                    <option value="הוראת קבע">הוראת קבע</option>\n' +
        '                </select>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '        <div class="row">\n' +
        '            <div class="col-sm">\n' +
        '                <label for="sel1">תאריך תחילת הביטוח</label>\n' +
        '                <input required type="date" id="insurance_start_date" class="input-group form-control" placeholder="תאריך תחילת ביטוח" name="insuranceStartDate" />\n' +
        '            </div>\n' +
        '            <div class="col-sm">\n' +
        '                <label for="sel1">תאריך המכירה - ברירת מחדל היום</label>\n' +
        '                <input id="saleDate" required type="text"  value="' + dateNow + '" class="input-group form-control"  name="saleDate" readonly/>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '        <div class="row" >\n' +
        '            <div class="col-sm">\n' +
        '              <label for="sel1">הערות להצעה:</label>\n' +
        '              <textarea class="form-control" id="insuranceComment" name="insuranceComment">\n' +
        '              </textarea>\n' +
        '            </div>\n' +
        '            <div class="col-sm file">\n' +
        '                <label for="sel1"> צרף מסמכים רלוונטיים</label>\n' +
        '                <input aria-describedby="fileHelp" required type="file" class="form-control-file" name="file[]" id="InputFile"  multiple value=""/>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '        <div class="row" id="lastElement" ">\n' +
        '            <div class="col-sm ifCancelLetters">\n' +
        '                <label for="sel1">האם יש מכתב ביטול</label>\n' +
        '                <br>' +
        '                <label for="sel1">כן</label>\n' +
        '                <input type="radio" class="cancellationNumber yesCancelLetters" name="cancellationNumber"  value="כן" id="yesCancelLetters" required checked>\n' +
        '                <label for="sel1">לא</label>\n' +
        '                <input type="radio" class="cancellationNumber noCancelLetters" name="cancellationNumber" value="לא" id="noCancelLetters">\n' +
        '            </div>\n' +
        '        </div>\n' +
        '                <br>' +
        '                <br>' +

        '        <button type="button" class="btn btn-info" id="finishEditPolicyDetails" style="background:1c7430;;border: solid 0.5px #c8e5bc" >\n' +
        'סיום עריכת פרטי הפוליסה&nbsp\n            ' +
        '        </button>\n' +
        '    </div>\n';
    var htmlButtonPolicy =
        '<div class="allButton">\n' +
        '        <button type="button" class="btn btn-info addPolicy" id="addPolicy" style="background:#218BC3;border: solid 0.5px #218BC3" >\n' +
        '                <i class="material-icons addIcon addPolicy">add_circle</i>מלא פרטי פוליסה נוספת&nbsp\n' +
        '        </button>\n' +
        '        <br>\n' +
        '        <br>\n' +
        '        <button type="button" class="btn btn-primary submitPolicy" id="submitPolicy">&nbspהגש הצעה&nbsp\n' +
        '              <i class="fa fa-check-circle addIcon" style="font-size:24px"></i>\n' +
        '        </button>\n' +
        '</div>\n';

    $("body").on('click', "#submitPolicy", function (event) {
        $("#alertCastumerDetails").css('pointer-events', "none");
        $("#alertCastumerDetails").css('opacity', '0.4');
        $(".summeryDetailsPolicy").css("pointer-events", "none");
        $(".summeryDetailsPolicy").css('opacity', '0.4');
        $('#addPolicy').attr('disabled', true);
        $('#submitPolicy').attr('disabled', true);

        var origLeadSupplaier = $("#origLeadSupplaier").val();
        var origLeadCampaignName = $("#origLeadCampaignName").val();
        var channelName = $("#leadChannel").val();
        var currentUserEmail = $("#currentUserEmail").val();
        var currentUserName = $("#currentUserName").val();
        var agentId = $("#agentId").val();
        var crmAccountNumber = $("#crmAccountNumber").val();
        var leadId = $("#leadId").val();
        var harBituahFile = $("#harBituahFile").val();
        castumerDetailsArray["origLeadSupplaier"] = origLeadSupplaier;
        castumerDetailsArray["origLeadCampaignName"] = origLeadCampaignName;
        castumerDetailsArray["leadChannel"] = channelName;
        castumerDetailsArray["userEmail"] = currentUserEmail;
        castumerDetailsArray["userName"] = currentUserName;
        castumerDetailsArray["agentId"] = agentId;
        castumerDetailsArray["crmAccountNumber"] = crmAccountNumber;
        castumerDetailsArray["leadId"] = leadId;
        castumerDetailsArray["harBituahFile"] = harBituahFile;
        for (i = 0; i < policyArray.length; i++) {
            if (policyArray[i] == " ") {
                policyArray.splice(i, 1);
            }
        }
        console.log("policyArraypolicyArray", policyArray);
        var runRequests = function (policyIndex) {
            if (policyArray.length == policyIndex) {
                $("#response").css('visibility', 'visible');
                $("#alertCastumerDetails").remove();
                $(".summeryDetailsPolicy").remove();
                $('#addPolicy').remove();
                $('#submitPolicy').remove();
                console.log("runRequests Success");
                return;
            }

            var policy = policyArray[policyIndex];
            var files = policyArray[policyIndex]["file[]"];
            var cancelLatters = policyArray[policyIndex]["cancelfiles[]"];

            var data;
            var castumerDetails = castumerDetailsArray;
            var data = new FormData();
            for (i = 0; i < files.length; i++) {
                data.append('file' + i, files[i]);
            }
            data.append("castumerDetails", JSON.stringify(castumerDetailsArray));

            for (var key in cancelLatters) {
                var cancelInsuranceCompany = key;
                var cancelLetters = cancelLatters[key];
                for (i = 0; i < cancelLetters.length; i++) {
                    data.append(i + "-" + cancelInsuranceCompany, cancelLetters[i])
                }
            }
            data.append("policy", JSON.stringify(policy));

            $.ajax({
                processData: false,
                contentType: false,
                type: "POST",
                url: "php/submitPolicyHendler.php",
                data: data,
                success: function (response) {
                    runRequests(++policyIndex);
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }
            });
        }
        runRequests(0);

    });


//
//
////update cancell letters from tiful sherut acount
    $("body").on('click', ".addMoreUpdateCancellationletters", function() {

         itemCountUpdateCancellationletters++;
         var idOfMainDivUpdateCancellationletters = "updateCancellationletters" + itemCountUpdateCancellationletters;
         var idOfInputsUpdateCancelLattersFiles = "updateCancelfiles" + itemCountUpdateCancellationletters;
         var idOfInputsUpdateCancelInsuranceCompany = "updateCancelInsuranceCompany" + itemCountUpdateCancellationletters;
         arrayidOfInputsUpdateCancelLattersFiles.push(idOfInputsUpdateCancelLattersFiles);
         arrayidOfMainDivUpdateCancellationletters.push(idOfMainDivUpdateCancellationletters);
         arrayidOfInputsUpdateCancelInsuranceCompany.push(idOfInputsUpdateCancelInsuranceCompany);
         console.log(arrayidOfMainDivUpdateCancellationletters);
         var htmlAddUpdatecancellationletters =
    '        <div class="row updateCancellationletters" id="updateCancellationletters'+itemCountUpdateCancellationletters+'">\n' +
    '            <br>\n' +
    '            <br>\n' +
    '               <div class="col-sm" >\n' +
    '                     <label for="sel1">חברת הביטוח אליה ישלח הביטול</label>\n' +
    '                                <select required class="form-control updateCancelInsuranceCompany" id="updateCancelInsuranceCompany'+itemCountUpdateCancellationletters+'" name="updateCancelInsuranceCompany">\n' +
    '                                        <option disabled selected value> -- לאיזו חברת ביטוח ישלח הביטול -- </option>\n' +
    '                                        <option value="הראל">הראל</option>\n' +
    '                                        <option value="הפניקס">הפניקס</option>\n' +
    '                                        <option value="מגדל">מגדל</option>\n' +
    '                                        <option value="מנורה">מנורה</option>\n' +
    '                                        <option value="כלל">כלל</option>\n' +
    '                                        <option value="הכשרה">הכשרה</option>\n' +
    '                                        <option value="שירביט">שירביט</option>\n' +
    '                                        <option value="שומרה">שומרה</option>\n' +
    '                                        <option value="דיקלה">דיקלה</option>\n' +
    '                                        <option value="איילון">איילון</option>\n' +
    '                                        <option value="AIG">AIG</option>\n' +
    '                                        <option value="IDI">IDI</option>\n' +
    '                                        <option value="פסגות">פסגות</option>\n' +
    '                                        <option value="שלמה ביטוח">שלמה ביטוח</option>\n' +
    '                                        <option value="אחר">אחר</option>\n' +
    '                                    </select>\n' +
    '                   </div>\n' +
    '               <div class="col-sm">\n' +
    '                     <label for="updateCancelfiles" style="cursor: pointer;">\n' +
    '                           <i class="material-icons" style="float: right;color:#e4606d">add_circle</i>צרף מכתב ביטול\n' +
    '                        </label>\n' +
    '                   <input aria-describedby="fileHelp" required type="file" class="form-control-file updateCancelfiles" name="updateCancelfiles[]" id="updateCancelfiles'+itemCountUpdateCancellationletters+'"  multiple value=""/>\n' +
    '                 </div>\n' +
    '             <div class="w-100 d-none d-md-block"></div>\n' +
    '              <div class="col-md-6 offset-md-3">\n' +
    '                     <p class="addMoreUpdateCancellationletters" style="text-align: center"><u>להוספת מכתב ביטול נוסף </u></p>\n' +
    '                     <p class="removeUpdateCancellationletters"  style="text-align: center"><u>להסרת מכתב הביטול</u></p>\n' +
    '                  </div>\n' +
    '            </div>';
        $(htmlAddUpdatecancellationletters).insertBefore($(".updateCancellationletters:first"));
    })

$("body").on('click', ".removeUpdateCancellationletters", function () {

    $(this).parent().parent().remove();
    var idOfMainDivCancelLettersToRemove = $(this).parent().parent().attr('id');
    var stringId = 'updateCancellationletters';
    var numberId = idOfMainDivCancelLettersToRemove.replace(stringId, '');
    arrayidOfMainDivUpdateCancellationletters.splice(numberId, 1, " ");
})

     $("body").on('click', "#submitUpdateCancelfiles", function() {
         var emptyFields = checkEmptyFields();

         if (!emptyFields) {
             $(".alert-danger").remove();
             var html = '<div class="alert alert-danger" role="alert" style="text-align: center;margin-top: 25px">עליך למלאות את כל הפרטים </div>';
             $(html).insertBefore(".detailsPolicy:first");
             ;
             showEmptyFields(empty);
             console.log(empty);
         } else {
         $(this).attr('disabled', true);
         $(".updateCancellationletters").css("pointer-events", "none");
         $(".updateCancellationletters").css('opacity', '0.4');
         arrayUpdateCancelInsuranceCompanyAndCancelLetters={};
            var fileInputUpdateCancelLetters;
            var cancelLettersUpdateValue;
            for (i = 0; i < arrayidOfMainDivUpdateCancellationletters.length; i++) {
                if (arrayidOfMainDivUpdateCancellationletters[i] != " ") {
                    var updateFileListOfCancelLetters = [];
                    var fileListOfUpdateCancelLetters = [];
                    var updateFileCancelLettersId = arrayidOfInputsUpdateCancelLattersFiles[i];
                    var updateCancelInsuranceCompanyId = arrayidOfInputsUpdateCancelInsuranceCompany[i];
                    var updateCancelInsuranceCompanyKey = $("#" + updateCancelInsuranceCompanyId).val();
                    fileInputUpdateCancelLetters = document.getElementById(updateFileCancelLettersId);
                    for (var y = 0; y < fileInputUpdateCancelLetters.files.length; y++) {
                        updateFileListOfCancelLetters.push(fileInputUpdateCancelLetters.files[y]);
                        console.log(updateFileListOfCancelLetters);
                    }
                }
                cancelLettersUpdateValue = updateFileListOfCancelLetters;
                arrayUpdateCancelInsuranceCompanyAndCancelLetters[updateCancelInsuranceCompanyKey] = cancelLettersUpdateValue;
            }

             var data = new FormData();
             for (var key in arrayUpdateCancelInsuranceCompanyAndCancelLetters) {
                 var updateCancelInsuranceCompany = key;
                 var updateCancelLetters = arrayUpdateCancelInsuranceCompanyAndCancelLetters[key];
                 for (i = 0; i < updateCancelLetters.length; i++) {
                     data.append(i + "-" +updateCancelInsuranceCompany, updateCancelLetters[i])

                 }
             }
             var crmAccountNumber = $("#crmAccountNumber").val();
             var leadId = $("#leadId").val();
             data.append("crmAccountNumber",crmAccountNumber);
             data.append("leadId",leadId);
             $.ajax({
                 processData: false,
                 contentType: false,
                 type: "POST",
                 url: "php/updateCancelLettersHendler.php",
                 data: data,
                 success: function (response) {
                     $("#response").css('visibility', 'visible');
                     $(".updateCancellationletters").remove();
                     $("#submitUpdateCancelfiles").remove();

                 },
                 error: function (xhr, status, error) {
                     var err = eval("(" + xhr.responseText + ")");
                     alert(err.Message);
                 }
             });
          }
     });
})




