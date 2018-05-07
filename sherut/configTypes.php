<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 02/05/2018
 * Time: 14:31
 */

return [
    'cisuyTypes' => [
        '102105' => 'תאונות_אישיות',
        '102106' => 'אובדן_כושר_עבודה',
        '102107' => 'מחלות_קשות',
        '102108' => 'חיים',
        '102109' => 'בריאות',
        '102110' => 'ביטוח_משכנתא',
        '102111' => 'סיעודי',
    ],

    'insuranceCompanyTypes' => [
        '102113' => "כלל",
        '102114' => "הראל",
        '102115' => "איילון",
        '102116' => "הכשרה",
        '102117' => "הפניקס",
        '102118' => "איילון",
    ],

    'sellerName' =>[
        "104606" => "מוכרן מקורי",
        "104605"=>"יהונתן שורקי",
        "107465"=>"שלי לוייב",
        "107466"=>"בן אסרף",
     ],

    'hitumTypes' =>[
        '102134' => 'ירוק',
        '102135' => 'אדום'
    ],
    'callCenterManagerMail' => [
        'מיטל כהן' => "Meital.c@tgeg.co.il",
        'יוני מידן'=> "yoni@ezfind.co.il",
        'אלי ברי' => "Eli@bolotin.co.il"
    ],
    'callCenterManagerName' =>[
        'איזי_ביטוח' => "יוני מידן",
        'אלעד_שמעוני' => "מיטל כהן",
        'בולוטין' => "אלי ברי",
    ],
    'mochranMeshamer'=>[
        '104606' => 'מוכרן מקורי',
        '104605' => 'יהונתן שורקי',
        '107465' => 'שלי לוייב',
        '107466' => 'בן אסרף'
    ],
    //in crm  value from sugcisuy (section:bakasha lbitul polica)is diffrent from value from sugPolica (section:pertey polica)
    'compareSugPolicaAndSugCisuy'=>[
        //sugPolica => sugcisuy
        102106 => 103715,//אובדן כושר עבודה
        102105 => 103702,//תאונות אישיות
        102107 => 103707,//מחלות קשות
        102108 => 103704, //חיים
        102110 => 103705,//ביטוח משכנא
        102109 => 103703, //בריאות
        102111 => 103706  //סיעודי
    ]
];
?>