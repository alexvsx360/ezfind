<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 17/04/2018
 * Time: 12:58
 */
include_once 'BaseLead.php';
include_once 'BaseLeadMuzareyZmicha.php';
class LeadEdcunMutavim extends BaseLeadMuzareyZmicha
{
    function __construct($leadJson)
    {
        parent::__construct($leadJson);
    }
}