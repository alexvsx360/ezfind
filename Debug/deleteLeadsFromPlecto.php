<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 1/11/2018
 * Time: 9:54 AM
 */

include_once ('../generalUtilities/plectoFunctions.php');


function str_replace_last( $search , $replace , $str ) {
    if( ( $pos = strrpos( $str , $search ) ) !== false ) {
        $search_length  = strlen( $search );
        $str    = substr_replace( $str , $replace , $pos , $search_length );
    }
    return $str;
}

$array = $fields = array(); $i = 0;
$handle = @fopen("C:\\Users\\User\\Desktop\\tmp\\deleteMislaka.csv", "r");
if ($handle) {
    while (($row = fgetcsv($handle, 4096)) !== false) {
        if (empty($fields)) {
            $fields = $row;
            continue;
        }
        foreach ($row as $k=>$value) {
            $array[$i][$fields[$k]] = $value;
        }
        $i++;
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}

$masterArray = array();

foreach ($array as $line){
    global $masterArray;

    $leadDate = $line['תאריך קליטה'];
    $leadDate = str_replace("/","-", $leadDate);
    $leadDate = new DateTime($leadDate);

    $leadPostDate = [
        'date' => $leadDate->format(DateTime::ISO8601), // Updated ISO8601,
        'data_source' => 'c19a89078ccf4c89b5603277b54eb7c7',
        'member_api_provider' => 'leadsProxy',
        'member_api_id' => '1234',
        'member_name' => 'Leads Proxy',
        'callCenterName' => '',
        'sellingChannl' => '',
        'sellerName' => '',
        'paymentSum' => '',
        'paymentCount' => '',
        'customerCount' => '',
        'CustomerType' => '',
        'reference' => $line['מספר ליד'],
    ];
    if (count($masterArray) < 1){
        array_push($masterArray, $leadPostDate);
    } else {
        array_push($masterArray, $leadPostDate);
        $output = addLeadToPlecto($masterArray);
        unset($masterArray);
        $masterArray = array();
    }



}



http_response_code(200);
