<?php include 'init.php'?>
<h1 class="text-center"><?php echo str_replace('-',' ',$_GET['catName']);?></h1>

<?php
$items = getItems($_GET['catID']);
while ($item = mysqli_fetch_assoc($items)){
    echo $item['Item_Name'] . "<br>";
}
include $temps . 'footer.php';
