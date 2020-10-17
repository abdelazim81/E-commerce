<?php
function lang($phrase){
    static $lang = array(
        // Navbar
        'home' => 'الرئيسيه',
        'categories'   => 'الانواع',
        'items'=> 'العناصر',
        'members'=>'الاعضاء',
        'statistics'=>'الاحصائيات',
        'logs'=>'السجلات',
        'editProfile'=> 'تعديل الملف الشخصى',
        'settings'=>'الاعدادات',
        'logout'=>'الخروج',

    );
    return $lang[$phrase];
}