<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 18/07/2018
 * Time: 12:11
 */

class BaseLeadFieldValues
{
    private $dateCreateLead;
    private $status;
    private $supplier;
    private $channel;

    function __construct($leadJson,$accId)
    {
        $this->setChannel($leadJson['lead']['channel_name']);
        $this->setDateCreateLead($leadJson['lead']['datetime']);
        $this->setStatus($leadJson['lead']['status']);
        $this->setSupplier($accId,$leadJson['lead']['supplier_id']);
    }
    //channel_name
    public function getChannel()
    {
        return $this->channel;
    }

    public function setChannel($channel)
    {
        $this->channel = $channel;
    }
    //DateCreateLead
    public function getDateCreateLead()
    {
        return $this->dateCreateLead;
    }

    public function setDateCreateLead($dateCreateLead)
    {
        $this->dateCreateLead= $dateCreateLead;
    }

    //Status
    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = getStatusAsString($status);
    }

    //supplier
    public function getSupplier()
    {
        return $this->supplier;
    }

    public function setSupplier($accId,$supplier)
    {
        $user = getUser($accId,$supplier);
        $this->supplier = $user['result']['name'];
    }


}