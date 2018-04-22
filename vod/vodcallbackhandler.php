<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 1/4/2018
 * Time: 5:16 PM
 */


$json_str = file_get_contents('php://input');
$jsonObj =  json_decode($json_str);
if (json_last_error() == JSON_ERROR_NONE){
	// received Json answer
	error_log(@date('[d/M/Y:H:i:s]') . "Request's Json content is: " . json_encode($json_str, JSON_PRETTY_PRINT));
} else {
    //not a JSON
    error_log(@date('[d/M/Y:H:i:s]') . "Request's Json content is: " . json_encode($json_str, JSON_PRETTY_PRINT));
}

