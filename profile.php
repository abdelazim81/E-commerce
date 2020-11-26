<?php
$pageTitle = 'Profile';
include 'init.php';
if (isset($_SESSION['userName'])){
    // if there is session so the user logged in, display his profile
    $userName = $_SESSION['userName'];
    $selectUserStmt = "SELECT * FROM users WHERE UserName = '$userName'";
    $result = mysqli_query($connection, $selectUserStmt);
    $user = $result->fetch_assoc();
?>
<h1 class="text-center ">Welcome <?php echo $_SESSION['userName'];?></h1>


<!--START INFORMATION CARD-->
<div class="inforamtion block">
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                Basic Information <i class="fas fa-info"></i>
            </div>
            <div class="card-body">
                <span>Name : </span><span> <?php echo $user['UserName'];?> </span>
                <hr>
                <span>Email : </span><span> <?php echo $user['Email'];?> </span>
                <hr>
                <span>Full Name : </span><span> <?php echo $user['FullName'];?> </span>
            </div>
        </div>
    </div>
</div>
<!--END INFORMATION CARD-->


    <!--START ADS CARD-->
    <div class="ads block">
        <div class="container">
            <div class="card">
                <div class="card-header text-center">
                    My Ads <i class="fas fa-ad"></i>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php
                        $items = getItems('Member_ID',$user['UserID']);
                        $itemsCount = $items->num_rows;
                        if ($itemsCount < 1){
                            echo 'There Is No Ads To Display';
                        }else{
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
                            <?php } }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--END ADS CARD-->


    <!--START INFORMATION CARD-->
    <div class="comments block">
        <div class="container">
            <div class="card">
                <div class="card-header text-center">
                    Latest Comments <i class="fas fa-comments"></i>
                </div>
                <div class="card-body">
                    <?php
                        $user_id = $user['UserID'];
                        $getComments = "SELECT comment FROM comments WHERE user_id='$user_id'";
                        $commentsResult = mysqli_query($connection, $getComments);
                        $count = $commentsResult->num_rows;
                        if ( $count <1) {
                            echo 'There Is No Comments To Show';
                        }else{
                            while($comment = mysqli_fetch_assoc($commentsResult)){

                                echo "<p>" . $comment['comment'] . "</p>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!--END INFORMATION CARD-->
<?php
} else{
    // if there is no session so this user need to login
    header("Location: login.php");
    exit();
}
include 'includes/temps/footer.php';
