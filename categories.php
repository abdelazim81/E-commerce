<?php
    $pageTitle = isset($_GET['catName']) ? $_GET['catName'] : "Categories";
    include 'init.php';
    if (isset($_GET['catID']) && isset($_GET['catName'])){
?>

<div class="container">
    <h1 class="text-center"><?php echo str_replace('-',' ',$_GET['catName']);?></h1>
    <div class="row">
    <?php
    $items = getItems('Cat_ID',$_GET['catID']);
    while ($item = mysqli_fetch_assoc($items)){
        ?>
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail item-box">
                <span class="price-tag"><?php echo $item['Item_Price'];?></span>
                <img width="200" height="200" src="layouts/images/avatar01.jpg" alt="<?php echo $item['Item_Name'];?>">
                <div class="figure-caption">
                    <h3><?php echo $item['Item_Name'];?></h3>
                    <p><?php echo $item['Item_Desc'];?></p>
                </div>
            </div>
        </div>
   <?php }?>


    </div>
</div>
<?php
}
include $temps . 'footer.php';
?>
