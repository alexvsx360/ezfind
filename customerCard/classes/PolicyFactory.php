<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 18/07/2018
 * Time: 12:35
 */

class PolicyFactory
{
    public static function create($leadToPopulateJson, $configTypes, $accId)
    {
        switch ($accId) {
            case 3694://tiful vesherut lakochot
                return new TifulSherutFieldsValues($leadToPopulateJson, $configTypes, $accId);
            default:
                return null;
        }
    }
}