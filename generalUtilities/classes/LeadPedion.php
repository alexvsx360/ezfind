<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16/04/2018
 * Time: 09:44
 */
include_once 'BaseLead.php';
include_once 'BaseLeadMuzareyZmicha.php';
class LeadPedion extends BaseLeadMuzareyZmicha
{
    private $pedionSum;

    public function __construct($leadJson)
    {
        parent::__construct($leadJson);
        $this->setPedionSum($leadJson['lead']['fields']['105718']);
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

    public  function generateUpdatePolicyPostData(){
        return array_merge(
            parent::generateUpdatePolicyPostData(),
            ['pedionSum' =>$this->getPedionSum()]
        ) ;
    }
}