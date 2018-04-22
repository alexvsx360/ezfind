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
$handle = @fopen("C:\\Users\\User\\Desktop\\tmp\\har.csv", "r");
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
    $insuranceStartDate = $line['תאריך תחילת ביטוח'];
    $insuranceStartDate = str_replace("/","-", $insuranceStartDate);
    $insuranceStartDate = new DateTime($insuranceStartDate);

    $insuranceEndDate = $line['תאריך סוף ביטוח'];
    $insuranceEndDate = str_replace("/","-", $insuranceEndDate);
    $insuranceEndDate = new DateTime($insuranceEndDate);

    $leadDate = $line['תאריך קליטה'];
    $leadDate = str_replace("/","-", $leadDate);
    $leadDate = new DateTime($leadDate);

    $var = $line['חברת ביטוח'];
    $var = str_replace_last("\"", "", $var);

    $leadPostDate = [
        'date' => $leadDate->format(DateTime::ISO8601), // Updated ISO8601,
        'data_source' => '24f7c175723d456ebee7279f575bcd82',
        'member_api_provider' => 'leadsProxy',
        'member_api_id' => '1234',
        'member_name' => 'Leads Proxy',
        'customerId' => $line['ת.ז'],
        'insuranceCategory' => $line['תחום הביטוח'],
        'mainBrunch' => $line['ענף ראשי'],
        'secondaryBrunch' => $line['ענף משני'],
        'productType' => $line['סוג מוצר'],
        'insuranceCompany' => $var,
        'premia' => $line['פרמיה בש"ח'],
        'premiaType' => $line['סוג פרמיה'],
        'policyNumber' => $line['מספר פוליסה'],
        'programType' => $line['סיווג תוכנית'],
        'insuranceStartDate' => $insuranceStartDate->format(DateTime::ISO8601),
        'insuranceEndDate' => $insuranceEndDate->format(DateTime::ISO8601),
        'reference' => $line['מספר ליד'],
        'renewMonth' => $insuranceStartDate->format("M")
    ];
    if (count($masterArray) < 99){
        array_push($masterArray, $leadPostDate);
    } else {
        array_push($masterArray, $leadPostDate);
        $output = addLeadToPlecto($masterArray);
        unset($masterArray);
        $masterArray = array();
    }



}



http_response_code(200);
