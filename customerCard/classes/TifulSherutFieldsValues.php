<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 18/07/2018
 * Time: 11:11
 */
include_once('BaseLeadFieldValues.php');

class TifulSherutFieldsValues extends BaseLeadFieldValues
{
    private $policyType;
    private $insuranceCompany;
    private $monthPremia;
    private $actualPremia;
    private $ticketLink;
    private $linkLeadRecord;
    private $paymentSum;
    private $policyLiveMonth;
    private $policyLiveDays;

    function __construct($leadJson, $configTypes, $accId)
    {
        parent::__construct($leadJson, $accId);
        $this->setPolicyType($configTypes['cisuyTypes'][$leadJson['lead']['fields'][102104]]);
        $this->setInsuranceCompany($configTypes['insuranceCompanyTypes'][$leadJson['lead']['fields'][102112]]);
        $this->setMonthPremia($leadJson['lead']['fields']['100100']);
        $this->setActualPremia($leadJson['lead']['fields']['102416']);
        $this->setTicketLink($leadJson['lead']['fields']['102132']);
        $this->setPaymentSum($leadJson['lead']['fields']['104006']);
        $this->setPolicyLiveDays($leadJson['lead']['fields']);
        $this->setPolicyLiveMonth($leadJson['lead']['fields']);

        $this->setLinkLeadRecord('https://crm.ibell.co.il/a/3694/leads/' . $leadJson['lead']['lead_id']);
    }

    //policyType
    public function getPolicyType()
    {
        return $this->policyType;
    }

    public function setPolicyType($policyType)
    {
        $this->policyType = $policyType;
    }

    //PaymentSum
    public function getPaymentSum()
    {
        return $this->paymentSum;
    }

    public function setPaymentSum($paymentSum)
    {
        $this->paymentSum = $paymentSum;
    }

    //insuranceCompany
    public function getInsuranceCompany()
    {
        return $this->insuranceCompany;
    }

    public function setInsuranceCompany($insuranceCompany)
    {
        $this->insuranceCompany = $insuranceCompany;
    }

    //monthPremia
    public function getMonthPremia()
    {
        return $this->monthPremia;
    }

    public function setMonthPremia($monthPremia)
    {
        $this->monthPremia = $monthPremia;
    }

    //actualPremia
    public function getActualPremia()
    {
        return $this->actualPremia;
    }

    public function setActualPremia($actualPremia)
    {
        $this->actualPremia = $actualPremia;
    }

    //ticketLink
    public function getTicketLink()
    {
        return $this->ticketLink;
    }

    public function setTicketLink($ticketLink)
    {
        $this->ticketLink = $ticketLink;
    }

    //linkLeadRecord
    public function getLinkLeadRecord()
    {
        return $this->linkLeadRecord;
    }

    public function setLinkLeadRecord($linkLeadRecord)
    {
        $this->linkLeadRecord = $linkLeadRecord;
    }

    /**
     * @return mixed
     */
    public function getPolicyLiveMonth()
    {
        return $this->policyLiveMonth;
    }

    /**
     * @param mixed $policyLiveMonth
     */
    public function setPolicyLiveMonth($policyLiveMonth): void
    {
        $dateTime = new DateTime();
        $dateTime1 = new DateTime();
        if (!empty($policyLiveMonth['102218'])) {
            $policyProductionDate = $dateTime->setTimestamp($policyLiveMonth['102218']);
            $insuranceStartDateAsTime = $dateTime1->setTimestamp($policyLiveMonth['102140']);
            $today = new DateTime();
            $diffHafakaAndToday = $today->diff($policyProductionDate);
            $this->policyLiveMonth = $diffHafakaAndToday->y == 0 ? $diffHafakaAndToday->format('%m') : ((12 * $diffHafakaAndToday->y) + $diffHafakaAndToday->format('%m'));
        } else {
            $this->policyLiveMonth = "אין תאריך הפקה";
        }
    }

    /**
     * @return mixed
     */
    public function getPolicyLiveDays()
    {
        return $this->policyLiveDays;
    }

    /**
     * @param mixed $policyLiveDays
     */
    public function setPolicyLiveDays($policyLiveDays): void
    {
        $dateTime = new DateTime();
        $dateTime1 = new DateTime();
        if (!empty($policyLiveDays['102218'])) {
            $policyProductionDate = $dateTime->setTimestamp($policyLiveDays['102218']);
            $insuranceStartDateAsTime = $dateTime1->setTimestamp($policyLiveDays['102140']);
            $today = new DateTime();
            $diffHafakaAndToday = $today->diff($policyProductionDate);
            $diffHafakaAndToday->format('%a');
            $this->policyLiveDays = $diffHafakaAndToday->format('%a');
        } else {
            $this->policyLiveDays = "אין תאריך הפקה";
        }
    }

        public
        function getArrayFieldsValues()
        {
            return [
                'channel' => $this->getChannel(),
                'supplier' => $this->getSupplier(),
                'status' => $this->getStatus(),
                'dateCreateLead' => $this->getDateCreateLead(),
                'linkLeadRecord' => $this->getLinkLeadRecord(),
                'ticketLink' => $this->getTicketLink(),
                'actualPremia' => $this->getActualPremia(),
                'monthPremia' => $this->getMonthPremia(),
                'insuranceCompany' => $this->getInsuranceCompany(),
                'policyType' => $this->getPolicyType(),
                'paymentSum' => $this->getPaymentSum(),
                'policyLiveDays' => $this->getPolicyLiveDays(),
                'policyLiveMonth' => $this->getPolicyLiveMonth()
            ];

        }

    }
