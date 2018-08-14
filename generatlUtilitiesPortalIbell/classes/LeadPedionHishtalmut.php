<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16/04/2018
 * Time: 09:55
 */
include_once 'BaseLead.php';
include_once 'BaseLeadMuzareyZmicha.php';
class LeadPedionHishtalmut extends BaseLeadMuzareyZmicha
{
    private $pedionSum;
    private $pullType;
    public function __construct($leadJson)
    {
        parent::__construct($leadJson);
        $this->setPedionSum($leadJson['lead']['fields']['105718']);
        $this->setPullType($leadJson['lead']['fields']['106532']);
    }

    //pedionSum
    public function getPedionSum()
    {
        return $this->pedionSum;
    }

    public function setPedionSum($pedionSum)
    {
        $this->pedionSum = $pedionSum;
    }


    //pullType
    public function getPullType()
    {
        return $this->pullType;
    }

    public function setPullType($pullType)
    {
        $this->pullType = $pullType;
    }
    public  function generateUpdatePolicyPostData(){
        return array_merge(
            parent::generateUpdatePolicyPostData(),
            ['pedionSum' =>$this->getPedionSum(),
             'pullType' =>$this->getPullType() ]
        ) ;
    }
}