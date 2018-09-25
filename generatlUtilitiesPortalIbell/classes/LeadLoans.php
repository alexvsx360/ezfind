<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15/04/2018
 * Time: 12:02
 */
include_once 'BaseLead.php';
include_once 'BaseLeadMuzareyZmicha.php';
class LeadLoans extends BaseLeadMuzareyZmicha
{
    private $loanAmount;
    private $loanMontlyPeriod;
    public function __construct($leadJson)
    {
        parent::__construct($leadJson);
        $this->setLoanAmount($leadJson['lead']['fields']['106455']);
        $this->setLoanMontlyPeriod($leadJson['lead']['fields']['106456']);
    }

    //loanMontlyPeriod
    public function getLoanMontlyPeriod()
    {
        return $this->loanMontlyPeriod;
    }

    public function setLoanMontlyPeriod($loanMontlyPeriod)
    {
        $this->loanMontlyPeriod = $loanMontlyPeriod;
    }
    //loanAmount
    public function getLoanAmount()
    {
        return $this->loanAmount;
    }

    public function setLoanAmount($loanAmount)
    {
        $this->loanAmount = $loanAmount;
    }

    public  function generateUpdatePolicyPostData(){
        return
            array_merge(
                parent::generateUpdatePolicyPostData(),
                [
                 'loanAmount' =>$this->getLoanAmount(),
                 'loanMontlyPeriod' => $this->getLoanMontlyPeriod()
                ]);
    }
}