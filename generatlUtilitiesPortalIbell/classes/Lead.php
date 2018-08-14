<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 1/8/2018
 * Time: 11:05 AM
 */

include_once ('Policy.php');
include_once ('../leadImFunctions.php');

class Lead {
    private $recordId;
    private $channelName;
    private $createDate;
    private $status;
    private $supplierId;
    private $customerName;
    private $customerPhone;
    private $customerSsn;
    private $customerSsnIssueDate;
    private $customerEmail;
    private $customerBirthDate;
    private $customerGender;
    private $customerMaridgeStatus;
    private $customerAddress;
    private $callCenterName;
    private $policy;

    function __construct($leadJson) {
        $this->setRecordId($leadJson['lead']['lead_id']);
        $this->setChannelName($leadJson['lead']['channel_name']);
        $this->setCreateDate($leadJson['lead']['datetime']);
        $this->setStatus($leadJson['lead']['status']);
        $this->setSupplierId($leadJson['lead']['supplier_id']);
        $this->setCustomerName($leadJson['lead']['fields']['100086']);
        $this->setCustomerPhone($leadJson['lead']['fields']['100090']);
        $this->setCustomerSsn($leadJson['lead']['fields']['102092']);
        $this->setCustomerSsnIssueDate($leadJson['lead']['fields']['102157']);
        $this->setCustomerEmail($leadJson['lead']['fields']['100091']);
        $this->setCustomerBirthDate($leadJson['lead']['fields']['102093']);
        $this->setCustomerGender($leadJson['lead']['fields']['102094']);
        $this->setCustomerMaridgeStatus($leadJson['lead']['fields']['102097']);
        $this->setCustomerAddress($leadJson['lead']['fields']['102103']);
        $this->setCallCenterName($leadJson['lead']['fields']['100098']);
        $this->policy = new Policy($leadJson['lead']['fields']);




    }

    /**
     * @return mixed
     */
    public function getRecordId()
    {
        return $this->recordId;
    }

    /**
     * @param mixed $recordId
     */
    public function setRecordId($recordId)
    {
        $this->recordId = $recordId;
    }

    /**
     * @return mixed
     */
    public function getChannelName()
    {
        return $this->channelName;
    }

    /**
     * @param mixed $channelName
     */
    public function setChannelName($channelName)
    {
        $this->channelName = $channelName;
    }

    /**
     * @return mixed
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @param mixed $createDate
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = new DateTime();
        $this->createDate->setTimestamp($createDate);
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = getStatusAsString($status);
    }

    /**
     * @return mixed
     */
    public function getSupplierId()
    {
        return $this->supplierId;
    }

    /**
     * @param mixed $supplierId
     */
    public function setSupplierId($supplierId)
    {
        $this->supplierId = $supplierId;
    }

    /**
     * @return mixed
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * @param mixed $customerName
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;
    }

    /**
     * @return mixed
     */
    public function getCustomerPhone()
    {
        return $this->customerPhone;
    }

    /**
     * @param mixed $customerPhone
     */
    public function setCustomerPhone($customerPhone)
    {
        $this->customerPhone = $customerPhone;
    }

    /**
     * @return mixed
     */
    public function getCustomerSsn()
    {
        return $this->customerSsn;
    }

    /**
     * @param mixed $customerSsn
     */
    public function setCustomerSsn($customerSsn)
    {
        $this->customerSsn = $customerSsn;
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
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * @param mixed $customerEmail
     */
    public function setCustomerEmail($customerEmail)
    {
        $this->customerEmail = $customerEmail;
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
    public function getCallCenterName()
    {
        return $this->callCenterName;
    }

    /**
     * @param mixed $callCenterName
     */
    public function setCallCenterName($callCenterName)
    {
        $this->callCenterName = $callCenterName;
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

    public function generateUpdatePolicyPostData() {
        return [
            'date' =>  $this->getCreateDate()->format(DateTime::ISO8601), // Updated ISO8601,
            'data_source' => '610a2983898a41d299700b16cebd0987',
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
            'recordStatus' => "",
            'reference' => $this->getRecordId(),

        ];

    }

    public static function  generateDeletePolicyPostData($recordId, $agentId, $recordDate){
        return [
            'date' => $recordDate->format(DateTime::ISO8601),
            'data_source' => '610a2983898a41d299700b16cebd0987',
            'member_api_provider' => 'Lead Im CRM',
            'member_api_id' => $agentId,
            'member_name' => "supplier_" . $agentId,
            'recordStatus' => "canceled",
            'reference' => $recordId,
        ];
    }

}

