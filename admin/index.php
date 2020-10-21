<?php
session_start();
$pageTitle = 'Login';
include 'init.php';
if (isset($_SESSION['UserName'])){
    header('Location: dashboard.php');
}
if (isset($_POST['login'])){
 $user_name = $_POST['UserName'];
 $password  = $_POST['UserPassword'];
 $user_query = "SELECT UserID, UserName, Password FROM users WHERE UserName='$user_name' ";
 $user_query .= "And Password='$password' And GroupID = 1 LIMIT 1 ";
 $user_query_result = mysqli_query($connection,$user_query);
 if($rows = mysqli_fetch_assoc($user_query_result)){
     $_SESSION['UserName'] = $user_name;
     $_SESSION['UserID'] = $rows['UserID'];
     header('Location: dashboard.php');
 }
}
?>

    <div class="login-form text-center">
        <form  method="post" class="form" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <h3 class="text-center">Login Form</h3>
            <div class="form-group ">
                <input type="text" class="form-control" name="UserName" placeholder="Enter User Name!" required>
            </div>
            <div class="form-group">
                <input autocomplete="off" type="password" name="UserPassword"  class="form-control" placeholder="Enter Your Password Here!">
            </div>
            <button type="submit" name="login" class="btn btn-primary">Submit</button>
        </form>
    </div>

<?php include $temps . 'footer.php' ?>