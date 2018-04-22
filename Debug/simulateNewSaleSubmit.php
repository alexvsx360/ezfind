<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/10/2018
 * Time: 8:29 PM
 */

include_once "../functions.php";
$postData = [
    "customerName" => "יאקי ניסיון",
    "customerPhone" => "0509049741",
    "customerSsn" => "038054664",
    "customerEmail" => "yaki@ezfind.co.il",
    "callCenterName" => "ezfind",
    "recordNumber" => "13659058",
    "secondaryCustomerName" => "",
    "secondaryCustomerSsn" => "",
    "address" => "גקכקכקגכק",
    "userName" => "יאקי",
    "userEmail" => "yaki@tgeg.co.il",
    "issueDate" => "1513807200",
    "sellingChannel" => "ידני",
    "birthDate" => "1514239200",
    "employyType" => "עצמאי",
    "jobsCount" => 1,
    "sex" => "זכר",
    "customerFirstName" => "יאקי",
    "customerLastName" => "אמסלם",
    "agentId" => 11017,
    "customerCount" => 1,
    "paymentSum" => 111,
    "paymentCount" => 1,
];


httpPost("http://ezfind.local/SandBox/ezfind/NewSale.php", $postData);