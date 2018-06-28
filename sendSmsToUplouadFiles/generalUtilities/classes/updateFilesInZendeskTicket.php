<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/05/2018
 * Time: 00:59
 */
require '../vendor/autoload.php';

use Zendesk\API\HttpClient as ZendeskAPI;
include_once ('ezfindConnect.php');
include_once ('iBellConnect.php');
class updateFilesInZendeskTicket
{
    private $information;
    private $path = "logErrors.txt";

    public function __construct(){
        $this-> information = fopen($this->path, 'a');
        $this -> updateTicket();
    }
    public function updateTicket()
    {
        fwrite($this-> information,"start to update ticket ".$_POST['ticketId']."\n");
        $data = array();      // array to pass back data
        $arrayNameFiles = array();
        $arrayTmpNameFiles = array();
        $arrayTypeFiles = array();
        $ticketId = $_POST['ticketId'];
        $leadid = $_POST['recordNumber'];
        $campaignId = $_POST['campaignId'];
        $textFromCustomer = $_POST['textFromCustomer'];
        $crmAccountNumber = $_POST["crmAccountNumber"];
//          $supplierEmail = $_POST["userEmail"];
//          $supplierName = $_POST["userName"];
//          $leadName = $_POST["leadName"];
        switch ($campaignId){
            case 18679:
                $connect =  new ezfindConnect;
                break;
            default :
                $connect =  new iBellConnect;
        }
        $subDomain = $connect->getSubDomain();
        $userName =  $connect->getUserName();
        $token = $connect->getToken();
        $client = new ZendeskAPI($subDomain, $userName);
        $client->setAuth('basic', ['username' => $userName, 'token' => $token]);
            $LOGGER = fopen("log.txt", "a");
//    $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/files-upload/'.$leadid."/";
//    if (!file_exists($uploadDir)) {
//        $new_dir = mkdir ($uploadDir);
//        if (!$new_dir) {
//            $error = error_get_last();
//            echo $error['message'];
//        }
//    }
        fwrite($this-> information,"continue to update ticket ".$_POST['ticketId']."\n");
            /*save the file to the directory */
            foreach ($_FILES as $index => $fileName){
                $file = $_FILES[$index]["name"];
                array_push($arrayNameFiles, $file);
                $file = $_FILES[$index]["tmp_name"];
                array_push($arrayTmpNameFiles, $file);
                $file = $_FILES[$index]["type"];
                array_push($arrayTypeFiles, $file);
            }

            $extension_files = array();
            $new_name_files = array();
            $array_targets = array();
            $array_links = array();

            //to get the extension of the file.
            foreach ($arrayNameFiles as $index => $file_name) {
                $extension = pathinfo($file_name, PATHINFO_EXTENSION);
                array_push($extension_files, $extension);
            }

            //to define a new name for each file.
            foreach ($extension_files as $i => $extension_name) {
                $new_name = "upfile_doc_" . $leadid . "." . $i . "." . $extension_name;
                array_push($new_name_files, $new_name);
            }

            //send to new directory the files and save the new directory and types in arrays.
            foreach ($new_name_files as $i => $newname) {
                move_uploaded_file($arrayTmpNameFiles[$i], '../documentsFilesFromApp/' . $newname);
                $target = '../documentsFilesFromApp/' . $newname;
                array_push($array_targets, $target);
                $link = "https://portal.ibell.co.il/sendSmsToUplouadFiles/documentsFilesFromApp/". $newname;
                array_push($array_links, $link);
            };
            //save the uploaded file as zendesk attachment
            $upload_token = "";
            foreach ($arrayNameFiles as $i => $files) {
                $params = array(
                    'file' => $array_targets[$i],
                    'type' => $arrayTypeFiles[$i],
                    'name' => $arrayNameFiles[$i]
                );
                if (isset($upload_token)) {
                    $params['token'] = $upload_token;
                }
                $attachment = $client->attachments()->upload($params);
                $upload_token = $attachment->upload->token;
            }
             $client->tickets()->update($ticketId,[
                'collaborators' => "dina.r@ezfind.co.il",
                'status' => 'open',
                'comment' => [
                    'body' => "קבצים שנוספו באמצעות SMS:". " \n\n"."הודעה מהלקוח: ".$textFromCustomer,
                    'uploads'   => [$upload_token]
                ]

            ]);
            //send email
//        $to = $supplierEmail;
//        $subject = "קבצים שנשלחו מהלקוח";
//        $txt="";
//        $allLinks="";
//        foreach ($array_links as $i => $link) {
//            $link = $array_links[$i];
//            $allLinks .= $link." "." ";
//            ;}
//        $txt.= "הי "." ".$supplierName.", "."קישורים לקבצים שנשלחו מהלקוח:"." ".$leadName." ".$leadid.": ".$allLinks;
//        $headers = "From: ezfind@ezfind.co.il";
//        // "CC: somebodyelse@example.com";
//        mail($to, $subject, $txt, $headers);
//        fwrite($this-> information,"send email ".$_POST['ticketId']."\n");
        $data['success'] = true;
        $data['message'] = 'Success!';
        fwrite($this-> information,"continue2 to update ticket ".$_POST['ticketId']."\n");
        fwrite($this-> information,$data['message'] ." update ticket: ".$ticketId." of lead: ".$leadid." in date: ". date("d/m/Y")." time: ".date("h:i:sa")."\n");
        $updateFieldsKeyValue = [108957 => 'הבקשה_הושלמה_ע"י_הלקוח'];
        leadImUpdateLead($crmAccountNumber, $leadid, $updateFieldsKeyValue, true, $status = null);
        fwrite($this-> information," after send email ".$_POST['ticketId']."\n");
        echo "הקבצים נקלטו בהצלחה";
        }
}