<?php
function lang($phrase){
    static $lang = array(
        // Navbar
        'home'              => 'Home',
        'categories'        => 'Categories',
        'items'             => 'Items',
        'members'           =>'Members',
        'statistics'        =>'Statistics',
        'comments'          => 'Comments',
        'logs'              =>'Logs',
        'editProfile'       => 'Edit Profile',
        'settings'          =>'Settings',
        'logout'            =>'Log Out',

    );
    return $lang[$phrase];
}