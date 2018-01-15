<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 1/4/2018
 * Time: 5:16 PM
 */

error_log(@date('[d/M/Y:H:i:s]') . "ezfindLogger received new".$_SERVER['REQUEST_METHOD'] ." request \n");
error_log(@date('[d/M/Y:H:i:s]') . "URL is - http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
error_log(@date('[d/M/Y:H:i:s]') . "request parameters are " . print_r($_REQUEST, TRUE) ."\n");
