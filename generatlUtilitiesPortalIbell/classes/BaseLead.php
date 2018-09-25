<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/04/2018
 * Time: 10:21
 */
include_once ('../leadImFunctions.php');
abstract class BaseLead
{
    private $recordId;
    private $channelName;
    private $createDate;
    private $status;
    private $supplierId;
    private $customerName;
    private $customerPhone;
    private $customerSsn;
    private $customerEmail;
    private $callCenterName;

    function __construct($leadJson)
    {
        $this->setRecordId($leadJson['lead']['lead_id']);
        $this->setChannelName($leadJson['lead']['channel_name']);
        $this->setCreateDate($leadJson['lead']['datetime']);
        $this->setStatus($leadJson['lead']['status']);
        $this->setSupplierId($leadJson['lead']['supplier_id']);
        $this->setCustomerName($leadJson['lead']['fields']['100086']);
        $this->setCustomerPhone($leadJson['lead']['fields']['100090']);
        $this->setCustomerSsn($leadJson['lead']['fields']['102092']);
        $this->setCustomerEmail($leadJson['lead']['fields']['100091']);
        $this->setCallCenterName($leadJson['lead']['fields']['100098']);
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

    public abstract function generateUpdatePolicyPostData();

    public static function generateDeletePolicyPostData($recordId, $agentId, $recordDate,$dataSource){
        return [
            'date' => $recordDate->format(DateTime::ISO8601),
            'data_source' => $dataSource,
            'member_api_provider' => 'Lead Im CRM',
            'member_api_id' => $agentId,
            'member_name' => "supplier_" . $agentId,
            'recordStatus' => "canceled",
            'reference' => $recordId,
        ];

    }



}