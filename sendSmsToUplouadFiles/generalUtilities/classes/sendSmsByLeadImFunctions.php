<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29/05/2018
 * Time: 22:30
 */
include ('leadImFunctions.php');

class sendSmsByLeadImFunctions
{
 public $file;
 private $crmAccountNumber;
 private $campaignId;
 private $leadId;
 private $smsTemplateId ;

    public function __construct($ticketId,$campaignId,$leadId,$crmAccountNumber)
    {
        $this -> crmAccountNumber = $crmAccountNumber;
        $this -> campaignId = $campaignId;
        $this -> leadId = $leadId;
        $this -> setSmsTemplateId($campaignId);
        $this -> sendSms();
       // $this -> file= (fopen("sendSSmsLog.txt", "a"));

    }

    public function setSmsTemplateId($campaignId)
    {
      switch ($campaignId){
        case 18679://muzarey zmicha
            $this -> smsTemplateId = 107976;
            break;
        default:
            $this -> smsTemplateId = 107976;
      }

    }

    public function sendSms()
    {
        $userId = 14427;
        $responseSms = leadImSendSMS($this->crmAccountNumber,$this->leadId,$this->smsTemplateId, $userId);
       // echo "sms not sent";
       if ($responseSms["status"]=="success"){
           $updateFieldsKeyValue = [108957 => "הבקשה_נשלחה"];
           leadImUpdateLead($this -> crmAccountNumber, $this->leadId, $updateFieldsKeyValue, true, $status = null);
           // fwrite($this->file,"  SMS sent to customer : " .  $this->leadId."\n");
            echo "sms sent successfully";
        }else{
         //  fwrite($this->file,"  SMS not sent to customer : " .  $this->leadId."\n");
           $updateFieldsKeyValue = [108957 => "הבקשה_לא_נשלחה"];
           leadImUpdateLead($this -> crmAccountNumber, $this->leadId, $updateFieldsKeyValue, true, $status = null);
            echo "sms not sent";
        }
    }
}



