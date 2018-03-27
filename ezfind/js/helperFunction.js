var html= "";
$(document).ready(function(){
$("#add_input_program").click (function () {
    html='<div><br> <div  class="row justify-content-center form-row">\n' +

        '                    <div class="col">\n' +
        '                        <input type="text"  required class="form-control programNumber"  placeholder=" מספר הקופה" name="programNumber[]" >\n' +
        '                    </div>\n' +
        '                    <div class="col">\n' +
        '                          <select required class="form-control" id="pedionType" name="pedionType[]">\n' +
        '                            <option disabled selected value> סוג הקופה  </option>\n' +
        '                            <option value="קרן_פנסיה">פנסיה</option>\n' +
        '                            <option value="קופת_גמל">גמל</option>\n' +
        '                            <option value="ביטוח_מנהלים">מנהלים</option>\n' +
        '                            <option value="השתלמות">השתלמות</option>\n' +
        '                            <option value="חסכון_טהור">חסכון</option>\n' +
        '                            <option value="קופה_אחרת">אחר</option>\n' +
        '                        </select>\n' +
        '                    </div>\n' +
        '                    <div class="col">\n' +
        '                        <input type="text" required class="form-control insuranceCompany" placeholder="הגוף המנהל " name="insuranceCompany[]">\n' +
        '                    </div>\n' +
        '<i class="material-icons" id="minus_icon2">remove_circle</i>\n' +
        '                </div></div>';
    $("#div_for_three_inputs").append(html);
});


    $("body").on('click', "#minus_icon", function() {

        $(this).parent().parent().remove();

    });

    $("body").on('click', "#minus_icon2", function() {

        $(this).parent().parent().remove();

    });
$("#add_input_mutavim").click (function () {
            html = '<div>' +
                '<div class="col" id="underline"></div>' +
                         '<br>'+
                        '<div id="span">:מוטב  <i class="material-icons" id="minus_icon">remove_circle</i></div> <div  class="row justify-content-center form-row"  > <div class="col"> <input type="text"  required class="form-control programNumber"  placeholder="מספר ת.ז" name="IDNumber[]" > </div> <div class="col"> <input type="text" required class="form-control insuranceCompany" placeholder="שם מלא " name="fullName[]"> </div> </div> <br/> <div  class="row justify-content-center form-row"  > <div class="col"> <input type="text"  required class="form-control programNumber"  placeholder="חלוקה באחוזים" name="percentBenefit[]" > </div> <div class="col"> <select required class="form-control"  placeholder="קרבה" name="relation[]"> <option disabled selected value> קרבה</option> <option value="בעל/אישה">בעל/אישה</option> <option value="ילד/ילדה">ילד/ילדה</option> <option value="אבא/אמא">אבא/אמא</option> <option value="אחר">אחר</option> </select> </div> </div>'+
                    '</div>' +
                '<div class="col" id="underline"></div>' +
                '</div>'
    $("#div_for_three_inputs").append(html);
});
});