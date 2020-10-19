<?php
session_start();
if (isset($_SESSION['UserName'])){
    $pageTitle = 'Members';
    include 'init.php';
    $do = isset($_GET['do'])? $_GET['do'] : 'manage';
    if ($do == 'manage'){
        // start manage page
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
            echo ' there is no user with this id';
        }
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

        }
    }

}else{
    header('Location: index.php');
}

include $temps . 'footer.php';