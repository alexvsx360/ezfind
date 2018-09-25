<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 05/07/2018
 * Time: 11:39
 */
include_once 'BaseLead.php';
include_once "../../plecto/leads.php";
class LeadInMarechetAm extends BaseLead
{
    private $campainName;
    private $leadCallCenterSuplaier;
    private $leadIncorrectStatus;
    function __construct($leadJson)
    {
        parent::__construct($leadJson);
        $this->setCampainName($leadJson['lead']['campaign_id']);
        $this->setLeadCallCenterSuplaier();
        $this->setLeadIncorrectStatus(['lead']['fields']['']);

        $this->policy = new Policy($leadJson['lead']['fields']);
    }
    public function generateUpdatePolicyPostData() {
        return [

            'date' =>  $this->getCreateDate()->format(DateTime::ISO8601), // Updated ISO8601,
            'data_source' => 'd099be653ff54800bcfbe107ccee1159',//Insurance policies
            'member_api_provider' => 'Lead Im CRM',
            'member_api_id' => $this->getSupplierId(),
            'member_name' => "supplier_" . $this->getSupplierId(),
            'leadChannel' => $this->policy->getSellingChannel(),
            'leadSuplaier'=> "supplier_" . $this->getSupplierId(),
           //todo function with config 'campainName' => $_GET['campaign_id'],
            'leadCallCenterSuplaier'=>getLeadCallCenterSuplaier($this->campainName),
            'leadIncorrectStatus' => $_GET['incorrectLeadStatus'],
            'reference' => $this->getRecordId(),



        'callCenterName' => $this->getCallCenterName(),

            'saleDate' => $this->policy->getSaleDate()->format(DateTime::ISO8601), // Updated ISO8601,
            'sellerName' => $this->policy->getSellerName(),
            'promoterName' => $this->policy->getPromoterName(),
            'insuranceType' => $this->policy->getPolicyType(),
            'insuranceCompany' => $this->policy->getInsuranceCompany(),
            'monthlyPremia' => $this->policy->getMonthlyPremia(),
            'anualPremia' => $this->policy->getAnnualPremia(),
            'hitum' => $this->policy->getHitum(),
            'productionStatus' => $this->getStatus(),
            'productionDate' => $this->policy->getProductionDate()->format(DateTime::ISO8601),
            'pendingStatus' => $this->policy->getPendingStatus(),
            'sentToInsuranceCompanyDate' => ($this->getDateSendToinsuranceCompany()!=="")? $this->getDateSendToinsuranceCompany()->format(DateTime::ISO8601): "",
            'completPandingDate' =>  ($this->getDateCompletPanding()!=="")? $this->getDateCompletPanding()->format(DateTime::ISO8601): "",
            'recordStatus' => "",
            'reference' => $this->getRecordId(),
            'ticketStatus' => $this->getTicketStatus()

];
    }

//$date = $_GET['date'];
//$date = str_replace("/","-", $date);
//
//$datetime = new DateTime($date);
//
//$leadPostDate = [
//'date' => $datetime->format(DateTime::ISO8601), // Updated ISO8601,
//'data_source' => 'd099be653ff54800bcfbe107ccee1159',
//'member_api_provider' => 'leadsProxy',
//'member_api_id' => ($_GET['suplaierId'] == "" ? "1234" : $_GET['suplaierId']),
//'member_name' => ($_GET['suplaier'] == "" ? "Leads Proxy" : $_GET['suplaier']),
//'leadChannel' => getChannelName($_GET['channelName']),
//'leadSuplaier' => getLeadSuplaier(),
//'campainName' => $_GET['campainName'],
//'leadCallCenterSuplaier' => getLeadCallCenterSuplaier($_GET['campainName']),
//'leadIncorrectStatus' => $_GET['incorrectLeadStatus'],
//'reference' => $_GET['leadId'],
//
//];

}