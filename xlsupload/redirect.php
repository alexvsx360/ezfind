<?php
//print_r($_POST);
//print_r($_FILES);

 $cfile = curl_file_create($_FILES['file']['tmp_name'], $_FILES['file']['type'], $_FILES['file']['name']);
$leadid=$_POST['recordNumber'];
$crmAccount=$_POST['crmAcccountNumber'];
$agentid=$_POST['agentId'];
$files=$_POST['file_category'];
 //print_r('UPLOAD START');

if ($curl = curl_init()) {
    //print_r('CURL START');
    //curl_setopt($curl, CURLOPT_URL, 'http://xlsx_parse.webmind28.com/api.php');
    curl_setopt($curl, CURLOPT_URL, 'http://212.143.233.53/api.php');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
    curl_setopt($curl, CURLOPT_POSTFIELDS, array(
    'crmAcccountNumber'=>$_POST['crmAcccountNumber'],
    'recordNumber'=>$_POST['recordNumber'],
    'agentId'=>$_POST['agentId'],
    'name'=>$_POST['name'],
    'phone'=>$_POST['phone'],
    'file_category'=>$_POST['file_category'],
    'file' => $cfile
    ));
    //print_r('CURL END');
    $out = curl_exec($curl);
   
    curl_error($curl);
   //   echo $out;
   if ($out!="Data saved successfully")
   {
   	print $out;
   }
    ?>
  
    
    <div class="container" role="main"id="button_block">
					<div class="row">
					<div class="col-xs-12 col-md-12 col-sm-12 logocenter-small">
							<img src="logo3.png" />
						</div>
					
						<div class="col-xs-12 col-md-12 col-sm-12">
							<fieldset>
								<!--<div class="col-xs-4 col-md-4 col-sm-4">
									<a href="http://212.143.233.53/user-upload/<?php print $leadid; ?>/<?php print $newnameimg; ?>" class="button_center btn btn-default">הצג מסמך</a>
								</div>-->
								<div class="col-xs-6 col-md-6 col-sm-6">
								
									<a href="<?php print (isset($_SERVER["HTTPS"]) ? "https://" : "http://") . $_SERVER['SERVER_NAME']."/".$_SERVER['REQUEST_URI']; ?>/?recordNumber=<?php print $leadid; ?>&crmAcccountNumber=<?php print $crmAccount; ?>&agentId=<?php print $agentid; ?>&fileType=<?php print $files ?>&name=<?php print $_POST['name']; ?>&phone=<?php print $_POST['phone']; ?>" class="button_center btn btn-default"> הוסף מסמך נוסף</a>
								
									<!--<button type="button" id="back_to_form" class="button_center btn btn-default">הוסף מסמך נוסף</button>-->
								</div>
								<div class="col-xs-6 col-md-6 col-sm-6">
								
									<a href="http://212.143.233.53/list.php" class="button_center btn btn-default"> List</a>
								
									<!--<button type="button" id="back_to_form" class="button_center btn btn-default">הוסף מסמך נוסף</button>-->
								</div>
							</fieldset>
						</div>
					</div>
				</div>
    
    <?php
    curl_close($curl);
}
