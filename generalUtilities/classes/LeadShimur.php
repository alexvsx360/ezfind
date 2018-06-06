<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 05/06/2018
 * Time: 21:32
 */
include_once ('Policy.php');
include_once ('../leadImFunctions.php');
include_once 'BaseLead.php';
class LeadShimur extends BaseLead
{

    public $configTypes;
  //  private $recordId;
   // private $channelName;
    private $createDate;
  //  private $status;
  //  private $supplierId;
    private $dateOfCancel;
    private $dateOfShimur;
    private $sellerNameMeshamer;
    private $premiaAferShimur;
//    private $customerPhone;
//    private $customerSsn;
//    private $customerEmail;
   private $callCenterName;

    function __construct($leadJson)
    {
        $this->configTypes = include('configTypes.php');
        $this->setRecordId($leadJson['lead']['lead_id']);
     //   $this->setChannelName($leadJson['lead']['channel_name']);
        $this->setCreateDate($leadJson['lead']['datetime']);
       // $this->setStatus($leadJson['lead']['status']);
        $this->setSupplierId($leadJson['lead']['supplier_id']);
        $this->setDateOfShimur($leadJson['lead']['fields']['104608']);
        $this->setSellerNameMeshamer($leadJson['lead']['fields']['104604']);
        $this->setPremiaAferShimur($leadJson['lead']['fields']['104607']);
        $this->setDateOfCancel($leadJson['lead']['fields']['105113']);
        $this->setCallCenterName($leadJson['lead']['fields']['100098']);
        $this->policy = new Policy($leadJson['lead']['fields']);

    }
    /**
     * @return mixed
     */
//    public function getRecordId()
//    {
//        return $this->recordId;
//    }
//
//    /**
//     * @param mixed $recordId
//     */
//    public function setRecordId($recordId)
//    {
//        $this->recordId = $recordId;
//    }

    /**
     * @return mixed
     */
    public function getSellerNameMeshamer()
    {
        return $this->sellerNameMeshamer;
    }

    /**
     * @param mixed $channelName
     */
    public function setSellerNameMeshamer($sellerNameMeshamer)
    {
        $this->sellerNameMeshamer = $this->configTypes["sellerName"][$sellerNameMeshamer];
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
    public function getDateOfShimur()
    {
        return $this->dateOfShimur;
    }

    /**
     * @param mixed $createDate
     */
    public function setDateOfShimur($dateOfShimur)
    {
        $this->dateOfShimur = new DateTime();
        $this->dateOfShimur->setTimestamp($dateOfShimur);
    }
    /**
     * @return mixed
     */
    public function getDateOfCancel()
    {
        return $this->dateOfCancel;
    }

    /**
     * @param mixed $createDate
     */
    public function setDateOfCancel($dateOfCancel)
    {
        $this->dateOfCancel = new DateTime();
        $this->dateOfCancel->setTimestamp($dateOfCancel);
    }
    /**
     * @return mixed
     */
    public function getPremiaAferShimur()
    {
        return $this->premiaAferShimur;
    }

    /**
     * @param mixed $premiaAferShimur
     */
    public function setPremiaAferShimur($premiaAferShimur)
    {
        $this->premiaAferShimur = $premiaAferShimur;
    }

    /**
     * @return mixed
     */
//    public function getSupplierId()
//    {
//        return $this->supplierId;
//    }
//
//    /**
//     * @param mixed $supplierId
//     */
//    public function setSupplierId($supplierId)
//    {
//        $this->supplierId = $supplierId;
//    }

    /**
     * @return mixed
     */
//    public function getCustomerName()
//    {
//        return $this->customerName;
//    }

    /**
     * @param mixed $customerName
     */
//    public function setCustomerName($customerName)
//    {
//        $this->customerName = $customerName;
//    }

    /**
     * @return mixed
     */
//    public function getCustomerPhone()
//    {
//        return $this->customerPhone;
//    }

    /**
     * @param mixed $customerPhone
     */
//    public function setCustomerPhone($customerPhone)
//    {
//        $this->customerPhone = $customerPhone;
//    }

    /**
     * @return mixed
     */
//    public function getCustomerSsn()
//    {
//        return $this->customerSsn;
//    }

    /**
     * @param mixed $customerSsn
     */
//    public function setCustomerSsn($customerSsn)
//    {
//        $this->customerSsn = $customerSsn;
//    }
//    public function getCustomerEmail()
//    {
//        return $this->customerEmail;
//    }

    /**
     * @param mixed $customerEmail
     */
//    public function setCustomerEmail($customerEmail)
//    {
//        $this->customerEmail = $customerEmail;
//    }
//
//    public function getCallCenterName()
//    {
//        return $this->callCenterName;
//    }

    /**
     * @param mixed $callCenterName
     */
//    public function setCallCenterName($callCenterName)
//    {
//        $this->callCenterName = $callCenterName;
//    }

    //public abstract function generateUpdatePolicyPostData();

//    public static function generateDeletePolicyPostData($recordId, $agentId, $recordDate,$dataSource){
//        return [
//            'date' => $recordDate->format(DateTime::ISO8601),
//            'data_source' => $dataSource,
//            'member_api_provider' => 'Lead Im CRM',
//            'member_api_id' => $agentId,
//            'member_name' => "supplier_" . $agentId,
//            'recordStatus' => "canceled",
//            'reference' => $recordId,
//        ];
//
//    }

    public function generateShimurPolicyPostData() {
        return [
            'date' =>  $this->getCreateDate()->format(DateTime::ISO8601), // Updated ISO8601,
            'data_source' => '367455c4622e4f22bd1764ddef85e224',
            'member_api_provider' => 'Lead Im CRM',
            'member_api_id' => $this->getSupplierId(),
            'member_name' => "supplier_" . $this->getSupplierId(),
            'callCenterName' => $this->getCallCenterName(),
            'premiaBeforeShimur' => $this->policy->getActualPremia(),
            'insuranceCompany' => $this->policy->getInsuranceCompany(),
            'policyType' => $this->policy->getPolicyType(),
            'dateOfShimur' => $this->getDateOfShimur()->format(DateTime::ISO8601),
            'dateOfCancel' => $this->getDateOfCancel()->format(DateTime::ISO8601),
            'premiaAferShimur' => $this->getPremiaAferShimur(),
            'sellerNameMeshamer' => $this->getSellerNameMeshamer(),
            'reference' => $this->getRecordId(),
        ];
    }
    public function generateUpdatePolicyPostData(){
        //if wiil need update policy here
        return null;
    }

}