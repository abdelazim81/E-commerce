<?php
$temps = 'includes/temps/';              // templates directory
$css   = './layouts/css/';                 // css dir
$js    = 'layouts/js/';                  // js dir
$langs = 'includes/langs/';              // languages dir
$funcs = 'includes/funcs/';
session_start();
$sessionUserName = isset($_SESSION['userName']) ? $_SESSION['userName'] : "";
include 'admin/connect.php';
include $funcs . 'functions.php';
include $temps .'header.php';
include $langs . 'english.php';
include $temps . 'navbar.php';





