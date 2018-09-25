<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/04/2018
 * Time: 12:24
 */
include_once 'BaseLead.php';
class LeadMislakaPensyonit extends BaseLead
{
    private $customerAddress;
    private $customerSsnIssueDate;
    private $ticketNumber;
    private $zendeskLink;
    private $sellingChannel;
    private $sellerName;
    private $paymentSum;
    private $mislakaPaymentCount;
    private $customerCount;
    private $customerType;

    function __construct($leadJson)
    {
        parent::__construct($leadJson);
        $this->setCustomerAddress($leadJson['lead']['fields']['102103']);
        $this->setCustomerSsnIssueDate($leadJson['lead']['fields']['102157']);
        $this->setTicketNumber($leadJson['lead']['fields']['102158']);
        $this->setZendeskLink($leadJson['lead']['fields']['102132']);
        $this->setSellingChannel($leadJson['lead']['fields']['102131']);
        $this->setSellerName($leadJson['lead']['fields']['100099']);
        $this->setPaymentSum($leadJson['lead']['fields']['104006']);
        $this->setMislakaPaymentCount($leadJson['lead']['fields']['104007']);
        $this->setCustomerCount($leadJson['lead']['fields']['104011']);
        $this->setCustomerType($leadJson['lead']['fields']['104008']);

    }
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
    public function getTicketNumber()
    {
        return $this->ticketNumber;
    }

    /**
     * @param mixed $ticketNumber
     */
    public function setTicketNumber($ticketNumber)
    {
        $this->ticketNumber = $ticketNumber;
    }
    /**
     * @return mixed
     */
    public function getZendeskLink()
    {
        return $this->zendeskLink;
    }

    /**
     * @param mixed $zendeskLink
     */
    public function setZendeskLink($zendeskLink)
    {
        $this->zendeskLink = $zendeskLink;
    }
    /**
     * @return mixed
     */
    public function getSellerName()
    {
        return $this->sellerName;
    }

    /**
     * @param mixed $sellerName
     */
    public function setSellerName($sellerName)
    {
        $this->sellerName = $sellerName;
    }
    /**
     * @return mixed
     */
    public function getSellingChannel()
    {
        return $this->sellingChannel;
    }

    /**
     * @param mixed $sellingChannel
     */
    public function setSellingChannel($sellingChannel)
    {
        $this->sellingChannel = $sellingChannel;
    }
    /**
     * @return mixed
     */
    public function getPaymentSum()
    {
        return $this->paymentSum;
    }

    /**
     * @param mixed $sellingChannel
     */
    public function setPaymentSum($paymentSum)
    {
        $this->paymentSum = $paymentSum;
    }
        /**
         * @return mixed
         */
        public function getMislakaPaymentCount()
    {
        return $this->mislakaPaymentCount;
    }

        /**
         * @param mixed $mislakaPaymentCount
         */
        public function setMislakaPaymentCount($mislakaPaymentCount)
    {
        $this->mislakaPaymentCount = $mislakaPaymentCount;
    }
    /**
     * @return mixed
     */
    public function getCustomerCount()
    {
        return $this->customerCount;
    }

    /**
     * @param mixed $customerCount
     */
    public function setCustomerCount($customerCount)
    {
        $this->customerCount = $customerCount;
    }
    /**
     * @return mixed
     */
    public function getCustomerType()
    {
        return $this->customerType;
    }

    /**
     * @param mixed $customerCount
     */
    public function setCustomerType($customerType)
    {
        $types = [
        '104009' => "יחיד",
        '104010' => 'זוגי'
    ];

        $this->customerType =$types[$customerType];
    }
    public function generateUpdatePolicyPostData() {
        return [
            'date' =>  $this->getCreateDate()->format(DateTime::ISO8601), // Updated ISO8601,
            'data_source' => 'c19a89078ccf4c89b5603277b54eb7c7',
            'member_api_provider' => 'Lead Im CRM',
            'member_api_id' => $this->getSupplierId(),
            'member_name' => "supplier_" . $this->getSupplierId(),
            'callCenterName' => $this->getCallCenterName(),
            'sellingChannl' => $this->getSellingChannel(),
            'sellerName' => $this->getSellerName(),
            'paymentSum' => $this->getPaymentSum(),
            'paymentCount' => $this->getMislakaPaymentCount(),
            'customerCount' => $this->getCustomerCount(),
            'CustomerType' => $this->getCustomerType(),
            'reference' => $this->getRecordId(),
        ];

    }
}

