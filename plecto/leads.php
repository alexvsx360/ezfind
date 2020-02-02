<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/24/2017
 * Time: 11:29 AM
 */

/**
 * Created by PhpStorm.
 * User: User
 * Date: 07/05/2018
 * Time: 10:30
 */

include_once ('../generalUtilities/plectoFunctions.php');
function getChannelName($channelName){
    switch ($channelName){
        case "דף נחיתה אתר ezfind":
        case "פייסבוק":
        case "פייסבוק פוסטים-הלוואות":
        case  "פוסטים פייסבוק-איתור":
            return "פייסבוק";
        default:
            return $channelName;

    }
};
function getLeadCallCenterSuplaier($campainName){
    switch ($campainName){
        case "פוליסות מהר הביטוח":
            return $_GET['callCenter'];
        case "לידים חמים" :
            switch ($_GET['channel']){
                case 17356:
                case 16713:
                case 16856:
                    return 'ezfind';
                case 15652:
                case 15563:
                case 15562:
                    return'מקדמים מהבית';
                default:
                    return "לא ידוע";
            }
        case "איתור כספים אבודים" :
            return 'ezfind';
        case "הלוואות" :
            return 'ezfind';
        default:
            return "לא ידוע";
    }
}

function getLeadSuplaier(){
    if ($_GET['suplaier'] != ""){
        return $_GET['suplaier'];
    } else {
        return $_GET['promoter'];
    }
}
/*log the request*/
$myfile = fopen("log.txt", "a");
//fwrite($myfile, "new Lead arrived: " . print_r($_REQUEST, true) . " \n");

$date = $_GET['date'];
$date = str_replace("/","-", $date);

$datetime = new DateTime($date);

$leadPostDate = [
    'date' => $datetime->format(DateTime::ISO8601), // Updated ISO8601,
    'data_source' => 'd099be653ff54800bcfbe107ccee1159',
    'member_api_provider' => 'leadsProxy',
    'member_api_id' => ($_GET['suplaierId'] == "" ? "1234" : $_GET['suplaierId']),
    'member_name' => ($_GET['suplaier'] == "" ? "Leads Proxy" : $_GET['suplaier']),
    'leadChannel' => getChannelName($_GET['channelName']),
    'leadSuplaier' => getLeadSuplaier(),
    'campainName' => $_GET['campainName'],
    'leadCallCenterSuplaier' => getLeadCallCenterSuplaier($_GET['campainName']),
    'leadIncorrectStatus' => $_GET['incorrectLeadStatus'],
    'reference' => $_GET['leadId'],
    'totalHealth' => $_GET['totalHealth'],
    'totalLife' => $_GET['totalLife'],
    'totalHealthAndLife' => $_GET['totalHealthAndLife'],
    'totalCollective' => $_GET['totalCollective'],
    'leadType' => $_GET['leadType']

];

$output = addLeadToPlecto($leadPostDate);


http_response_code(200);