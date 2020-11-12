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


            // table to show all members
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
                            <td><?php echo $rows['Item_Name'];?></td>
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


        //check if user id is exist and is numeric
        $UserID = isset($_GET['UserID']) && is_numeric($_GET['UserID']) ? intval($_GET['UserID']) : 0;

        // fetch user By Id
        $getUserWithId = "SELECT * FROM users WHERE UserID = '$UserID' LIMIT 1";
        $result  = mysqli_query($connection,$getUserWithId);
        if($row = mysqli_fetch_assoc($result)){
            $UserName = $row['UserName'] ;
            $Email= $row['Email'];
            $Password = $row['Password'];
            $FullName= $row['FullName'];

        }else{
            $errors = array( ' there is no user with this id');
            errorDisplay($errors);
        }
        //form to edit user
        ?>
        <div class="edit-user-form" style="margin-left: -1770px;margin-top: 25px">
            <div class="container">
                <h1 class="text-center">Edit Page</h1>
                <form method="post" action="?do=Update" class="form edit-form">
                    <div class="form-group ">
                        <input type="hidden" name="UserID" value="<?php echo $UserID;?>">
                        <div class="col-md-4">
                            <label for="UserName">UserName</label>
                        </div>
                        <div class="col-md-6">
                            <input value="<?php echo $UserName;?>" type="text" name="UserName" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <label for="Password">Password</label>
                        </div>
                        <div class="col-md-6">
                            <input type="hidden" name="OldPassword" value="<?php echo $Password; ?> ">
                            <input autocomplete="new-password" type="password" name="Password" value="" class="form-control" placeholder="Leave Blank if you don't need to change it">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <label for="Email">Email</label>
                        </div>
                        <div class="col-md-6">
                            <input value="<?php echo $Email;?>" type="email" name="Email" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <label for="FullName">FullName</label>
                        </div>
                        <div class="col-md-6">
                            <input value="<?php echo $FullName;?>" type="text" name="FullName" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <button type="submit" name="editUser" class="btn btn-success btn-lg">Save <i class="fas fa-save"></i></button>
                        <button type="reset"  class="btn btn-warning btn-lg">Reset <i class="fas fa-redo"></i></button>
                    </div>

                </form>
            </div>
        </div>
        <?php
    }elseif ($do == 'Update'){
        // start update user info page
        echo "<h1 class='text-center'> Update Page </h1> ";
        if (isset($_POST['editUser'])){
            $UserID = $_POST['UserID'];
            $UserName= $_POST['UserName'];
            $Password ='';
            $Email = $_POST['Email'];
            $FullName = $_POST['FullName'];
            $errors = array();
            // if user name is empty
            if(empty($UserName)){
                $errors[] = "User Name should Not Be Empty";
            }
            //if user full name is empty
            if (empty($FullName)){
                $errors[] = "User Full Name should Not Be Empty";
            }
            // if user email is empty
            if (empty($Email)){
                $errors[] = "User Email should Not Be Empty";
            }
            if(empty($_POST['Password'])){
                $Password = $_POST['OldPassword'];
            }else{
                $Password = $_POST['Password'];
            }
            if (count($errors)>0){
                errorDisplay($errors);
            }else{
                $checkNameQuery = "SELECT UserName FROM users WHERE UserName='$UserName'";
                $result = mysqli_query($connection,$checkNameQuery);
                if ($result){
                    $rows = mysqli_fetch_assoc($result);
                    if (count($rows)>0){
                        errorDisplay(array('This User Name Exist Try Another One'));
                    }else{
                        $UpdateUserInfo = "UPDATE users SET UserName='$UserName', Email='$Email', FullName='$FullName', 
                              Password='$Password' WHERE UserID='$UserID'";
                        $flag = mysqli_query($connection,$UpdateUserInfo);
                        if ($flag){
                            successDisplay("Information Updated Successfully");
                        }else{
                            $errors = array("Information Updated Failed");
                            errorDisplay($errors);
                        }
                    }

                }else{
                    errorDisplay(array('Cannot select user name to check'));
                }
            }

        }else{
            errorDisplay(array("You Can\'t Get This Page Directly"));
            header('refresh:5;url=index.php');
        }
    }elseif ($do == 'Delete'){
        // start Delete Page
        if (isset($_GET['UserID'])){
            $UserID = $_GET['UserID'];
            $deleteUserQuery = "DELETE FROM users WHERE UserID='$UserID'";
            $flag = mysqli_query($connection,$deleteUserQuery);
            if ($flag){
                header('Location: members.php');
            }else{
                $errors = array('Cannot Delete A User');
                errorDisplay($errors);
            }
        }else{
            errorDisplay(array("You Can\'t Get This Page Directly"));
            header('refresh:5;url=index.php');
        }
    } elseif ($do == 'Pending'){
        // Display Pended Users
        $allUsersFromDB = "SELECT * FROM users WHERE RegStatus = 0";
        $result = mysqli_query($connection,$allUsersFromDB);
        if ($result) {


            // table to show all pending members
            ?>


            <div class="container">
                <h1 class="text-center">Manage Member</h1>
                <table class="table members-table table-responsive table-hover text-center">
                    <tr>
                        <th>#ID</th>
                        <th>UserName</th>
                        <th>Password</th>
                        <th>Email</th>
                        <th>FullName</th>
                        <th>Registered Date</th>
                        <th>Control</th>
                    </tr>
                    <?php while($rows = mysqli_fetch_assoc($result)){ ?>
                        <tr>
                            <td><?php echo $rows['UserID'];?></td>
                            <td><?php echo $rows['UserName'];?></td>
                            <td><?php echo $rows['Password'];?></td>
                            <td><?php echo $rows['Email'];?></td>
                            <td><?php echo $rows['FullName'];?></td>
                            <td><?php echo $rows['Date'];?></td>
                            <td>
                                <div class="btn-group link-group">
                                    <a href="members.php?do=Edit&UserID=<?php echo $rows['UserID'];?>" class="btn btn-warning">Update <i class="fas fa-user-edit"></i></a>
                                    <a href="members.php?do=Delete&UserID=<?php echo $rows['UserID'];?>" class="btn btn-danger confirm">Delete <i class="fas fa-trash"></i></a>
                                    <a href="members.php?do=Activate&UserID=<?php echo $rows['UserID'];?>" class="btn btn-info">Activate <i class="fas fa-hand-pointer"></i> </a>
                                </div>
                            </td>
                        </tr>
                    <?php }?>
                </table>

            </div>

            <?php
        }

    }elseif ($do == "Approve"){
        // start Activate Page
        if (isset($_GET['UserID'])){
            $UserID = intval($_GET['UserID']);
            $activateQuery = "UPDATE users SET RegStatus=1 WHERE UserID='$UserID'";
            $result = mysqli_query($connection,$activateQuery);
            if (!$result){
                errorDisplay(array("Cannot Perform Activate Processing"));
            }else{
                successDisplay("Activated");
                successDisplay("You Will Be redirected After 3 seconds");
                header("refresh: 3;url=index.php");
            }
        }else{
            errorDisplay(array("You Can\'t Get This Page Directly"));
            header('refresh:5;url=index.php');
        }
    }
    include $temps . 'footer.php';
}


else{
    header('Location: index.php');
    exit();
}
