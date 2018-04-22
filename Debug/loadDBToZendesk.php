<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/9/2017
 * Time: 7:54 PM
 */

$actions = [
    "משיכה " => "פדיון",
    "צמצום " => "ניוד",
];
$statuses = [
    "לא יודע " => "בקשות_חדשות",
    "ממתין להשלמת חוסרים " => "ממתין_למסמכים_מהלקוח",
    "ממתין לשליחה  " => "בקשות_חדשות",
    "רגדקט " => "ריגקט_מחברת_הביטוח",
];


/*Read the CSV file*/
$array = $fields = array(); $i = 0;
$handle = @fopen("C:\\Users\\User\\Desktop\\tmp\\db.xls.csv", "r");
if ($handle) {
    while (($row = fgetcsv($handle, 4096)) !== false) {
        if (empty($fields)) {
            $fields = $row;
            continue;
        }
        foreach ($row as $k=>$value) {
            $array[$i][$fields[$k]] = $value;
        }
        $i++;
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}

foreach ($array as $line){
    if ($line["STATUS"] !== "הסתיים טיפול "){

        $name = $line["NAME"];
        $ssn = $line["SSN"];
        $phone = $line["PHONE"];
        $email= $line["EMAIL"];
        $oldTicketNumber = $line["TICKET NUMBER"];
        $openingDate = $line["OPENING DATE"];
        $sendingDate = $line["SENDING DATE"];
        $insuranceCompany = $line["INSURANCE COMPANY"];
        $status = $line["STATUS"];
        $action = $line["ACTION"];
        $comments = $line["הערות על התיקט"];

        'r0sQ2m9H37u6OOnmYagEM08cW11xKasCbNZspYaF';


        $ticketUrl = "https://ezfind-sherut.zendesk.com/api/v2/tickets.json";
        $data = '';
        $data->subject = $name . ' ' . $ssn . ' ' . $actions[$action] . ' ' . $insuranceCompany ;
        $data->custom_fields = array(
            '114102615353' => $actions[$action],                                          //מסלול חיתום
            '114102602254' =>   $insuranceCompany,                 // מוקד ביטוח
            '114102602194' =>  date("Y-m-d", strtotime($sendingDate)),                                                      //כיסוי ביטוחי
            '114102601974' => $name,                                // חברת ביטוח
            '114102615293' => $phone,                                          //פרמיה
            '114102602134' => $ssn  ,                               // האם יש מכתב ביטול?
            '114102615313' => $email,                                                //תאריך תחילת ביטוח
            '114102615553' => $statuses[$status]
        );
        $data->requester = array(
            'email' => "some@email.com",
            'name' => "API"
        );
        /*
        $data->collaborators = getCollaboratorArrayById($crmAccount, $userEmail); */
        $data->comment = array(
            'body' =>   'שם מלא: ' .$name . " \n" .
                'תעודת זהות: ' . $ssn. " \n" .
                'מספר נייד: ' . $phone . " \n" .
                'אימייל של הלקוח: ' . $email . "n\n\n\n\n\n" .
                'מספר טיקט ישן: ' . $oldTicketNumber . " \n" .
                'תאריך פתיחת הטיקט המקורי : ' . $openingDate . " \n" .
                'תאריך שליחה לחברת הביטוח מההטיקט המקורי : ' . $sendingDate . " \n" .
                'סטטוס בעת ייבוא : ' . $status . " \n" .
                'חברת ביטוח : ' . $insuranceCompany . " \n" .
                'פעולה לביצוע : ' . $action . " \n" .
                'הערות מהאקסל : ' . $comments . " \n" .
                'לינק לטיקט המקורי : ' . 'https://ezfind.zendesk.com/agent/tickets/' . $oldTicketNumber . " \n\n"
        );


        /*API to Zendesk to open the ticket*/
        $create = json_encode(array('ticket' => $data)/*, JSON_UNESCAPED_UNICODE*/);
        //fwrite($myfile, "return value from Zendesk API is " . print_r($create, true));

        $username = 'yaki@tgeg.co.il/token';
        $password = 'r0sQ2m9H37u6OOnmYagEM08cW11xKasCbNZspYaF';

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
    }









}


print $array;