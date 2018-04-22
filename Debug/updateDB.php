<?php
//print_r($_POST);
//print_r($_FILES);

$str = file_get_contents('harBituahFiles.json');
$files = json_decode($str, true);

foreach ($files as $file ){
    file_put_contents("tmp.xlsx", fopen($file["file"], 'r'));
    $cfile = curl_file_create("tmp.xlsx", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", $file['fileName']);

    if ($curl = curl_init()) {
//print_r('CURL START');
//curl_setopt($curl, CURLOPT_URL, 'http://xlsx_parse.webmind28.com/api.php');
        curl_setopt($curl, CURLOPT_URL, 'http://192.168.150.223/api.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
        curl_setopt($curl, CURLOPT_POSTFIELDS, array(
            'crmAcccountNumber'=>$file['crmAcccountNumber'],
            'recordNumber'=>$file['recordNumber'],
            'agentId'=>1234,
            'name'=>$file['name'],
            'phone'=>$file['phone'],
            'file_category'=>$file['file_category'],
            'cat_name'=>$file['cat_name'],
            'fileType'=>$file['fileType'],
            'file' => $cfile,
            'ssn' => $file['ssn'],
            'issue-date' => $file['issue-date'],
        ));
//print_r('CURL END');
        $out = curl_exec($curl);
        $result = json_decode(trim($out));
        curl_error($curl);

//   echo $out;
// if ($out!="Data saved successfully") {
//     print $out;
// }
        if ($result->success != true) {
            // print_r($out);
        }

    }

//print_r('UPLOAD START');


if ($result->success == true) {

}
curl_close($curl);
}
