<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15/04/2018
 * Time: 11:04
 */
include_once 'BaseLead.php';
abstract class BaseLeadMuzareyZmicha extends BaseLead
{
    private $productName;
    private $paymentSum;
    private $mislakaPaymentCount;
    private $sellerName;
    private $policyType;
    private $ticketStatus;


    function __construct($leadJson)
    {
        parent::__construct($leadJson);
        $this->setProductName($leadJson['lead']['channel_name']);
        $this->setPaymentSum($leadJson['lead']['fields']['104006']);
        $this->setMislakaPaymentCount($leadJson['lead']['fields']['104007']);
        $this->setSellerName($leadJson['lead']['fields']['100099']);
        $this->setPolicyType($leadJson['lead']['fields']['105715']);
        $this->setTicketStatus($leadJson['lead']['fields']['104484']);

    }
    /**
     * @return mixed
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * @param mixed $productName
     */
    public function setProductName($productName)
    {
        $this->productName=$productName;
    }

    /**
     * @return mixed
     */
    public function getPaymentSum()
    {
        return $this->paymentSum;
    }

    /**
     * @param mixed $paymentSum
     */
    public function setPaymentSum($paymentSum)
    {
        $this->paymentSum=$paymentSum;
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
        $this->mislakaPaymentCount=$mislakaPaymentCount;
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
        $this-> sellerName = $sellerName;
    }
    /**
     * @return mixed
     */
    public function getPolicyType()
    {
        return $this->policyType;
    }

    /**
     * @param mixed $sellerPolicyType
     */
    public function setPolicyType($policyType)
    {
        $this-> policyType = $policyType;
    }
    /**
     * @return mixed
     */
    public function getTicketStatus()
    {
        return $this->ticketStatus;
    }

    /**
     * @param mixed $StatusTicket
     */
    public function setTicketStatus($ticketStatus)
    {
        $this->ticketStatus = $ticketStatus;
    }
  public function generateUpdatePolicyPostData()
  {
      return [
          'date' =>  $this->getCreateDate()->format(DateTime::ISO8601), // Updated ISO8601,
          'data_source' => 'd9f8ce743a3540b09da09c3aa5882ea2',
          'member_api_provider' => 'Lead Im CRM',
          'member_api_id' => $this->getSupplierId(),
          'member_name' => "supplier_" . $this->getSupplierId(),
          'productName' =>$this->getProductName(),
          'callCenterName' =>$this->getCallCenterName(),
          'sellerName' => $this->getSellerName(),
          'paymentSum' => $this->getPaymentSum(),
          'mislakaPaymentCount' => $this->getMislakaPaymentCount(),
          'policyType'=>$this->getPolicyType(),
          'ticketStatus' => $this->getTicketStatus(),
          'reference' => $this->getRecordId(),
      ];
  }

}
