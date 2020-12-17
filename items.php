<?php
$pageTitle = 'Profile';
include 'init.php';
if (isset($_GET['itemID'])){
    $itemID = is_numeric($_GET['itemID']) ? $_GET['itemID'] : 0;
    $selectItemStmt = "SELECT items.*, users.UserName AS userName, categories.Name AS categoryName FROM items
                        INNER JOIN users ON users.UserID=items.Member_ID
                        INNER JOIN categories ON categories.ID=items.Cat_ID
                        WHERE Item_ID='$itemID' AND Approve=1";
    $selectItemResult = mysqli_query($connection,$selectItemStmt);
    $count = $selectItemResult->num_rows;
    if ($count < 1){
        errorDisplay(array('No Such ID Or This Item Waiting Approval'));
    }else{
        /*get date this id is valid*/
        $item = $selectItemResult->fetch_assoc();
        $item_id = $item['Item_ID'];
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
                    <p class="lead"><?php echo $item['Item_Desc'];?></p>
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
            <div class="row commenting-area">
        <?php if (isset($_SESSION['userName'])){?>
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <div class="comment">
                        <h3>Add Comment</h3>
                        <form action="items.php?itemID=<?php echo $_GET['itemID'];?>" method="post">
                            <textarea name="comment"  cols="25" rows="7" class="form-control"></textarea>

                            <input name="addComment" type="submit" value="Add Comment" class="btn btn-outline-primary">
                        </form>
                    </div>
                </div>
            <?php


            //insert comment into database
            if (isset($_POST['addComment'])){
                $comment = filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
                $user_id = $_SESSION['uid'];
                if (! empty($comment)){
                    $insertCommentStmt = "INSERT INTO comments (comment,status,comment_date,item_id,user_id)
                                      VALUES ('$comment',0,now(),'$item_id','$user_id')";
                    $insertCommentResult = mysqli_query($connection, $insertCommentStmt);
                    if ($insertCommentResult){
                        successDisplay('Comment Added Successfully');
                    }else{
                        errorDisplay(array('Cannot Add Comment'));
                    }
                }

            }


        }else{?>

            <!--IF THE USER IS NOT LOGIN -->
            <div class="col-md-9">
                <div class="comment">
                    <h3>Please <a href="login.php">login</a> or <a href="login.php">register</a> to add a comment</h3>

                </div>
            </div>

<?php } ?>

            </div>
            <!--end commenting section-->



            <!--start displaying comments section-->
            <hr class="custom-hr">
            <?php
            $getAllComments = "SELECT comments.*, users.UserName FROM comments
                               INNER JOIN users
                               ON users.UserID=comments.user_id
                               WHERE comments.status=1 AND  comments.item_id='$item_id'
                               ORDER BY comments.comment_id DESC";
            $comments = mysqli_query($connection, $getAllComments);
            if (! $comments){
                errorDisplay(array('cannot get comments'));
            }else{
                while ($comment = mysqli_fetch_assoc($comments)){
                   ?>

                    <div class="comment-box">
                        <div class="row">
                            <div class="col-md-3">
                                <img class="img-thumbnail d-block rounded-circle" width="200" height="200"
                                     src="layouts/images/avatar01.jpg" alt="<?php echo $comment['UserName'];?>">
                                <p class="text-center"><?php echo $comment['UserName']; ?></p>
                            </div>
                            <div class="col-md-9">
                                <p class="lead"><?php echo $comment['comment']; ?></p>
                            </div>
                        </div>
                    </div>

                    <hr class="custom-hr">
                    <?php
                }
            }
            ?>
            <!--end displaying comments section-->





        </div><!--end container-->
<?php
    }
include 'includes/temps/footer.php';
}else{
    header("Location: index.php");
}

