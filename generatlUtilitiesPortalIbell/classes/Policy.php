<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 1/8/2018
 * Time: 1:06 PM
 */
class Policy{
    var $saleDate;
    var $ticketNumber;
    var $ticketLink;
    var $sellingChannel;
    var $sellerName;
    var $promoterName;
    var $agentNumber;
    var $policyType;
    var $insuranceCompany;
    var $monthlyPremia;
    var $annualPremia;
    var $hitum;
    var $insuranceStartDate;
    var $actualPremia;
    var $premiaGaps;
    var $productionDate;
    var $policyNumber;
    var $pendingStatus;

    /**
     * Policy constructor.
     * @param $leadFields
     */
    public function __construct($leadFields)
    {
        $this->setSaleDate($leadFields['102698']);
        $this->setTicketNumber($leadFields['102158']);
        $this->setTicketLink($leadFields['102132']);
        $this->setSellingChannel($leadFields['102131']);
        $this->setSellerName($leadFields['100099']);
        $this->setPromoterName($leadFields['102130']);
        $this->setAgentNumber($leadFields['102119']);
        $this->setPolicyType($leadFields['102104']);
        $this->setInsuranceCompany($leadFields['102112']);
        $this->setMonthlyPremia($leadFields['100100']);
        $this->setAnnualPremia($leadFields['102136']);
        $this->setHitum($leadFields['102133']);
        $this->setInsuranceStartDate($leadFields['102140']);
        $this->setActualPremia($leadFields['102416']);
        $this->setPremiaGaps($leadFields['102417']);
        $this->setProductionDate($leadFields['102218']);
        $this->setPolicyNumber($leadFields['102145']);
        $this->setPendingStatus($leadFields['104471']);

    }

    /**
     * @return mixed
     */
    public function getPendingStatus()
    {
        return $this->pendingStatus;
    }

    /**
     * @param mixed $pendingStatus
     */
    public function setPendingStatus($pendingStatus)
    {
        $this->pendingStatus = $pendingStatus;
    }




    /**
     * @return mixed
     */
    public function getSaleDate()
    {
        return $this->saleDate;
    }

    /**
     * @param mixed $saleDate
     */
    public function setSaleDate($saleDate)
    {
        $this->saleDate = new DateTime();
        $this->saleDate->setTimestamp($saleDate);
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
    public function getTicketLink()
    {
        return $this->ticketLink;
    }

    /**
     * @param mixed $ticketLink
     */
    public function setTicketLink($ticketLink)
    {
        $this->ticketLink = $ticketLink;
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
    public function getPromoterName()
    {
        return $this->promoterName;
    }

    /**
     * @param mixed $promoterName
     */
    public function setPromoterName($promoterName)
    {
        $this->promoterName = $promoterName;
    }

    /**
     * @return mixed
     */
    public function getAgentNumber()
    {
        return $this->agentNumber;
    }

    /**
     * @param mixed $agentNumber
     */
    public function setAgentNumber($agentNumber)
    {
        $this->agentNumber = $agentNumber;
    }

    /**
     * @return mixed
     */
    public function getPolicyType()
    {
        return $this->policyType;
    }

    /**
     * @param mixed $policyType
     */
    public function setPolicyType($policyType)
    {
        $types = [
            '102105' => 'תאונות אישיות',
            '102106' => 'אובדן כושר עבודה',
            '102107' => 'מחלות קשות',
            '102108' => 'חיים',
            '102109' => 'בריאות',
            '102110' => 'ביטוח משכנתא',
            '102111' => 'סיעודי',
        ];
        $this->policyType = $types[$policyType];
    }

    /**
     * @return mixed
     */
    public function getInsuranceCompany()
    {
        return $this->insuranceCompany;
    }

    /**
     * @param mixed $insuranceCompany
     */
    public function setInsuranceCompany($insuranceCompany)
    {
        $types = [
            '102113' => "כלל",
            '102114' => "הראל",
            '102115' => "איילון",
            '102116' => "הכשרה",
            '102117' => "הפניקס",
            '102118' => "איילון",
        ];
        $this->insuranceCompany = $types[$insuranceCompany];
    }

    /**
     * @return mixed
     */
    public function getMonthlyPremia()
    {
        return $this->monthlyPremia;
    }

    /**
     * @param mixed $monthlyPremia
     */
    public function setMonthlyPremia($monthlyPremia)
    {
        $this->monthlyPremia = $monthlyPremia;
    }

    /**
     * @return mixed
     */
    public function getAnnualPremia()
    {
        return $this->annualPremia;
    }

    /**
     * @param mixed $annualPremia
     */
    public function setAnnualPremia($annualPremia)
    {
        $this->annualPremia = $annualPremia;
    }

    /**
     * @return mixed
     */
    public function getHitum()
    {
        return $this->hitum;
    }

    /**
     * @param mixed $hitum
     */
    public function setHitum($hitum)
    {
        $types = [
            '102134' => 'ירוק',
            '102135' => 'אדום'
        ];
        $this->hitum = $types[$hitum];
    }

    /**
     * @return mixed
     */
    public function getInsuranceStartDate()
    {
        return $this->insuranceStartDate;
    }

    /**
     * @param mixed $insuranceStartDate
     */
    public function setInsuranceStartDate($insuranceStartDate)
    {
        $this->insuranceStartDate = new DateTime();
        $this->insuranceStartDate->setTimestamp($insuranceStartDate);
    }

    /**
     * @return mixed
     */
    public function getActualPremia()
    {
        return $this->actualPremia;
    }

    /**
     * @param mixed $actualPremia
     */
    public function setActualPremia($actualPremia)
    {
        $this->actualPremia = $actualPremia;
    }

    /**
     * @return mixed
     */
    public function getPremiaGaps()
    {
        return $this->premiaGaps;
    }

    /**
     * @param mixed $premiaGaps
     */
    public function setPremiaGaps($premiaGaps)
    {
        $this->premiaGaps = $premiaGaps;
    }

    /**
     * @return mixed
     */
    public function getProductionDate()
    {
        return $this->productionDate;
    }

    /**
     * @param mixed $productionDate
     */
    public function setProductionDate($productionDate)
    {
        $this->productionDate = new DateTime();
        $this->productionDate->setTimestamp($productionDate);
    }

    /**
     * @return mixed
     */
    public function getPolicyNumber()
    {
        return $this->policyNumber;
    }

    /**
     * @param mixed $policyNumber
     */
    public function setPolicyNumber($policyNumber)
    {
        $this->policyNumber = $policyNumber;
    }


}