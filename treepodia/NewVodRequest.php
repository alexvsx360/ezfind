<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 1/23/2018
 * Time: 7:35 AM
 */
include_once ('../generalUtilities/functions.php');


function getAccessToken() {
    $postData = [
        'email' => 'yaki@tgeg.co.il',
        'password' => 'Alma@102030'
    ];
    $response = httpPostContentTypeJson('https://api.treepodia.com/rest/vod/v032016/auth', json_encode($postData));
    return json_decode($response);
}

$accessToken = getAccessToken();
$bDate = new DateTime('06/12/1985');

$vodPostData = [
    'accessToken' => $accessToken->accessToken,
    'sku' => 'HA11',  //todo replace with real customer name
    'templateId' => 1,
    'requestData' => array(
        'name' => 'יאקי',
        'fname' => 'אמסלם',
        'ssn' => '038054664',
        'bDate' => $bDate->getTimestamp(),
        'EmployeeType' => 'שכיר',
        'jobsCount' => 5,
        'sex' => 'זכר'
    ),
    'callback' => array(
        'url' => 'https://ezfind.frb.io/plecto/logger.php',
        'method' => 'POST',
        'contentType' => 'application/json',
        'body' => "{\"requestId\":\"{requestId}\",\"videoUrl\":\"{videoUrl}\"}",
    )
];


$url = 'https://api.treepodia.com/rest/vod/v032016/acc/UA-EZFIND/requests';

$response = httpPostContentTypeJson($url, json_encode($vodPostData));
echo $response;


// sample log snippet

/*
web_php_error  2018-02-13T16:32:00Z [13/Feb/2018:17:32:00]request parameters are Array
(
)

web_php_error  2018-02-13T16:32:00Z [13/Feb/2018:17:32:00]Request's Json content is: "{\"requestId\":\"31\",\"videoUrl\":\"https:\/\/storage.googleapis.com\/videos.viddo.treepodia.com\/videos\/UA-1D8CA48AA07B6800\/UA-EZFIND\/11145921_11134556_5exryo7f4btlli2fn9dd_video.mp4\"}"
web_php_error  2018-02-13T16:32:00Z [13/Feb/2018:17:32:00]ezfindLogger received newPOST request
web_php_error  2018-02-13T16:32:00Z [13/Feb/2018:17:32:00]URL is - http://ezfind.frb.io/plecto/logger.php
apache_access  34.200.100.218 - - [13/Feb/2018:16:42:48 +0000] "POST /plecto/logger.php HTTP/1.1" 200 173 "-" "Apache-HttpClient/4.3.3 (java 1.5)"
web_php_error  2018-02-13T16:42:48Z [13/Feb/2018:17:42:48]URL is - http://ezfind.frb.io/plecto/logger.php
web_php_error  2018-02-13T16:42:48Z [13/Feb/2018:17:42:48]ezfindLogger received newPOST request
web_php_error  2018-02-13T16:42:48Z [13/Feb/2018:17:42:48]request parameters are Array
  (
  )

web_php_error  2018-02-13T16:42:48Z [13/Feb/2018:17:42:48]Request's Json content is: "{\"requestId\":\"32\",\"videoUrl\":\"https:\/\/storage.googleapis.com\/videos.viddo.treepodia.com\/videos\/UA-1D8CA48AA07B6800\/UA-EZFIND\/11145922_11134557_pjcz2rvg7wv5j4bk9mdm_video.mp4\"}"
web_php_error  2018-02-13T16:43:17Z PHP Notice:  Undefined index: incorrectLeadStatus in /srv/app/ezfind/htdocs/plecto/leads.php on line 57
*/