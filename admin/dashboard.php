<?php
session_start();
if(isset($_SESSION['UserName'])){
    $pageTitle = 'Dashboard';
    include 'init.php';
}else{
    header('Location: index.php');
}
include $temps . 'footer.php';