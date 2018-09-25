<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 01/08/2018
 * Time: 13:56
 */
//http://ezfind.frb.io/leadIm/callback/crmCallbackHendler.php

$str1 = @date('[d/M/Y:H:i:s]') . "crmCallbackLogger received new " . $_SERVER['REQUEST_METHOD'] . " request \n";
$str2 = @date('[d/M/Y:H:i:s]') . "URL is - http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$str3 = @date('[d/M/Y:H:i:s]') . "request parameters are " . print_r($_REQUEST, TRUE) . "\n";
error_log($str1);
error_log($str2);
error_log($str3);
echo $str1 . "<br/>\n";
echo $str2 . "<br/>\n";
echo $str3 . "<br/>\n";
