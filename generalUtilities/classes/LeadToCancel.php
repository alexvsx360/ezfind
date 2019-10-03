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
    private $bitulCategory;
    private $bitulReason;
    private $firstPayment;
    private $policyLengthTime;
    private $sortingCancellLetters;
    private $cancelTypeDetails;
    private $moveToMokedShimur;
    private $saveInPast;
    private $handlingShimurAgent;
    private $lastRoutingDate;
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
        $this->setBitulCategory($leadJson['lead']['fields']['108936']);
        $this->setFirstPayment($leadJson['lead']['fields']['108939']);
        $this->setPolicyLengthTime($leadJson['lead']['fields']['108938']);
        $this->setBitulReason($leadJson['lead']['fields']['108937']);
        $this->setSortingCancellLetters($leadJson['lead']['fields']['109408']);
        $this->setLastRoutingDate($leadJson['lead']['fields']['130234']);
        $this->setHandlingShimurAgent($leadJson['lead']['fields']['130233']);
        $this->setSaveInPast($leadJson['lead']['fields']['125781']);
        $this->setMoveToMokedShimur($leadJson['lead']['fields']['111475']);
        $this->setCancelTypeDetails($leadJson['lead']['fields']['125778']);

    }


    /**
     * @return mixed
     */
    public function getCancelTypeDetails()
    {
        return $this->cancelTypeDetails;
    }

    /**
     * @param mixed $cancelTypeDetails
     */
    public function setCancelTypeDetails($cancelTypeDetails): void
    {
        $this->cancelTypeDetails = $cancelTypeDetails;
    }

    /**
     * @return mixed
     */
    public function getMoveToMokedShimur()
    {
        return $this->moveToMokedShimur;
    }

    /**
     * @param mixed $moveToMokedShimur
     */
    public function setMoveToMokedShimur($moveToMokedShimur): void
    {
        $this->moveToMokedShimur = $moveToMokedShimur;
    }

    /**
     * @return mixed
     */
    public function getSaveInPast()
    {
        return $this->saveInPast;
    }

    /**
     * @param mixed $saveInPast
     */
    public function setSaveInPast($saveInPast): void
    {
        $this->saveInPast = $saveInPast;
    }

    /**
     * @return mixed
     */
    public function getHandlingShimurAgent()
    {
        return $this->handlingShimurAgent;
    }

    /**
     * @param mixed $handlingShimurAgent
     */
    public function setHandlingShimurAgent($handlingShimurAgent): void
    {
        $this->handlingShimurAgent = $handlingShimurAgent;
    }

    /**
     * @return mixed
     */
    public function getLastRoutingDate()
    {
        return $this->lastRoutingDate;
    }

    /**
     * @param mixed $lastRoutingDate
     */
    public function setLastRoutingDate($lastRoutingDate): void
    {
        $this->lastRoutingDate = new DateTime();
        $this->lastRoutingDate->setTimestamp($lastRoutingDate);
    }
//BitulReason()

    public function getBitulReason()
    {
        return $this->bitulReason;
    }

    public function setBitulReason($bitulReason)
    {
        $this->bitulReason = $bitulReason;
    }
    //SortingCancellLetters()
    public function getSortingCancellLetters()
    {
        return $this->sortingCancellLetters;
    }

    public function setSortingCancellLetters($sortingCancellLetters)
    {
        $this->sortingCancellLetters = $sortingCancellLetters;
    }
    //setPolicyLengthTime()
    public function getPolicyLengthTime()
    {
        return $this->policyLengthTime;
    }

    public function setPolicyLengthTime($policyLengthTime)
    {
        $this->policyLengthTime = $policyLengthTime;
    }
    //firstPayment()
    public function getFirstPayment()
    {
        return $this->firstPayment;
    }

    public function setFirstPayment($firstPayment)
    {
        $this->firstPayment = $firstPayment;
    }
    //setBitulCategory()
    public function getBitulCategory()
    {
        return $this->bitulCategory;
    }

    public function setBitulCategory($bitulCategory)
    {
        $this->bitulCategory = $bitulCategory;
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

    public function setCancelType($cancelTypeArr)
    {
        $cancelTypeAsText = [];
        $types = [
            '103699' => "מכתב ביטול",
            '103700' => "מינוי סוכן",
            '112499' => "ביטול הרשאה לחויב",
            '114763' => "שומר בעבר"
        ];
        foreach ($cancelTypeArr as $cancelTypeNumField){
            $cancelType = $types[$cancelTypeNumField];
            array_push($cancelTypeAsText,$cancelType);
        }
        $cancelTypeToString = implode(";",$cancelTypeAsText);
        $this->cancelType = $cancelTypeToString;
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
            'cancelCategory' => $this-> getBitulCategory(),
            'firstPayment' => $this-> getFirstPayment(),
            'policyLengthTime' => $this-> getPolicyLengthTime(),
            'cancelReason' => $this-> getBitulReason(),
            'sortingCancellLetters' =>$this->getSortingCancellLetters(),
            'salesMan' => $this->getSalesMan(),
            'lastRoutingDate' => $this->getLastRoutingDate()->format(DateTime::ISO8601),
            'handlingShimurAgent' => $this->getHandlingShimurAgent(),
            'saveInPast' => $this->getSaveInPast(),
            'moveToMokedShimur' => $this->getMoveToMokedShimur(),
            'cancelTypeDetails' => $this->getCancelTypeDetails(),
            'reference' => $this->getRecordId(),
        ];
    }
}