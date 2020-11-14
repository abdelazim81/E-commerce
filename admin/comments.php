<?php
session_start();
if (isset($_SESSION['UserName'])) {
    $pageTitle = 'Comments';
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
    if ($do == 'manage') {
        // start manage page
        $allCommentsFromDB = "SELECT comments.*, items.Item_Name, users.UserName FROM comments
                              INNER JOIN items ON items.Item_ID=comments.item_id
                              INNER JOIN users ON users.UserID=comments.user_id";
        $result = mysqli_query($connection,$allCommentsFromDB);
        if ($result) {


            // table to show all comments
            ?>


            <div class="container">
                <h1 class="text-center">Manage Comments</h1>
                <table class="table members-table table-responsive table-hover text-center">
                    <tr>
                        <th>#ID</th>
                        <th>Comment</th>
                        <th>Item</th>
                        <th>User</th>
                        <th>Date</th>
                        <th>Control</th>
                    </tr>
                    <?php while($rows = mysqli_fetch_assoc($result)){ ?>
                        <tr>
                            <td><?php echo $rows['comment_id'];?></td>
                            <td><?php echo $rows['comment'];?></td>
                            <td><?php echo $rows['Item_Name'];?></td>
                            <td><?php echo $rows['UserName'];?></td>
                            <td><?php echo $rows['comment_date'];?></td>
                            <td>
                                <div class="btn-group link-group">
                                    <a href="comments.php?do=Edit&ComID=<?php echo $rows['comment_id'];?>" class="btn btn-warning">Update <i class="fas fa-user-edit"></i></a>
                                    <a href="comments.php?do=Delete&ComID=<?php echo $rows['comment_id'];?>" class="btn btn-danger confirm">Delete <i class="fas fa-trash"></i></a>
                                    <?php
                                    if ($rows['status'] == 0){
                                        echo "<a href='comments.php?do=Approve&ComID=" . $rows['comment_id'] . "' class='btn btn-info'> Approve  <i class='fas fa-hand-pointer'></i></a>";
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                    <?php }?>
                </table>
            </div>

            <?php
        }
    }elseif ($do =='Edit'){
        //start Edit Page


        //check if comment id is exist and is numeric
        $ComID = isset($_GET['ComID']) && is_numeric($_GET['ComID']) ? intval($_GET['ComID']) : 0;

        // fetch comment By Id
        $getComWithId = "SELECT * FROM comments WHERE comment_id = '$ComID' LIMIT 1";
        $result  = mysqli_query($connection,$getComWithId);
        if($row = mysqli_fetch_assoc($result)){
            $ComID    = $row['comment_id'] ;
            $comment  = $row['comment'];


        }else{
            $errors = array( ' there is no user with this id');
            errorDisplay($errors);
        }
        //form to edit user
        ?>
        <div class="edit-user-form" style="margin-left: -1770px;margin-top: 25px">
            <div class="container">
                <h1 class="text-center">Edit Comment</h1>
                <form method="post" action="?do=Update" class="form edit-form">
                    <div class="form-group ">
                        <input type="hidden" name="ComID" value="<?php echo $ComID;?>">
                        <div class="col-md-4">
                            <label for="Comment">Comment</label>
                        </div>
                        <div class="col-md-6">
                            <textarea name="comment" class="form-control">
                                <?php echo $comment;?>
                            </textarea>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <button type="submit" name="editComment" class="btn btn-success btn-lg">Save <i class="fas fa-save"></i></button>
                    </div>

                </form>
            </div>
        </div>
        <?php
    }elseif ($do == 'Update'){
        // start update user info page
        echo "<h1 class='text-center'> Update Comment </h1> ";
        if (isset($_POST['editComment'])){
            $ComID = $_POST['ComID'];
            $comment= $_POST['comment'];
             $UpdateUserInfo = "UPDATE comments SET comment='$comment'  WHERE comment_id='$ComID'";
                        $flag = mysqli_query($connection,$UpdateUserInfo);
                        if ($flag){
                            successDisplay("Information Updated Successfully");
                            header('refresh:2;url=comments.php');
                        }else{
                            $errors = array("Information Updated Failed");
                            errorDisplay($errors);
                        }

        }else{
            errorDisplay(array("You Can\'t Get This Page Directly"));
            header('refresh:2;url=index.php');
        }
    }elseif ($do == 'Delete'){
        // start Delete Page
        if (isset($_GET['ComID'])){
            $ComID = $_GET['ComID'];
            $deleteCommentQuery = "DELETE FROM comments WHERE comment_id='$ComID'";
            $flag = mysqli_query($connection,$deleteCommentQuery);
            if ($flag){
                successDisplay("Deleted");
                header("refresh: 1;url=comments.php");
            }else{
                errorDisplay(array('Cannot Delete A User'));
                header("refresh: 1;url=index.php");
            }
        }else{
            errorDisplay(array("You Can\'t Get This Page Directly"));
            header('refresh:5;url=index.php');
        }
    }elseif ($do == "Approve"){
        // start Activate Page
        if (isset($_GET['ComID'])){
            $ComID = intval($_GET['ComID']);
            $activateQuery = "UPDATE comments SET status=1 WHERE comment_id='$ComID'";
            $result = mysqli_query($connection,$activateQuery);
            if (!$result){
                errorDisplay(array("Cannot Perform Activate Processing"));
                header("refresh: 1;url=index.php");
            }else{
                successDisplay("Activated");
                header("refresh: 1;url=comments.php");
            }
        }else{
            errorDisplay(array("You Can\'t Get This Page Directly"));
            header('refresh:2;url=index.php');
        }
    }
    include $temps . 'footer.php';
}


else{
    header('Location: index.php');
    exit();
}
