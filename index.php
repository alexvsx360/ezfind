<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Optional theme -->
		<link rel="stylesheet" h    ref="css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/style.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
		<script src="js/bootstrap.min.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>Upload files</title>
	</head>
	<body>
		<?php
        include ('functions.php');

        $yesNoJson = [
          "כן" => true,
          "לא" => false
        ];


        $myfile = fopen("log.txt", "a");

        $str = file_get_contents('config.json');
        $category=json_decode($str);

        $str2 = file_get_contents('agentNumbersJson.json');
        $agentNumbersJson =json_decode($str2);
        //echo "<pre>".print_r($category,true)."</pre>";
        if ($_GET['fileType']) {
            $filetype=str_replace('{', '', $_GET['fileType']);
            $filetype=str_replace('}', '', $filetype);
            $file_id=explode(';', $filetype);
        //	print_r($file_id);
            $i=0;
            foreach ($category as $key => &$cat) {
                $cat->category_crm_id=$file_id[$i];
                $i++;
            }
        }
        if ($_GET){
            $lead_id = $_GET['recordNumber'];
            $acc_id = $_GET['crmAcccountNumber'];
            $lm_initializer_id = $_GET['agentId'];
            $key = '3765d732472d44469e70a088caef3040';

            /*get the lead information to populate the html*/
            $populateLeadPostData = [
                'key' => $key,
                'acc_id' => $acc_id,
                'lead_id' => $lead_id,
                'lm_initializer_id' => $lm_initializer_id
            ];

            $leadInfoStr = httpPost('http://proxy.leadim.xyz/apiproxy/acc3305/getlead.ashx' , $populateLeadPostData);
            $leadToPopulateJson = json_decode($leadInfoStr, true);
            fwrite($myfile, "leadToPopulateJson: " . $leadToPopulateJson);
            $fieldsValuesJsonArray = array_values($leadToPopulateJson['lead']['fields']);
            $fullName = $fieldsValuesJsonArray[0] . " " . $fieldsValuesJsonArray[1];
            $phone =  $fieldsValuesJsonArray[3];
            $promoterName = $fieldsValuesJsonArray[16];
            $currentUserName = $leadToPopulateJson['user']['name'];
            $currentUserEmail = $leadToPopulateJson['user']['email'];
            $channelName = $leadToPopulateJson['lead']['channel_name'];

        }

        if ($_POST) {
            fwrite($myfile, "I am in POST");
            $customerName = $_POST['customerName'];
            $customerId = $_POST['customerId'];
            $policy = $_POST['policy'];
            $insuranceCompany = $_POST['insuranceCompany'];
            $hitum = $_POST['hitum'];
            $premia = $_POST['premia'];
            $cancellationLetter = $_POST['cancellationNumber'];
            $insuranceStartDate = $_POST['insuranceStartDate'];
            $userEmail = $_POST['userEmail'];
            $userName = $_POST['userName'];
            $birthDate = $_POST['birthDate'];
            $sex = $_POST['sex'];
            $marriageStatus = $_POST['marriageStatus'];
            $customerAddress = $_POST['customerAddress'];
            $customerPhone = $_POST['customerPhone'];
            $customerEmail = $_POST['customerEmail'];
            $leadChannel = $_POST['leadChannel'];
            $discount = $_POST['discount'];
            $insuranceComment = $_POST['insuranceComment'];
            $customerIdIssueDate = $_POST['issueDate'];
            $promoterName = $_POST['promoterName'];
            $agentId = $_POST['agentId'];
            $saleDate = $_POST['saleDate'];
            $cancelPolicyNumber = $_POST['cancelPolicy'];
            $cancelInsuranceCompany = $_POST['cancelInsuranceCompany'];
            $payingWith = $_POST['payingWith'];
            $leadid=$_POST['recordNumber'];
            $agentid=$_POST['agentId'];
            $crmAccount=$_POST['crmAcccountNumber'];
            $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/user-upload/'.$leadid."/"; //папка для хранения файлов

            $linkInformation = array(
                'כלל'=> array(
                    'תאונות_אישיות' => 'https://bit.ly/2H5CsFe',
                    'בריאות' => 'https://bit.ly/2H2plnY',
                    'מחלות_קשות' => 'https://bit.ly/2H2oXWM',
                    'חיים' => 'https://bit.ly/2EbJ7dI'
                ),
                'הראל'=>array(
                    'תאונות_אישיות' => 'https://bit.ly/2pWEI9l',
                    'בריאות' => 'https://bit.ly/2GoIXpo',
                    'מחלות_קשות' => 'https://bit.ly/2Gul8Zn',
                    'חיים' => 'https://bit.ly/2J9RTg9'
                ),
                'איילון'=>array(
                    'תאונות_אישיות' => 'https://bit.ly/2Gpi0SH',
                    'בריאות' => 'https://bit.ly/2Gs5txB',
                    'מחלות_קשות' => 'https://bit.ly/2Eb4uMi',
                    'חיים' => 'https://bit.ly/2J8EFQG'
                )
            );
            fwrite($myfile, "I am in station 2");
            foreach ($category as $cat) {
                if (true/*$_POST['file_category']==$cat->category_crm_id*/) {
                    $file_category=$cat->file_category;
                    $fld_id=$cat->category_crm_id;
                }
            }


            $dir = 'files/gallery/'.$leadid.'/';
            if (!file_exists($uploadDir)) {
                $new_dir = mkdir ($uploadDir, 0777);
            }


            fwrite($myfile, "I am in station 3");
            if(isset($_FILES)){
                //проверяем размер и тип файла
                $ext = end(explode('.', strtolower($_FILES['file']['name'])));

                if(is_uploaded_file($_FILES['file']['tmp_name'])){

                    // вырезаем расширение из имени файла
                    $ext=explode('.',$_FILES['file']['name']);
                    //$n=count($ext);
                    //$ext=$ext[$n-1];
                    //$ext        = split("[/\\.]", $_FILES['file']['name']);

                    // задаём новое имя со старым расширением
                    $newnameimg =$file_category."_".time(). '.' . $ext[count($ext) - 1];
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
            fwrite($myfile, "I am in station 4 - before API");
            /*API to Zendesk*/
            $ticketUrl = "https://ezfind.zendesk.com/api/v2/tickets.json";
            //format date for the ticket from 'dd-mm-yy' to 'yy-mm-dd'.
            $ticketInsuranceStartDate = date_create($_POST['insuranceStartDate']);
            $ticketInsuranceStartDate = date_format($ticketInsuranceStartDate,"Y/m/d");
            $ticketInsuranceStartDate = str_replace('/', '-', $ticketInsuranceStartDate);
            $data = '';
            $data->subject = $customerName . ' ' . $customerId . ' ' . $policy . ' ' . $insuranceCompany;
            $data->custom_fields = array(
                '114100300592' => $hitum,                                          //מסלול חיתום
                '114096335892' =>   getCallCenterById($crmAccount),                 // מוקד ביטוח
                '114096371131' => $policy,                                                      //כיסוי ביטוחי
                '114096335852' => $insuranceCompany,                                // חברת ביטוח
                '114096335872' => $premia,                                          //פרמיה
                '114096401231' => $yesNoJson[$cancellationLetter]  ,                               // האם יש מכתב ביטול?
                '114096372992' => $ticketInsuranceStartDate,                                                //תאריך תחילת ביטוח
                '114096462111' => "תור_בקרה"
            );
            $data->requester = array(
                'email' => $userEmail,
                'name' => $userName
            );
            $data->collaborators = getCollaboratorArrayById($crmAccount, $userEmail);
            $data->comment = array(
                'body' =>   'שם מלא: ' .$customerName . " \n" .
                            'תעודת זהות: ' . $customerId . " \n" .
                            'תאריך לידה: ' . $birthDate . " \n" .
                            'מין: ' . $sex . " \n" .
                            'מצב משפחתי: ' . $marriageStatus . " \n" .
                            'כתובת מלאה: ' . $customerAddress . " \n" .
                            'מספר נייד: ' . $customerPhone . " \n" .
                            'אימייל של הלקוח: ' . $customerEmail . "n\n\n\n\n\n" .
                            'מוקד: ' . getCallCenterById($crmAccount) . " \n" .
                            'איש מכירות: ' . $userName . " \n" .
                            'ערוץ מכירה : ' . $leadChannel . " \n" .
                            'כיסוי ביטוחי : ' . $policy . " \n" .
                            'חברת ביטוח : ' . $insuranceCompany . " \n" .
                            'פרמיה בש"ח : ' . $premia . " \n" .
                            'הנחה באחוזים : ' . $discount . " \n" .
                            'מסלול חיתום : ' . $hitum . " \n" .
                            'תאריך תחילת ביטוח : ' .$insuranceStartDate. " \n" .
                            'האם יש מכתב ביטול? : ' . $cancellationLetter  . " \n" .
                            'חברת ביטוח אליה ישלח מכתב הביטול : ' . $cancelInsuranceCompany  . " \n" .
                            'מספר פוליסה לבטל : ' . $cancelPolicyNumber  . " \n" .
                            'תאריך המכירה : ' . $saleDate  . " \n" .
                            'אמצעי תשלום : ' . $payingWith  . " \n" .
                            'גילוי נאות: '. $linkInformation[$insuranceCompany][$policy]. " \n" .
                            'לינק למסמכים : ' . 'https://portal.ibell.co.il/user-upload/' . $leadid . '/' . $newnameimg . " \n\n" .
                            'הערות להצעה: ' . $insuranceComment

            );


            /*API to Zendesk to open the ticket*/
            $arr = array("z_comment"=>"I need some more help");
            $create = json_encode(array('ticket' => $data)/*, JSON_UNESCAPED_UNICODE*/);
            fwrite($myfile, "return value from Zendesk API is " . print_r($create, true));

            $username = 'yaki@ezfind.co.il/token';
            $password = 'Bdt7m6GAv0VQghQ6CRr81nhCMXcjq2fIfZHwMjMW';

            $process = curl_init($ticketUrl);
            curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            //curl_setopt($process, CURLOPT_HEADER, 1);
            curl_setopt($process, CURLOPT_USERPWD, $username . ":" . $password);
            curl_setopt($process, CURLOPT_TIMEOUT, 30);
            curl_setopt($process, CURLOPT_POST, 1);
            curl_setopt($process, CURLOPT_POSTFIELDS, $create /*array('ticket'=>json_encode($data, JSON_UNESCAPED_UNICODE))*/);
            curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
            $return = curl_exec($process);
            curl_close($process);
            fwrite($myfile, "return value from Zendesk API is " . $return);


            $ticketCreationResponse = json_decode($return, true);
            $callCenterName = getCallCenterById($crmAccount);
            $baseUrl = "http://api.lead.im/v1/submit";
            $costumerPost = [
                'lm_form' => '17993',
                'lm_key' => '6ebab5cef5',
                'lm_redirect' => 'no',
                /*'lm_supplier' => $agentId,*/
                'name' => $customerName,
                'phone' => $customerPhone,
                'id' => $customerId,
                'issueDate' => $customerIdIssueDate,
                'email' => $customerEmail,
                'birthDate' => $birthDate,
                'sex' => $sex,
                'familyStatus' => $marriageStatus,
                'address' => $customerAddress,
                'callCenter' => $callCenterName
                ];

            $policyPost = [
                'lm_form' => '17968',
                'lm_key' => 'e74d9a88fc',
                'lm_redirect' => 'no',
                'lm_supplier' => $agentId,
                'name' => $customerName,
                'phone' => $customerPhone,
                'id' => $customerId,
                'issueDate' => $customerIdIssueDate,
                'email' => $customerEmail,
                'birthDate' => $birthDate,
                'sex' => $sex,
                'familyStatus' => $marriageStatus,
                'address' => $customerAddress,
                'ticketNumber' => $ticketCreationResponse['ticket']['id'],
                'zendeskLink' => 'https://ezfind.zendesk.com/agent/tickets/' . $ticketCreationResponse['ticket']['id'],
                'callCenter' => $callCenterName,
                'sellingChannel' => $leadChannel,
                'sellerName' => $userName,
                'leadPromoter' => $promoterName,
                'agentNumber' => $agentNumbersJson->$insuranceCompany->$callCenterName,
                'policy' => str_replace('_'," ", $policy),
                'insuranceCompany' => $insuranceCompany,
                'premia' => $premia,
                'hitum' => $hitum,
                'insuranceStartDate' => $insuranceStartDate,
                'cancellationLetter' => $cancellationLetter,
                'cancelInsuranceCompany' => $cancelInsuranceCompany,
                'cancelPolicyNumber' => $cancelPolicyNumber,
                'saleDate' => $saleDate,
                'payingWidth' => $payingWith ,
                'giluy_naot' => $linkInformation[$insuranceCompany][$policy]
           ];


            fwrite($myfile, "create policy POST parameter open new lead in Lead.im" . $policyPost);
            fwrite($myfile, "create customer POST parameter open new lead in Lead.im" . $costumerPost);

            //updateBIScreen($agentId, $insuranceCompany, $premia, $hitum, $userName, $promoterName, $leadChannel, "תור_בקרה", str_replace('_'," ", $policy), $customerId, $callCenterName);
            /*post to create policy */
            $return = httpPost($baseUrl, $policyPost);
            /*todo add post to create new customer */
            /*search lead by id, if e*/
            updateCustomer($return, $costumerPost, $customerPhone, $myfile);

            fwrite($myfile, "Response from Lead.im" . $return);
            fwrite($myfile, "\nLead number is: " . $return ." ticket id is: " . $ticketCreationResponse['ticket']['id']);



            ?>

            <div class="container" role="main" id="button_block">
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                        <fieldset>
                            <div class="col-xs-6 col-md-6 col-sm-6">
                                <button type="button" id="back_to_form" class="button_center btn btn-default">ההצעה הועלתה בהצלחה!</button>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>

            <?php
        } else {
            ?>
            <div class="container" role="main" id="back_form">
<!--
            Remove the Logo
                <div class="text-center">
                    <img src="logo3.png" class="rounded">
                </div>
-->
            <div class="row" >
                    <form id= "main-form" action="" class="" method="post"    enctype="multipart/form-data">
                        <div class="form-group">

                            <!--Need to delete after testing-->
                            <input type="hidden" class="input-group form-control" value="<?php if ($_GET['recordNumber']) {  print $_GET['recordNumber']; } ?>" placeholder="מספר הליד" name="recordNumber"/>
                            <input type="hidden" class="input-group form-control" value="<?php if ($_GET['crmAcccountNumber']) { print $_GET['crmAcccountNumber']; } ?>" placeholder="מספר חשבון" name="crmAcccountNumber"/>
                            <input type="hidden" class="input-group form-control" value="<?php if ($_GET['agentId']) { print $_GET['agentId']; } ?>" placeholder="מספר נציג" name="agentId"/>
                            <!-- Need to delete after testing-->

                            <input type="hidden" class="input-group form-control" value="<?php print $currentUserName; ?>" placeholder="שם הנציג" name="userName"/>
                            <input type="hidden" class="input-group form-control" value="<?php print $currentUserEmail; ?>" placeholder="אימייל של הנציג" name="userEmail"/>
                            <input type="hidden" class="input-group form-control" value="<?php print $channelName ?>" placeholder="ערוץ הליד" name="leadChannel"/>

                        </div>

                        <div class="row" >
                            <div class="col-xs-2 "></div>
                            <div class="col-xs-4 ">
                                <label for="sel1">שם הלקוח:</label>
                                <input required type="text" class="input-group form-control" value="<?php  print $fullName; ?>" placeholder="שם הלקוח" name="customerName"/>
                            </div>

                            <div class="col-xs-4">
                                <label for="sel1">כיסוי ביטוחי:</label>
                                <select required class="form-control" id="policy" name="policy">
                                    <option disabled selected value> -- בחר כיסוי ביטוחי -- </option>
                                    <option value="תאונות_אישיות">תאונות אישיות</option>
                                    <option value="אובדן_כושר_עבודה">אכ"ע</option>
                                    <option value="מחלות_קשות">מחלות קשות</option>
                                    <option value="חיים">ריסק</option>
                                    <option value="בריאות">בריאות</option>
                                    <option value="ביטוח_משכנתא">ריסק למשכנתא</option>
                                    <option value="סיעודי">סיעודי</option>
                                </select>
                            </div>
                        </div>

                        <div class="row" >
                            <div class="col-xs-2 "></div>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <label for="sel1">מספר תז:</label>
                                <input required type="text" class="input-group form-control"  placeholder="מספר תז" name="customerId"/>
                            </div>

                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <label for="sel1">חברת ביטוח:</label>
                                <select required class="form-control" id="insuranceCompany" name="insuranceCompany">
                                    <option disabled selected value> -- בחר חברת ביטוח -- </option>
                                    <option value="כלל">כלל</option>
                                    <option value="הראל">הראל</option>
                                    <option value="איילון">איילון</option>
                                    <option value="הפניקס">הפניקס</option>
                                    <option value="הכשרה">הכשרה</option>
                                </select>
                            </div>
                        </div>

                        <div class="row" >
                            <div class="col-xs-2 "></div>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <label for="sel1">דוא"ל:</label>
                                <input required type="email" class="input-group form-control"  placeholder="דואל" name="customerEmail"/>
                            </div>

                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <label for="sel1">פרמיה בש"ח:</label>
                                <input required type="number" class="input-group form-control" id="sum_premia" placeholder="פרמיה בשח" name="premia"/>
                                <p id ="num_alert" class="alert-danger" style ="visibility: hidden">הפרמיה חיבת להיות גדולה מ-0</p>

                            </div>
                        </div>

                        <div class="row" >
                            <div class="col-xs-2 "></div>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <label for="sel1">נייד:</label>
                                <input required type="text" class="input-group form-control" value="<?php  print $phone; ?>" placeholder="מספר נייד" name="customerPhone"/>

                            </div>

                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <label for="sel1">אחוז הנחה:</label>
                                <input required type="text" class="input-group form-control" placeholder="אחוז הנחה" name="discount"/>
                            </div>
                        </div>

                        <div class="row" >
                            <div class="col-xs-2 "></div>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <label for="sel1">תאריך לידה:</label>
<!--                              //  <date-util format="dd/MM/yyyy"></date-util>-->
                                <input required type="text" class="input-group form-control date datepicker"  data-date-format="dd-mm-yyyy" placeholder="תאריך לידה" name="birthDate"/>
                            </div>

                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <label for="sel1">מסלול חיתום:</label>
                                <select required class="form-control" id="hitum" name="hitum">
                                    <option disabled selected value> -- בחר מסלול חיתום -- </option>
                                    <option value="ירוק">ירוק</option>
                                    <option value="אדום">אדום</option>
                                </select>
                            </div>
                        </div>

                        <div class="row" >
                            <div class="col-xs-2 "></div>

                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <label for="sel1">תאריך הנפקת תעודת זהות:</label>
                                <input required type="text" class="input-group form-control datepicker"  placeholder="תאריך הנפקת תעודת זהות" name="issueDate"/>
                            </div>

                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <label for="sel1">תאריך תחילת ביטוח:</label>
                                <input required type="text" id="insurance_start_date" class="datepicker input-group form-control " placeholder="תאריך תחילת ביטוח" name="insuranceStartDate" "/>
                                <p id ="date_alert" class="alert-danger" style ="visibility: hidden">תאריך תחילת הביטוח יהיה מהיום והלאה</p>
                            </div>
                        </div>

                        <div class="row" >

                            <div class="col-xs-2 "></div>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <label for="sel1">האם יש מכתב ביטול?</label>
                                <select required class="form-control" id="cancellationNumber" name="cancellationNumber">
                                    <option disabled selected value> -- האם יש מכתב ביטול -- </option>
                                    <option value="כן">כן</option>
                                    <option value="לא">לא</option>
                                </select>
                            </div>

                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <label for="sel1">מצב משפחתי:</label>
                                <select required class="form-control" id="marriageStatus" name="marriageStatus">
                                    <option disabled selected value> -- בחר מצב משפחתי -- </option>
                                    <option value="רווק">רווק</option>
                                    <option value="נשוי">נשוי</option>
                                    <option value="גרוש">גרוש</option>
                                    <option value="אלמן">אלמן</option>
                                    <option value="אחר">אחר</option>
                                </select>
                            </div>

                        </div>


                        <!--Hiddene input for cancellation letter-->
                        <div class="row" >
                            <div class="col-xs-2 "></div>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <label for="sel1">מספר פוליסה לביטול</label>
                                <input type="text" class="input-group form-control"  placeholder="מספר פוליסה לביטול" id="cancelPolicy" name="cancelPolicy"/>
                            </div>

                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <label for="sel1">באיזו חברת ביטוח לבטל?</label>
                                <input type="text" class="input-group form-control"  placeholder="באיזו חברת ביטוח לבטל?" id="cancelInsuranceCompany" name="cancelInsuranceCompany"/>
                            </div>
                        </div>

                        <!--End of hidden fields-->


                        <div class="row" >
                            <div class="col-xs-2 "></div>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <label for="sel1">שם המקדם:</label>
                                <input required type="text" class="input-group form-control" value="<?php print $promoterName ; ?>" placeholder="שם המקדם" name="promoterName"/>
                            </div>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <label for="sel1">מין:</label>
                                <select required class="form-control" id="sex" name="sex">
                                    <option disabled selected value> -- בחר מין -- </option>
                                    <option value="זכר">זכר</option>
                                    <option value="נקבה">נקבה</option>
                                </select>
                            </div>

                        </div>

                        <div class="row" >
                            <div class="col-xs-2 "></div>

                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <label for="sel1">כתובת מלאה:</label>
                                <input required class="form-control" rows="4" placeholder="כתובת מלאה" name="customerAddress"  id="customerAddress">
                            </div>

                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <label for="sel1">תאריך המכירה (ברירת מחדל - היום):</label>
                                <input id="saleDate" required type="text"  value="" class="input-group form-control datepicker"  name="saleDate"/>
                            </div>
                        </div>

                        <div class="row" >
                            <div class="col-xs-2 "></div>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <label for="sel1">אמצעי תשלום:</label>
                                <select required class="form-control" id="payingWith" name="payingWith">
                                    <option disabled selected value> -- בחר אמצעי תשלום -- </option>
                                    <option value="אשראי">אשראי</option>
                                    <option value="הוראת קבע">הוראת קבע</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-xs-2 "></div>

                            <div class="col-xs-10 col-sm-8 col-md-8 col-lg-8">
                                <label for="sel1">הערות להצעה:</label>
                                <textarea class="form-control" rows="4"  id="insuranceComment" name="insuranceComment"></textarea>
                            </div>



                        </div>

                        <div class="row" >
                            <div class="col-xs-2 "></div>

                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <label for="exampleInputFile">בחר מסמך</label>
                                <input required type="file" name="file" class="custom-file-input" id="exampleInputFile" aria-describedby="fileHelp">
                            </div>

                            <div class="btn-group col-xs-10 col-sm-4 col-md-4 col-lg-4" role="group" aria-label="">
                                <input type="submit" class="btn btn-primary" id="submit" name="sendForm" value="שלח הצעה"/>
                            </div>

                        </div>
                            </div>

                    </form>

                </div>
            <?php

        } ?>

        <script>

            $( function() {
                $( ".datepicker" ).datepicker({dateFormat: "dd-mm-yy"})
            });

            jQuery(document).ready(function(){
                //to set defult value today in input '#saleDate', format:'dd-mm-yy'.
                var now = new Date();
                var day = ("0" + now.getDate()).slice(-2);
                var month = ("0" + (now.getMonth() + 1)).slice(-2);
                var today =(day) +"-"+(month)+"-"+ now.getFullYear();
                $('#saleDate').val(today);

                jQuery("#cancellationNumber").change(function (){
                    console.log("cancellationNumber select was changed to" + this.value);
                    if(this.value === "כן"){
                        console.log("Adding require to #cancelInsuranceCompany and #cancelPolicy" );
                        $("#cancelInsuranceCompany").prop('required',true);
                        $("#cancelPolicy").prop('required',true);
                    }else{
                        console.log("Removing require to #cancelInsuranceCompany and #cancelPolicy" );
                        $("#cancelInsuranceCompany").prop('required',false);
                        $("#cancelPolicy").prop('required',false);
                    }


                });
                jQuery("#back_to_form").click(function(){
                    console.log("back_to_form was called")
                    // jQuery('#back_form').removeClass('hide');
                    // jQuery('#button_block').hide();
                    window.history.back();
                });

                $("#main-form").submit(function () {
                    $("#date_alert").css("visibility", "hidden");
                    $("#num_alert").css("visibility","hidden");

                    // Check if the premia is greater than 0.

                    var num =  $("#sum_premia").val();
                    if ( num < 1) {
                        $("#num_alert").css("visibility","visible");
                        return false;
                    }

                    //check that the insurance start date starts from now
                    //to compare dates, format them for the same date type and reset the time.

                    var tempDate = $('#insurance_start_date').datepicker('getDate');
                    var newformattedDate = $.datepicker.formatDate('yy-mm-dd', tempDate);
                    var dateNow = Date.now();
                    dateNow = new Date(dateNow);
                    dateNow.setHours(0,0,0,0);
                    var formatStartDate = new Date(newformattedDate);
                    formatStartDate.setHours(0,0,0,0);
                    if (formatStartDate >= dateNow) {
                        $(this).find(':submit').val("הבקשה נשלחת...").attr( 'disabled','disabled' );
                        return true;
                    } else {
                        $("#date_alert").css("visibility", "visible");
                        return false;
                    }
                });

                /*jQuery("#submit").click(function () {
                    console.log("Disabling The Submit button");
                    this.val("הבקשה נשלחת...")
                        .attr('disabled', 'disabled');
                });*/
              /*  jQuery("#submit").click(function(){
                    var ddd= jQuery("#InputFile").val();
                    if(ddd==""){
                        jQuery('.error').show();
                        return false;
                    }
                    else{
                        console.log("I am in sub,it!!");
                        jQuery('.error').hide();
                        jQuery("#submit")
                            .val("הבקשה נשלחת...")
                            .attr('disabled', 'disabled');
                        $('form#main-form').submit();
                        return true;
                    }
                });*/

            });

        </script>
    </body>
</html>