<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/12/2018
 * Time: 5:33 PM
 */



function getYatzranName($rootXml){
    return $rootXml->YeshutYatzran->children()[1];
}

function parseMutzarin($rootXml){
    foreach($rootXml->Mutzarim->children() as $mutzat) {
        foreach ($mutzat->HeshbonotOPolisot as $HeshbonOPolisa){

        }
    }

}

$xml = simplexml_load_file("maskanta.xml");

echo getYatzranName($xml);
echo getYatzranName($xml);