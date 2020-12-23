<?php
$pageTitle = 'Home';
include 'init.php';
$getAllItems = "SELECT * FROM items WHERE Approve=1 ORDER BY Item_ID DESC";
$items = mysqli_query($connection,$getAllItems);
if (! $items){
    errorDisplay(array("Cannot get items"));
}else{
    ?>

<div class="ads">
    <div class="container">
        <div class="row">
            <?php
            while($item = mysqli_fetch_assoc($items)){
                ?>
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail item-box">
                        <span class="price-tag"><?php echo $item['Item_Price'];?></span>
                        <img width="200" height="200" src="layouts/images/avatar01.jpg" alt="<?php echo $item['Item_Name'];?>">
                        <div class="figure-caption">
                            <h3><a href="items.php?itemID=<?php echo $item['Item_ID'];?>"><?php echo $item['Item_Name'];?></a></h3>
                            <p><?php echo $item['Item_Desc'];?></p>
                            <p class="date"> <?php echo $item['Item_Date'];?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php
}
include $temps . 'footer.php'
?>