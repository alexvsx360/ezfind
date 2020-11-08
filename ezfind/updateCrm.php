<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/24/2017
 * Time: 5:47 PM
 */

include_once ("../generalUtilities/functions.php");
require '../vendor/autoload.php';
use Zendesk\API\HttpClient as ZendeskAPI;

$subdomain = "ezfind-sherut";
$username  = "yaki@tgeg.co.il";
$token     = "WP5x5E4l3ZCVcaiDqFSJIQouL8WY0AdcX2Rpd7SH"; // replace this with your token
$client = new ZendeskAPI($subdomain, $username);
$client->setAuth('basic', ['username' => $username, 'token' => $token]);
var_dump($_REQUEST);
$req_dump = print_r($_REQUEST, TRUE);
$fp = fopen('request.log', 'a');
fwrite($fp, $req_dump ."\n");
;
function checkUpdate($result,$updateLeadUrl)
{
    global $client;
    if ($result != "OK") {
        for ($i = 0; $i < 3; $i++) {
            sleep(1);
            $result = httpGet($updateLeadUrl);
            if ($result == "OK") {
                break;
            } else {
                if ($i == 2 && $result != "OK") {
                    $result = json_decode($result, true);
                    $current_file_name = basename($_SERVER['PHP_SELF']);
                    $debug = debug_backtrace();
                    $debug = array_shift($debug);
//                  $sentfromServer = $_SERVER['SERVER_NAME'];
                    $sentfromServer = $_SERVER['HTTP_HOST'];
                    $parseUrl = parse_url($updateLeadUrl);
                    $sentToServer = $parseUrl['host'];
                    $prameters ="";
                    foreach($_GET as $key => $value){
                        $prameters.= $key . " : " . $value . "\n";
                    }
                    $newTicket = $client->tickets()->create([
                        'tags' => 'error',
                        'status' => 'new',
                        'subject' => 'error in update crm',
                        //   'collaborators' =>  ["Yaki@tgeg.co.il"],
                        'comment' => [
                            'body' => 'in date:' . date("d/m/Y") . " \n" .
                                'in file: ' . $current_file_name . " \n" .
                                'in line: ' . $debug["line"] . " \n" .
                                'prameters: ' . $prameters . " \n" .
                                'Error:' . $result['errmsg'] . " \n" .
                                'request sent from server :' . $sentfromServer . " \n" .
                                'to server:' . $sentToServer . " \n" .
                                'orignalUrl:' . $updateLeadUrl
                        ]
                    ]);
                }
            }
        }
    } else {
        return $result;
    }
}
$statusToFieldNumJson = [
    "מסלקות_פנסיוניות___בקשות_חדשות" => "100084",
    "מסלקות_פנסיוניות___נשלח_לחברת_הביטוח" => "100085",
    "בקשות_חדשות" => "100084",
    "ממתין_למסמכים_מהלקוח" => "102338",
    "ממתין_לחתימות" => "102338",
    "נשלח_לחברת_הביטוח" => "100085",
    "ריגקט_מחברת_הביטוח" => '102338',
    "חריגים" => "2",
    "ממתין_לקיט_הלוואה" => "108437",
    "תור_נדחה" => "102339",
    "תור_גנוזות" => "102700",
    "תור_בוצע" =>  "102340"
];

$updateLeadUrl = "http://proxy.leadim.xyz/apiproxy/acc3305/updatelead.ashx?acc_id=3694";
$updateLeadUrl .= "&lead_ticket=" . $_GET['lead_ticket'];
if ($_GET['status'] == "Solved" || $_GET['status'] == "פתורה"){
    $updateLeadUrl .="&status=102340"; //הופק
} else {
    $updateLeadUrl .= "&status=" . $statusToFieldNumJson[$_GET['workingQueue']];
}
//$updateLeadUrl .= "&status=" . $statusToFieldNumJson[$_GET['workingQueue']];
$updateLeadUrl .= "&update_fields[fld_id]=104484&update_fields[fld_val]=" . $_GET['workingQueue'];
fwrite($fp, $updateLeadUrl."\n" );
$response = httpGet($updateLeadUrl);
checkUpdate($response,$updateLeadUrl);
fwrite($fp, $response."\n" );

fclose($fp);

