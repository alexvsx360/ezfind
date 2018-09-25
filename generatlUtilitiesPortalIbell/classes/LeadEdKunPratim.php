<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 17/04/2018
 * Time: 12:54
 */
include_once 'BaseLead.php';
include_once 'BaseLeadMuzareyZmicha.php';
class LeadEdKunPratim extends BaseLeadMuzareyZmicha
{
    function __construct($leadJson)
    {
        parent::__construct($leadJson);
    }
}