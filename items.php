<?php
$pageTitle = 'Profile';
include 'init.php';
if (isset($_GET['itemID'])){
    $itemID = is_numeric($_GET['itemID']) ? $_GET['itemID'] : 0;
    $selectItemStmt = "SELECT * FROM items WHERE Item_ID='$itemID'";
    $selectItemResult = mysqli_query($connection,$selectItemStmt);
    $count = $selectItemResult->num_rows;
    if ($count < 1){
        errorDisplay(array('No Such ID'));
    }else{
        /*get date this id is valid*/
        $row = $selectItemResult->fetch_assoc();
        echo $row['Item_Name'];
    }
?>
<h1></h1>
<?php
include 'includes/temps/footer.php';
}else{
    header("Location: index.php");
}

