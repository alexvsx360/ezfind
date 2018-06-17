<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/04/2018
 * Time: 10:36
 */
include_once 'BaseLead.php';
class LeadToCancel extends BaseLead
{
    private $cancelDate;
    private $cancelType;
    private $cancelTicketNumber;
    private $cancelLink;
    private $cancelMonthlyPremia;
    private $cancelAnnualPremia;
    private $cancelInsurenceCompany;
    private $cancelPolicyType;
    private $salesMan;
    private $linkToCustomer;
    private $payWith;


    function __construct($leadJson)
    {
        parent::__construct($leadJson);
        $this->setCancelDate($leadJson['lead']['fields']['103693']);
        $this->setCancelType($leadJson['lead']['fields']['103698']);
        $this->setCancelTicketNumber($leadJson['lead']['fields']['103694']);
        $this->setCancelLink($leadJson['lead']['fields']['103695']);
        $this->setCancelMonthlyPremia($leadJson['lead']['fields']['103696']);
        $this->setCancelAnnualPremia($leadJson['lead']['fields']['103697']);
        $this->setCancelInsurenceCompany($leadJson['lead']['fields']['103708']);
        $this->setCancelPolicyType($leadJson['lead']['fields']['103701']);
        $this->setSalesMan($leadJson['lead']['fields']['103714']);
        $this->setLinkToCustomer($leadJson['lead']['fields']['103646']);
        $this->setPayWith($leadJson['lead']['fields']['106839']);

    }

    //getPayWith()
    public function getPayWith()
    {
        return $this->payWith;
    }

    public function setPayWith($payWith)
    {
        $this->payWith = $payWith;
    }
    //CancelDate
    public function getCancelDate()
    {
        return $this->cancelDate;
    }

    public function setCancelDate($cancelDate)
    {
        $this->cancelDate = new DateTime();
        $this->cancelDate->setTimestamp($cancelDate);

    }

    //cancelType
    public function getCancelType()
    {
        return $this->cancelType;
    }

    public function setCancelType($cancelType)
    {
        $types = [
            '103699' => "מכתב ביטול",
            '103700' => "מינוי סוכן",


        ];
        $this->cancelType = $types[$cancelType];
    }

    //cancelTicketNumber
    public function getCancelTicketNumber()
    {
        return $this->cancelTicketNumber;
    }

    public function setCancelTicketNumber($cancelTicketNumber)
    {
        $this->cancelTicketNumber = $cancelTicketNumber;
    }

    //cancelLink
    public function getCancelLink()
    {
        return $this->cancelLink;
    }

    public function setCancelLink($cancelLink)
    {
        $this->cancelLink = $cancelLink;
    }

    //cancelMonthlyPremia
    public function getCancelMonthlyPremia()
    {
        return $this->cancelMonthlyPremia;
    }

    public function setCancelMonthlyPremia($cancelMonthlyPremia)
    {
        $this->cancelMonthlyPremia = $cancelMonthlyPremia;
    }

    //cancelMonthlyPremia
    public function getCancelAnnualPremia()
    {
        return $this->cancelAnnualPremia;
    }

    public function setCancelAnnualPremia($cancelAnnualPremia)
    {
        $this->cancelAnnualPremia = $cancelAnnualPremia;
    }

    //cancelInsurenceCompany
    public function getCancelInsurenceCompany()
    {
        return $this->cancelInsurenceCompany;
    }

    public function setCancelInsurenceCompany($cancelInsurenceCompany)
    {
        $types = [
            '103712' => "כלל",
            '103710' => "הראל",
            '103711' => "איילון",
            '103709' => "הכשרה",
            '103713' => "הפניקס"
        ];
        $this->cancelInsurenceCompany = $types[$cancelInsurenceCompany];
    }

    //cancelPolicyType
    public function getCancelPolicyType()
    {

        return $this->cancelPolicyType;
    }

    public function setCancelPolicyType($cancelPolicyType)
    {
        $types = [
            '103702' => ",תאונות אישיות",
            '103703' => "בריאות",
            '103704' => "חיים",
            '103705' => "ביטוח משכנתא",
            '103706' => "סיעודי",
            '103707' => "מחלות קשות",
            '103715' => "אובדן כושר עבודה"
        ];
        $this->cancelPolicyType = $types[$cancelPolicyType];
    }

    //salesMan
    public function getSalesMan()
    {
        return $this->salesMan;
    }

    public function setSalesMan($salesMan)
    {
        $this->salesMan = $salesMan;
    }

    //linkToCustomer
    public function getLinkToCustomer()
    {
        return $this->salesMan;
    }

    public function setLinkToCustomer($linkToCustomer)
    {
        $this->linkToCustomer = $linkToCustomer;
    }

    public function generateUpdatePolicyPostData() {
        return [
            'date' =>  $this->getCreateDate()->format(DateTime::ISO8601), // Updated ISO8601,
            'data_source' => '87c813ef9f41418282d6e77ab982ee1d',
            'member_api_provider' => 'Lead Im CRM',
            'member_api_id' => ($this->getSupplierId()=="0")?"15348":$this->getSupplierId(),
            'member_name' =>($this->getSupplierId()=="0"? "בקשה לביטול איש מכירות עזב" : "supplier_" . $this->getSupplierId()),
            'callCenterName' => $this->getCallCenterName(),
            'callCenterName' => $this->getCallCenterName(),
            'status' => $this->getStatus(),
            'cancelDate' => $this->getCancelDate()->format(DateTime::ISO8601),
            'cancelType' => $this->getCancelType(),
            'cancelTicketNumber' => $this->getCancelTicketNumber(),
            'cancelLink' => $this->getCancelLink(),
            'cancelMonthlyPremia' => $this->getCancelMonthlyPremia(),
            'annualPremia' =>$this->getCancelAnnualPremia(),
            'cancelInsurenceCompany' => $this->getCancelInsurenceCompany(),
            'cancelPolicyType' => $this->getCancelPolicyType(),
            'payWith' => $this-> getPayWith(),
            'salesMan' => $this->getSalesMan(),
            'reference' => $this->getRecordId(),
        ];
    }
}