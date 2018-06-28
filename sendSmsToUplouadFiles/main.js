
$(document).ready(function() {
    $('#form').ajaxForm({
        success: function (response) {
            if (response == "sms sent successfully") {
                $("#texToCustomer").val("");
                $("#infoDivSuccess").fadeTo(1000, 1.0);

            } else if (response == "sms not sent") {
                $("#infoDivFailure").fadeTo(1000, 1.0);
            }
        },
    })
})











