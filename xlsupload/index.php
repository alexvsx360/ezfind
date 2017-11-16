<?php 
//ini_set('error_reporting', E_ALL);
//in/i_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css"  crossorigin="anonymous">
		<!-- Optional theme -->
		<link rel="stylesheet" href="css/bootstrap-theme.min.css"  crossorigin="anonymous">
		<link rel="stylesheet" href="css/style.css">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="js/bootstrap.min.js" crossorigin="anonymous"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>Upload files</title>
	</head>
	<body>
		<?php


        /*Jacob addition */
        $customerFullName ="";
        $customerPhone = "";
        function httpPost($url, $post) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
            $response = curl_exec($ch);
            curl_close($ch);

            return $response;
        }

        if ($_GET){
            global $customerFullName, $customerPhone;
            $lead_id = $_GET['recordNumber'];
            $acc_id = $_GET['crmAcccountNumber'];
            $lm_initializer_id = $_GET['agentId'];
            $key = '3765d732472d44469e70a088caef3040';

            /*get the lead information to populate the html*/
            $populateLeadPostData = [
                'key' => $key,
                'acc_id' => $acc_id,
                'lead_id' => $lead_id
            ];

            $leadInfoStr = httpPost('http://proxy.leadim.xyz/apiproxy/acc3305/getlead.ashx' , $populateLeadPostData);
            $leadToPopulateJson = json_decode($leadInfoStr, true);
            $fieldsValuesJsonArray = array_values($leadToPopulateJson['lead']['fields']);
            $customerFullName = $fieldsValuesJsonArray[0] . " " . $fieldsValuesJsonArray[1];
            $customerPhone =  $fieldsValuesJsonArray[3];

        }
		/*End of Jacob addition*/



		function sql_valid($data) { 
  $data = str_replace("\\", "\\\\", $data); 
  $data = str_replace("'", "\'", $data); 
  $data = str_replace('"', '\"', $data); 
  $data = str_replace("\x00", "\\x00", $data); 
  $data = str_replace("\x1a", "\\x1a", $data); 
  $data = str_replace("\r", "\\r", $data); 
  $data = str_replace("\n", "\\n", $data); 
  return($data);  
 } 
		
		$str = file_get_contents('config.json');
		$category=json_decode($str);
		//echo "<pre>".print_r($category,true)."</pre>";
		if($_GET['fileType']){
			$filetype=str_replace('{','',$_GET['fileType']);
			$filetype=str_replace('}','',$filetype);
			$file_id=explode(';',$filetype);
			//	print_r($file_id);
			$i=0;
			foreach($category as $key=> &$cat){
				$cat->category_crm_id=$file_id[$i];
				$i++;
			
			}
			$files=$_GET['fileType'];
		}
		if($_POST){
			
			$type=0;
			foreach($category as $key=> $cat){
				if(($cat->category_crm_id==$_POST['file_category']) && ($cat->category_name==$_POST['cat_name'])){
					$type=1;
				}
			
			}
			
			$leadid=$_POST['recordNumber'];
			$agentid=$_POST['agentId'];
			$crmAccount=$_POST['crmAcccountNumber'];
			$uploadDir = $_SERVER['DOCUMENT_ROOT'].'/user-upload/'.$leadid.""; //папка для хранения файлов
$wayFile =(isset($_SERVER["HTTPS"]) ? "https://" : "http://") . $_SERVER['SERVER_NAME'].'/user-upload/'.$leadid.""; //папка для хранения файлов
			$array = json_decode(json_encode($category), true);

			for($i=0; $i<=count($array); $i++){
				if($array[$i]['category_crm_id']==$_POST['file_category']){
					$file_category=$array[$i]['file_category'];
					$fld_id=$array[$i]['category_crm_id'];
				}
	
			}

			if(!file_exists($uploadDir)){          
				$new_dir = mkdir ($uploadDir, 0777);         
			} 

			if(isset($_FILES)){
				//проверяем размер и тип файла
				$ext = end(explode('.', strtolower($_FILES['file']['name'])));
				
				if(is_uploaded_file($_FILES['file']['tmp_name'])){
						
					
					if($type==1){
						$uploadDir = $_SERVER['DOCUMENT_ROOT'].'/user-upload-test/'; //папка для хранения файлов
						// вырезаем расширение из имени файла
						$ext=explode('.',$_FILES['file']['name']);
				
						//$n=count($ext);
						//$ext=$ext[$n-1];
						//$ext        = split("[/\\.]", $_FILES['file']['name']);
					
						// задаём новое имя со старым расширением
						$newnameimg =$file_category."_".time(). '.' . mb_strtolower($ext[count($ext) - 1]);
						//$ext=split("[/\\.]", $newnameimg);
						$fileName   = $uploadDir."/".$newnameimg;
					
						if(file_exists($fileName)){
							//...добавляем текущее время к имени файла
							$nameParts = explode('.', $_FILES['file']['name']);
							$nameParts[count($nameParts) - 2] .= time();
							$fileName = $uploadDir.implode('.', $nameParts);
						}
						
						$dir =  'user-upload-test/';
						
						// Sort in ascending order - this is default
						$a = scandir($dir);

						$flag=0;
						foreach($a as $file){

							if(($file!=".") && ($file!="..")){
	
								if(md5_file( "user-upload-test/".$file) == md5_file($_FILES['file']['tmp_name'])) $flag=1;							
							}
						}					
						if($flag==0){
							move_uploaded_file($_FILES['file']['tmp_name'], $fileName);
						}
					
					}
					else{
						$uploadDir = $_SERVER['DOCUMENT_ROOT'].'/user-upload/'.$leadid.""; //папка для хранения файлов
						// вырезаем расширение из имени файла
						$ext=explode('.',$_FILES['file']['name']);
				
						//$n=count($ext);
						//$ext=$ext[$n-1];
						//$ext        = split("[/\\.]", $_FILES['file']['name']);
					
						// задаём новое имя со старым расширением
						$newnameimg =$file_category."_".time(). '.' . mb_strtolower($ext[count($ext) - 1]);
						//$ext=split("[/\\.]", $newnameimg);
						$fileName   = $uploadDir."/".$newnameimg;
					
						if(file_exists($fileName)){
							//...добавляем текущее время к имени файла
							$nameParts = explode('.', $_FILES['file']['name']);
							$nameParts[count($nameParts) - 2] .= time();
							$fileName = $uploadDir.implode('.', $nameParts);
						}
						
						move_uploaded_file($_FILES['file']['tmp_name'], $fileName);
					}
		
				}
				if($type==1){
					
					
					//$dir = "user-upload/".$leadid."/";
				
					if($flag==0){
						
						exec('soffice --headless --convert-to xlsx:"Calc MS Excel 2007 XML" '.$fileName.' --outdir ./user-upload/'.$leadid.'/');
					//unlink($fileName);
					$fileName=$_SERVER['DOCUMENT_ROOT'].'user-upload/'.$leadid.'/'.$newnameimg;
					
					require_once('connect.php');
						
						
						$sql = "DELETE FROM results WHERE res_phone=".$_POST['phone'];							

							if($conn->query($sql) === TRUE){
								//echo "Record deleted successfully";
							} else{
								echo "Error deleting record: " . $conn->error;
							}
							$sql = "SELECT * FROM  `files` as f WHERE f.`fil_phone`=".$_POST['phone'];					
					
							$result = mysqli_query($conn, $sql);
							$count=mysqli_num_rows($result);
							while($row_file = mysqli_fetch_array($result)){
								unlink($row_file['fil_link']);
								unlink($_SERVER['DOCUMENT_ROOT'].'/user-upload-test/'.$row_file['fil_name']);
							}
							
							$sql = "DELETE FROM files WHERE fil_phone=".$_POST['phone'];

							if($conn->query($sql) === TRUE){
								//echo "Record deleted successfully";
							} else{
								echo "Error deleting record: " . $conn->error;
							}
						
						//	if (md5_file(path/file1) == md5_file(/path/file2)) echo "нутро одинаково";
						//else echo "два разных файла";
					
					
						$sql = "INSERT INTO files (fil_phone, fil_name, fil_link)
						VALUES ('".$_POST['phone']."','".$newnameimg."','".$wayFile."/".$newnameimg."')";
						if($conn->query($sql) === TRUE){
							$file_id=$conn->insert_id;
						} else{
							echo "Error: " . $sql . "<br>" . $conn->error;
						}

						require_once('Classes/PHPExcel/IOFactory.php');
						$phpexcel_filename=$fileName;
					ini_set("precision", "15");
					
						$phpexcel_filetype = PHPExcel_IOFactory::identify($phpexcel_filename);
						$phpexcel_objReader = PHPExcel_IOFactory::createReader($phpexcel_filetype);
						$phpexcel_objPHPExcel = $phpexcel_objReader->load($phpexcel_filename);
						// convert one sheet
						$phpexcel_objPHPExcel->getSheet(0)->setRightToLeft(true);
						$phpexcel_sheet = $phpexcel_objPHPExcel->getSheet(0); 
						$phpexcel_highestRow = $phpexcel_sheet->getHighestRow(); 
						$phpexcel_highestColumn = $phpexcel_sheet->getHighestColumn(); 
						$phpexcel_array = $phpexcel_sheet->toArray();



						//  Get worksheet dimensions
						$sheet = $phpexcel_objPHPExcel->getSheet(0); 
						$highestRow = $sheet->getHighestRow(); 
						$highestColumn = $sheet->getHighestColumn();

						$rowData = $sheet->rangeToArray('A' . 2 . ':' . $highestColumn . 2,
							NULL,
							TRUE,
							FALSE);

						$data=date("Y-m-d",strtotime(str_replace('/', '-', $rowData[0][4])));
						$cat_id=0;
						$categories=array();
						//  Loop through each row of the worksheet in turn
						for($row = 5; $row <= $highestRow; $row++){ 
							//  Read a row of data into an array
							$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
								NULL,
								TRUE,
								FALSE);    
						
							

							// Attempt select query execution
							$sql = "SELECT cat_id,cat_name_en FROM  `categories` WHERE `cat_name` like '".$rowData[0][0]."' ";
							$result = mysqli_query($conn, $sql);

							if(mysqli_num_rows($result) > 0){
								while($row_db = mysqli_fetch_array($result)){
									$cat_id=$row_db['cat_id'];
									$categories[]=trim($row_db['cat_name_en']);
								}    	 	
							}
							else{
								$record_link="https://crm.ibell.co.il/a/".$_POST['crmAcccountNumber']."/leads/".$_POST['recordNumber']."/";		
					
								$start='';
								$end='';
								$type_date="";
								if(($rowData[0][4]=="לכל החיים")||($rowData[0][4]=="מתחדש")){
									$type_date=$rowData[0][4];
								}
								else{
									$dates=explode('-',$rowData[0][4]);
						
									$start=date("Y-m-d",strtotime(str_replace('/', '-', trim($dates[0]))));
									$end=date("Y-m-d",strtotime(str_replace('/', '-', trim($dates[1]))));
						
								}
								
								
								if($rowData[0][0]==""){
									?>
									<div class="alert alert-danger">
										This field "ענף ראשי" are empty
									</div>
									<?php
								}
								if($rowData[0][1]==""){
									?>
									<div class="alert alert-danger">
										This field "ענף (משני)" are empty
									</div>
									<?php
								}
								if($rowData[0][2]==""){
									?>
									<div class="alert alert-danger">
										This field "סוג מוצר" are empty
									</div>
									<?php
								}
								if($rowData[0][3]==""){
									?>
									<div class="alert alert-danger">
										This field "חברה" are empty
									</div>
									<?php
								}
								if($rowData[0][4]==""){
									?>
									<div class="alert alert-danger">
										This field "תקופת ביטוח" are empty
									</div>
									<?php
								}
								if(($rowData[0][5]=="")&&($rowData[0][5]!="0")){
									?>
									<div class="alert alert-danger">
										This field "פרמיה בש"ח" are empty
									</div>
									<?php
								}
								if($rowData[0][6]==""){
									?>
									<div class="alert alert-danger">
										This field "סוג פרמיה" are empty
									</div>
									<?php
								}
								if($rowData[0][7]==""){
									?>
									<div class="alert alert-danger">
										This field "מספר פוליסה" are empty
									</div>
									<?php
								}
								if($rowData[0][8]==""){
									?>
									<div class="alert alert-danger">
										This field "סיווג תכנית" are empty
									</div>
									<?php
								}
					$r0=sql_valid($rowData[0][0]);
					$r1=sql_valid($rowData[0][1]);
					$r2=sql_valid($rowData[0][2]);
					$r3=sql_valid($rowData[0][3]);					
					$r5=sql_valid($rowData[0][5]);
					$r6=sql_valid($rowData[0][6]);
					$r7=sql_valid($rowData[0][7]);
					$r8=sql_valid($rowData[0][8]);
								$sql = "INSERT INTO results (res_crm_account_number, res_record_number, res_record_link,res_name,res_phone,res_link_to_file,res_cat_id, res_main_branch, res_branch, 	res_product_type, res_insurance_company, res_start_date, res_end_date,res_type_date, res_product_cost, res_payment_type,  res_policy_number, res_insurance_type, res_date, res_last_update_date)
								VALUES ('".$_POST['crmAcccountNumber']."','".$_POST['recordNumber']."','".$record_link."','".$_POST['name']."','".$_POST['phone']."','".$file_id."','".$cat_id."','".$r0."','".$r1."','".$r2."','".$r3."','".$start."','".$end."','".$type_date."',".$r5.",'".$r6."','".$r7."','".$r8."','".$data."','".date('Y-m-d')."')";

								if($conn->query($sql) === TRUE){
									//echo "New record created successfully";
								} else{
									echo "Error: " . $sql . "<br>" . $conn->error;
								}
							}
						}
						$cat=implode(" & ",$categories);$cat_id=0;
						$sql = "SELECT fct_id FROM  `file_category` WHERE `fct_name_en` like '".$cat."' ";
						$result = mysqli_query($conn, $sql);

						if(mysqli_num_rows($result) > 0){
							while($row_db = mysqli_fetch_array($result)){
								$cat_id=$row_db['fct_id'];
								
							}    	 	
						}
						if($cat_id){
							$sql = "UPDATE files SET fil_cat='".$cat_id."' WHERE fil_id=".$file_id;

							if($conn->query($sql) === TRUE){
								//	echo "Record updated successfully";
							} else{
								//	echo "Error updating record: " . $conn->error;
							}
						}
						//print $cat;
						//echo '</pre>';
					}
					else{
						?>
			<div class="container" role="main"id="button_block">
					<div class="row">
					
						<div class="col-xs-12 col-md-12 col-sm-12 logocenter">
			<div class="alert alert-danger center-block">
			  File already exist
			</div>
			</div>
			</div>
			</div>
			<?php
					}
				}
			}
			?>
			<script type="text/javascript">
				var formData= new Object;
				formData['fld_id']=<?php print $fld_id; ?>;
				//formData['fld_val']='/user-upload/<?php print $leadid; ?>/<?php print $newnameimg; ?>';
				formData['fld_val']='<?php print (isset($_SERVER["HTTPS"]) ? "https://" : "http://") . $_SERVER["SERVER_NAME"]; ?>/user-upload/<?php print $leadid; ?>/<?php print $newnameimg; ?>';
				$.ajax({
						url: 'https://proxy.leadim.xyz/apiproxy/acc3305/updatelead.ashx',
						type: "post",					
						data: {'acc_id':<?php print $crmAccount; ?>, 'usr_id':<?php print $agentid; ?>, 'lead_id':<?php print $leadid; ?>,'update_fields':formData},
      
						success: function(html){
							console.log(html);
						}
					});
			</script>
			<?php if($type!=1){ ?>
				<div class="container" role="main"id="button_block">
					<div class="row">
					<div class="col-xs-12 col-md-12 col-sm-12 logocenter">
							<img src="logo3.png" />
						</div>
						<div class="col-xs-12 col-md-12 col-sm-12">
							<fieldset>
								<div class="col-xs-6 col-md-6 col-sm-6">
									<a href="<?php print (isset($_SERVER["HTTPS"]) ? "https://" : "http://") . $_SERVER['SERVER_NAME']; ?>/user-upload/<?php print $leadid; ?>/<?php print $newnameimg; ?>" class="button_center btn btn-default">הצג מסמך</a>
								</div>
								<div class="col-xs-6 col-md-6 col-sm-6">
								
									<a href="<?php print (isset($_SERVER["HTTPS"]) ? "https://" : "http://") . $_SERVER['SERVER_NAME']; ?>/?recordNumber=<?php print $leadid; ?>&crmAcccountNumber=<?php print $crmAccount; ?>&agentId=<?php print $agentid; ?>&fileType=<?php print $files ?>&name=<?php print $_POST['name']; ?>&phone=<?php print $_POST['phone']; ?>" class="button_center btn btn-default"> הוסף מסמך נוסף</a>
								
									<button type="button" id="back_to_form" class="button_center btn btn-default">הוסף מסמך נוסף</button>
								</div>
							</fieldset>
						</div>
					</div>
				</div>

				<div class="container hide" role="main" id="back_form">
					<div class="row">
						<div class="col-xs-12 col-md-12 col-sm-12 logocenter">
							<img src="logo3.png" />
						</div>
						<div class="col-xs-12 col-md-12 col-sm-12">
							<form action="redirect.php" method="post" id="uploadForm" enctype="multipart/form-data">
								<fieldset>
									<div class="error alert alert-danger">
										אנא בחרו קובץ
									</div>
									<div class="form-group">
										<input type="hidden" class="input-group form-control" value="<?php if($_GET['recordNumber']){ print $_GET['recordNumber'];} ?>"  name="recordNumber"/>	
										<input type="hidden" class="input-group form-control" value="<?php if($_GET['crmAcccountNumber']){ print $_GET['crmAcccountNumber'];} ?>"  name="crmAcccountNumber"/>
										<input type="hidden" class="input-group form-control" value="<?php if($_GET['agentId']){ print $_GET['agentId'];} ?>"  name="agentId"/>
                                        <input type="hidden" class="input-group form-control" value="<?php print $customerFullName ?>"  name="name"/>
                                        <input type="hidden" class="input-group form-control" value="<?php print $customerPhone ?>" name="phone"/>
									</div>
									<div class="form-group">
										<label for="sel1">קטגורית המסמך:</label>
										<select class="form-control" id="category" name="file_category">
											<option value="0">לבחור קטגוריה
											</option>
											<?php foreach($category as $item){
												?>
												<option value="<?php print $item->category_crm_id; ?>"><?php print $item->category_name; ?></option>
												<?php
											} ?>
			
										</select>
										<input type="hidden" name="cat_name" class="cat_name"/>
									</div>
									<div class="form-group">
										<label for="exampleInputFile">בחר מסמך</label>
										<input type="file" name="file" class="form-control-file" id="InputFile" aria-describedby="fileHelp"/>    
						
									</div>
									<div class="btn-group" role="group" aria-label="">
										<input type="submit" id="submit"  class="btn btn-primary" name="submit" value="העלה מסמך"/>
									</div>
					
					
								</fieldset>
							</form>
	
						</div>
					</div>
				</div>

				<?php
			}
			else{
				?>
				
				<div class="container" role="main"id="button_block">
					<div class="row">
					<div class="col-xs-12 col-md-12 col-sm-12 logocenter-small">
							<img src="logo3.png" />
						</div>
					
						<div class="col-xs-12 col-md-12 col-sm-12">
							<fieldset>
								<div class="col-xs-4 col-md-4 col-sm-4">
									<a href="<?php print (isset($_SERVER["HTTPS"]) ? "https://" : "http://") . $_SERVER['SERVER_NAME']; ?>/user-upload/<?php print $leadid; ?>/<?php print $newnameimg; ?>" class="button_center btn btn-default">הצג מסמך</a>
								</div>
								<div class="col-xs-4 col-md-4 col-sm-4">
								
									<a href="<?php print (isset($_SERVER["HTTPS"]) ? "https://" : "http://") . $_SERVER['SERVER_NAME']; ?>/?recordNumber=<?php print $leadid; ?>&crmAcccountNumber=<?php print $crmAccount; ?>&agentId=<?php print $agentid; ?>&fileType=<?php print $files ?>&name=<?php print $_POST['name']; ?>&phone=<?php print $_POST['phone']; ?>" class="button_center btn btn-default"> הוסף מסמך נוסף</a>
								
									<!--<button type="button" id="back_to_form" class="button_center btn btn-default">הוסף מסמך נוסף</button>-->
								</div>
								<div class="col-xs-4 col-md-4 col-sm-4">
								
									<a href="<?php print (isset($_SERVER["HTTPS"]) ? "https://" : "http://") . $_SERVER['SERVER_NAME']; ?>/list.php" class="button_center btn btn-default"> List</a>
								
									<!--<button type="button" id="back_to_form" class="button_center btn btn-default">הוסף מסמך נוסף</button>-->
								</div>
							</fieldset>
						</div>
					</div>
				</div>

				<div class="container hide" role="main" id="back_form">
					<div class="row">
						<div class="col-xs-12 col-md-12 col-sm-12 logocenter">
							<img src="logo3.png" />
						</div>
						<div class="col-xs-12 col-md-12 col-sm-12">
							<form action="redirect.php" method="post" id="uploadForm" enctype="multipart/form-data">
								<fieldset>
									<div class="error alert alert-danger">
										אנא בחרו קובץ
									</div>
									<div class="form-group">
										<input type="hidden" class="input-group form-control" value="<?php if($_GET['recordNumber']){ print $_GET['recordNumber'];} ?>"  name="recordNumber"/>	
										<input type="hidden" class="input-group form-control" value="<?php if($_GET['crmAcccountNumber']){ print $_GET['crmAcccountNumber'];} ?>"  name="crmAcccountNumber"/>
										<input type="hidden" class="input-group form-control" value="<?php if($_GET['agentId']){ print $_GET['agentId'];} ?>"  name="agentId"/>
										<input type="hidden" class="input-group form-control" value="<?php print $customerFullName ?>"  name="name"/>
										<input type="hidden" class="input-group form-control" value="<?php print $customerPhone ?>" name="phone"/>
									</div>
									<div class="form-group">
										<label for="sel1">קטגורית המסמך:</label>
										<select class="form-control" id="category" name="file_category">
											<option value="0">לבחור קטגוריה
											</option>
											<?php foreach($category as $item){
												?>
												<option value="<?php print $item->category_crm_id; ?>"><?php print $item->category_name; ?></option>
												<?php
											} ?>
			
										</select>
										<input type="hidden" name="cat_name" class="cat_name"/>
									</div>
									<div class="form-group">
										<label for="exampleInputFile">בחר מסמך</label>
										<input type="file" name="file" class="form-control-file" id="InputFile" aria-describedby="fileHelp"/>    
						
									</div>
									<div class="btn-group" role="group" aria-label="">
										<input type="submit" id="submit"  class="btn btn-primary" name="submit" value="העלה מסמך"/>
									</div>
					
					
								</fieldset>
							</form>
	
						</div>
					</div>
				</div>
				
				<?php
			}
			
		} else{
			

			?>
			<div class="container" role="main">
				<div class="row">
					<div class="col-xs-12 col-md-12 col-sm-12 logocenter">
						<img src="logo3.png" />
					</div>
					<div class="col-xs-12 col-md-12 col-sm-12">
						<form action="redirect.php" method="post" enctype="multipart/form-data">
							<fieldset>
								<div class="error alert alert-danger">
									אנא בחרו קובץ
								</div>
								<div class="form-group">
									<input type="hidden" class="input-group form-control" value="<?php if($_GET['recordNumber']){ print $_GET['recordNumber'];} ?>" placeholder="מספר הליד" name="recordNumber"/>
		
									<input type="hidden" class="input-group form-control" value="<?php if($_GET['crmAcccountNumber']){ print $_GET['crmAcccountNumber'];} ?>" placeholder="מספר חשבון" name="crmAcccountNumber"/>
									<input type="hidden" class="input-group form-control" value="<?php if($_GET['agentId']){ print $_GET['agentId'];} ?>" placeholder="מספר נציג" name="agentId"/>
                                    <input type="hidden" class="input-group form-control" value="<?php print $customerFullName ?>"  name="name"/>
                                    <input type="hidden" class="input-group form-control" value="<?php print $customerPhone ?>" name="phone"/>
								</div>
								<div class="form-group">
									<label for="sel1">קטגורית המסמך:</label>
									<select class="form-control" id="category" name="file_category">
										<option value="0">לבחור קטגוריה
										</option>
										<?php foreach($category as $item){
											?>
											<option value="<?php print $item->category_crm_id; ?>"><?php print $item->category_name; ?></option>
											<?php
			
										} ?>
			
									</select>
									<input type="hidden" name="cat_name" class="cat_name"/>
								</div>
								<div class="form-group">
									<label for="exampleInputFile">בחר מסמך</label>
									<input type="file" name="file" class="form-control-file" id="InputFile" aria-describedby="fileHelp">    
						
								</div>
								<div class="btn-group" role="group" aria-label="">
									<input type="submit"  id="submit" class="btn btn-primary" name="submit" value="העלה מסמך"/>
  
  
								</div>
					
					
							</fieldset>
						</form>
	
					</div>
				</div>
			</div>
			<?php
		} ?>
		<script>
			jQuery(document).ready(function(){
							
							
					jQuery("#back_to_form").click(function(){
							jQuery('#back_form').removeClass('hide');
							jQuery('#button_block').hide();
						});
 	
 	
					jQuery('select#category').on('change', function (e) {
							var optionSelected = jQuery("option:selected", this);
							var valueSelected = this.value;
    
							jQuery('.cat_name').val(optionSelected.text());
						});						
							
					jQuery("#submit").click(function(){
							var ddd= jQuery("#InputFile").val();
							if(ddd==""){
								jQuery('.error').show();
								return false;
							}
							else{
								jQuery('.error').hide();
								return true;
							} 
						});
				});
      
		</script>
		
	</body>
</html>