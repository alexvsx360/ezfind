<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22/04/2018
 * Time: 10:11
 */
include_once 'BaseLead.php';
include_once 'BaseLeadMuzareyZmicha.php';
class LeadPigurim extends BaseLeadMuzareyZmicha
{
    private $referenceType;
    function __construct($leadJson)
    {
        parent::__construct($leadJson);
        $this->setReferenceType($leadJson['lead']['fields']['106531']);
    }
    //referenceType
    public function getReferenceType()
    {
        return $this->referenceType;
    }

    public function setReferenceType($referenceType)
    {
        $this->referenceType = $referenceType;
    }

    public  function generateUpdatePolicyPostData(){
        return array_merge(
            parent::generateUpdatePolicyPostData(),
            ['referenceType' =>$this->getReferenceType()]
        ) ;
    }
}
