
function  validateFileSize() {
    var flag = true;
    var file = $('input[type="file"]').get(0).files;
    $(file).each(function (index, value) {
        if (Math.round((value.size / 1024)) > 8000) {
            $('#alertNotFile').css("visibility","visible");
            $('#alertNotFile').text("גודל הקובץ: " + value.name + " " + " גדול מידי, ולכן לא ניתן להעלותו, עליך להקטינו לפני ההעלאה");
            return flag = false;
        } else {
            return flag = true;
        }
    });
    return flag;
}

 $(document).ready(function(){
     function openModal() {
         document.getElementById('modalLoading').style.display = 'block';
         document.getElementById('fade').style.display = 'block';
     }
     function closeModal() {
         document.getElementById('modalLoading').style.display = 'none';
         document.getElementById('fade').style.display = 'none';
     }
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {
        if (input.files) {
            var files = event.target.files;
            var filesArr = Array.prototype.slice.call(files);
            filesArr.forEach(function(f) {
                var reader = new FileReader();
                reader.onload = function (event) {
                    $('.gallery').prepend(' <div class="col-md-4 d-inline-block divToImg"  data-file = "'+f.name+'">\n' +
                        '            <i class="fa fa-trash-o removeImage" id = "'+f.name+'"></i>\n' +
                        '           <img class ="imgInputFile" src = ' + event.target.result + ' >\n' +
                        '        </div>'
                    );
               }
               reader.readAsDataURL(f);
            })
        }
    };
         var fileList = [];//array for all files

         var fileInput = document.getElementById('gallery-photo');
         $("body").on('change', ".inputFile", function () {
             // validateFileSize();
             for (var i = 0; i < fileInput.files.length; i++) {
                 fileList.push(fileInput.files[i])
             };
             imagesPreview(this, 'div.gallery');
         });
     $("body").on('click', ".inputFile", function () {
         $('#alertNotFile').css("visibility","hidden");
     })
         $("body").on('click', ".removeImage", function () {
             for (var i = 0; i < fileList.length; i++) {
                 if (fileList[i].name == $(this).attr('id')) {
                     fileList.splice(i, 1);
                     break;
                 }
             }
             if(fileList.length <= 0) {
                 var $el = $('.inputFile');
                 $el.wrap('<form>').closest('form').get(0).reset();
                 $el.unwrap();
             }
             $(this).parent().remove();
         });

         $('form').submit(function (event) {
             event.preventDefault();
             // if(validateFileSize()){

             var data, xhr;
             var leadName = $('#leadName').val();
             var userName = $('#userName').val();
             var userEmail = $('#userEmail').val();
             var ticetId = $('#ticetId').val();
             var campaignId = $('#campaignId').val();
             var recordNumber = $('#recordNumber').val();
             var updateIn = $('#updateIn').val();
             var textFromCustomer = $("#texFromCustomer").val();
             var crmAccountNumber = $("#crmAccountNumber").val();

             if(fileList.length <= 0) {
                 $('#alertNotFile').css("visibility","visible");
                 $('#alertNotFile').text("!לא נבחרו קבצים");
                 var $el = $('.inputFile');
                 $el.wrap('<form>').closest('form').get(0).reset();
                 $el.unwrap();
                 return false;
             }else{
                 openModal();
                $("#submit").attr('disabled', 'disabled').val('פותח פניה ..');
                data = new FormData();
                for (i=0; i< fileList.length; i++){
                    data.append('file'+i, fileList[i]);}
                data.append("leadName",leadName);
                data.append("userEmail",userEmail);
                data.append("userName",userName);
                data.append("ticketId",ticetId);
                data.append("recordNumber",recordNumber);
                data.append("updateIn",updateIn);
                data.append("campaignId",campaignId);
                data.append("textFromCustomer",textFromCustomer);
                data.append("crmAccountNumber",crmAccountNumber);
                xhr = new XMLHttpRequest();
                xhr.open( 'POST','updateFilesHendler.php', true );
                xhr.onreadystatechange = function ( response ) {
                    closeModal();
                    document.getElementById("formPostFile").reset();
                    fileList = [];
                    $(".gallery").empty();
                    $("#submit").prop('disabled', false);
                    if (this.readyState == 4 && this.status == 200){
                     document.getElementById("modal-body").innerHTML =
                         this.responseText;
                     console.log(this.responseText);
                     if (this.responseText== "הקבצים נקלטו בהצלחה"){
                         location.replace("successUpload.php");
                     }else{
                     $('#modal').modal('show');}
                 }
             };
             xhr.send(data);
            }
           // }
         });
     });




