<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/04/2018
 * Time: 10:35
 */
include_once 'BaseLead.php';
include_once 'LeadShimur.php';
class LeadPolicy extends BaseLead
{
    private $customerSsnIssueDate;
    private $customerBirthDate;
    private $customerGender;
    private $customerMaridgeStatus;
    private $customerAddress;
    private $policy;
    private $DateCompletPanding;
    private $dateSendToinsuranceCompany;
    private $ticketStatus;
    private $leadJson;

    function __construct($leadJson)
    {
        parent::__construct($leadJson);
        $this->setCustomerSsnIssueDate($leadJson['lead']['fields']['102157']);
        $this->setCustomerBirthDate($leadJson['lead']['fields']['102093']);
        $this->setCustomerGender($leadJson['lead']['fields']['102094']);
        $this->setCustomerMaridgeStatus($leadJson['lead']['fields']['102097']);
        $this->setCustomerAddress($leadJson['lead']['fields']['102103']);
        $this->setDateCompletPanding($leadJson['lead']['fields']['106545']);
        $this->setDateSendToinsuranceCompany($leadJson['lead']['fields']['106546']);
        $this->setTicketStatus($leadJson['lead']['fields']['107639']);
        $this->policy = new Policy($leadJson['lead']['fields']);
        $this->leadJson = $leadJson;

    }
    /**
     * @return mixed
     */
    public function getCustomerSsnIssueDate()
    {
        return $this->customerSsnIssueDate;
    }

    /**
     * @param mixed $customerSsnIssueDate
     */
    public function setCustomerSsnIssueDate($customerSsnIssueDate)
    {
        $this->customerSsnIssueDate = new DateTime();
        $this->customerSsnIssueDate->setTimestamp($customerSsnIssueDate);
    }
    /**
     * @return mixed
     */
    public function getCustomerBirthDate()
    {
        return $this->customerBirthDate;
    }

    /**
     * @param mixed $customerBirthDate
     */
    public function setCustomerBirthDate($customerBirthDate)
    {
        $this->customerBirthDate = new DateTime();
        $this->customerBirthDate->setTimestamp($customerBirthDate);
    }

    /**
     * @return mixed
     */
    public function getCustomerGender()
    {
        return $this->customerGender;
    }

    /**
     * @param mixed $customerGender
     */
    public function setCustomerGender($customerGender)
    {
        $types = [
            '102095' => "זכר",
            '102096' => 'נקבה'
        ];
        $this->customerGender = $types[$customerGender];
    }

    /**
     * @return mixed
     */
    public function getCustomerMaridgeStatus()
    {
        return $this->customerMaridgeStatus;
    }

    /**
     * @param mixed $customerMaridgeStatus
     */
    public function setCustomerMaridgeStatus($customerMaridgeStatus)
    {
        $types = [
            '102098' => 'רווק',
            '102099' => 'נשוי',
            '102100' => 'גרוש',
            '102101' => 'אלמן',
            '102102' => 'אחר',
        ];
        $this->customerMaridgeStatus = $types[$customerMaridgeStatus];
    }

    /**
     * @return mixed
     */
    public function getCustomerAddress()
    {
        return $this->customerAddress;
    }

    /**
     * @param mixed $customerAddress
     */
    public function setCustomerAddress($customerAddress)
    {
        $this->customerAddress = $customerAddress;
    }

    /**
     * @return mixed
     */
    public function getPolicy()
    {
        return $this->policy;
    }

    /**
     * @param mixed $policy
     */
    public function setPolicy($policy)
    {
        $this->policy = $policy;
    }
    /**
     * @return mixed
     */
    public function getDateSendToinsuranceCompany()
    {
        return $this->dateSendToinsuranceCompany;
    }

    /**
     * @param mixed $dateSendToinsuranceCompany
     */
    public function setDateSendToinsuranceCompany($dateSendToinsuranceCompany)
    {
if ($dateSendToinsuranceCompany!=="0"){
    $this->dateSendToinsuranceCompany = new DateTime();
    $this->dateSendToinsuranceCompany->setTimestamp($dateSendToinsuranceCompany);
    $this->dateSendToinsuranceCompany->modify('+1 hour');
}else {
    $this->dateSendToinsuranceCompany = "";
}

    }
    /**
     * @return mixed
     */
    public function getDateCompletPanding()
    {
        return $this->DateCompletPanding;
    }

    /**
     * @param mixed $DateCompletPanding
     */
    public function setDateCompletPanding($DateCompletPanding)
    {
        if ($DateCompletPanding!=="0"){
            $this->DateCompletPanding = new DateTime();
            $this->DateCompletPanding->setTimestamp($DateCompletPanding);
            $this->DateCompletPanding->modify('+1 hour');
        }else {
            $this->DateCompletPanding = "";
        }
    }

    /**
     * @return mixed
     */
    public function getTicketStatus()
    {
        return $this->ticketStatus;
    }

    /**
     * @param mixed $policy
     */
    public function setTicketStatus($ticketStatus)
    {
        $this->ticketStatus = $ticketStatus;
    }
    public function generateUpdatePolicyPostData() {
        $leadJsonArray =$this->leadJson;
        $laedShimur = new LeadShimur($leadJsonArray);
        $premiaAferShimur =  $laedShimur->getPremiaAferShimur();
        if($premiaAferShimur!= ""){
            return [[
                'date' =>  $this->getCreateDate()->format(DateTime::ISO8601), // Updated ISO8601,
                'data_source' => '610a2983898a41d299700b16cebd0987',//Insurance policies
                'member_api_provider' => 'Lead Im CRM',
                'member_api_id' => $this->getSupplierId(),
                'member_name' => "supplier_" . $this->getSupplierId(),
                'callCenterName' => $this->getCallCenterName(),
                'sellingChannel' => $this->policy->getSellingChannel(),
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
            ],
                $laedShimur->generateShimurPolicyPostData(),
            ];

        }else{
            return [
                'date' =>  $this->getCreateDate()->format(DateTime::ISO8601), // Updated ISO8601,
                'data_source' => '610a2983898a41d299700b16cebd0987',//Insurance policies
                'member_api_provider' => 'Lead Im CRM',
                'member_api_id' => $this->getSupplierId(),
                'member_name' => "supplier_" . $this->getSupplierId(),
                'callCenterName' => $this->getCallCenterName(),
                'sellingChannel' => $this->policy->getSellingChannel(),
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
    }

}


