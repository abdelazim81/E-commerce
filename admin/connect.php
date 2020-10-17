
<?php
$connection = @mysqli_connect('localhost', 'root', '', 'shop');
if(!$connection){
    echo 'you are not connected';
}
?>
