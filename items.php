<?php
$pageTitle = 'Profile';
include 'init.php';
if (isset($_GET['itemID'])){
    $itemID = is_numeric($_GET['itemID']) ? $_GET['itemID'] : 0;
    $selectItemStmt = "SELECT items.*, users.UserName AS userName, categories.Name AS categoryName FROM items
                        INNER JOIN users ON users.UserID=items.Member_ID
                        INNER JOIN categories ON categories.ID=items.Cat_ID
                        WHERE Item_ID='$itemID'";
    $selectItemResult = mysqli_query($connection,$selectItemStmt);
    $count = $selectItemResult->num_rows;
    if ($count < 1){
        errorDisplay(array('No Such ID'));
    }else{
        /*get date this id is valid*/
        $item = $selectItemResult->fetch_assoc();
        ?>
        <!--DISPLAY ITEM INFORMATION-->
<h1 class="text-center"><?php echo $item['Item_Name']; ?></h1>
        <div class="container">
            <!--show item information-->
            <div class="row">
                <div class="col-md-3">
                    <img class="img-thumbnail align-content-center" width="200" height="200" src="layouts/images/avatar01.jpg" alt="<?php echo $item['Item_Name'];?>">
                </div>
                <div class="col-md-9 item-info">
                    <h3><?php echo $item['Item_Name'];?></h3>
                    <p class="text-justify"><?php echo $item['Item_Desc'];?></p>
                    <ul class="list-unstyled">
                        <li>
                            <i class="fas fa-dollar-sign fa-fw"></i>
                            <span>Price</span>:
                            <?php echo $item['Item_Price'];?>
                        </li>
                        <li>
                            <i class="fas fa-calendar fa-fw"></i>
                            <span>Date</span>:
                            <?php echo $item['Item_Date'];?>
                        </li>
                        <li>
                            <i class="fas fa-flag fa-fw"></i>
                            <span>Country</span>:
                            <?php echo $item['Item_Country'];?>
                        </li>
                        <li>
                            <i class="fas fa-tag fa-fw"></i>
                            <span>Category</span>:
                            <a href="categories.php?catID=<?php echo $item['Cat_ID'];?>&catName=<?php echo $item['categoryName'];?>"><?php echo $item['categoryName'];?></a>
                        </li>
                        <li>
                            <i class="fas fa-user fa-fw"></i>
                            <span>User</span>:
                            <a href="#"><?php echo $item['userName'];?></a>
                        </li>
                    </ul>

                </div>
            </div>
            <!--end item information-->
            <hr class="custom-hr">
            <!--start commenting section-->
            <div class="row">
                <div class="col-md-3">
                    image
                </div>
                <div class="col-md-9">
                    comment
                </div>
            </div>
            <!--end commenting section-->
        </div>
<?php
    }
include 'includes/temps/footer.php';
}else{
    header("Location: index.php");
}

