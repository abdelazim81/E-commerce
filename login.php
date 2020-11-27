<?php
$pageTitle = 'Login';
include 'init.php';
        // if there is a session go to home page
if (isset($_SESSION['userName'])){
    header('location: index.php');
}

if (isset($_POST['login'])){
    $userName = $_POST['username'];
    $password = $_POST['password'];
    global $connection;
    $query = "SELECT COUNT(UserID) FROM users 
              WHERE UserName='$userName' 
              AND Password='$password'";
    $result = mysqli_query($connection,$query);
    $row = $result->fetch_row();
    $count =  $row[0];
    if ($count == 1){
        $_SESSION['userName'] = $userName;
        header('location: index.php');
    }

}elseif (isset($_POST['signup'])){
    $user_name     = $_POST['username'];
    $user_email    = $_POST['email'];
    $user_password = $_POST['password'];
    $formErrors = array();
    // user name validation
    if (isset($_POST['username'])){
        $user_name = filter_var($user_name, FILTER_SANITIZE_STRING);
        if (strlen($user_name)<3){
            $formErrors[] = "Your name must be 3 character at least";
        }
    }else{
        $formErrors[] = "You must enter your user name";
    }

    // user email validation
    if (isset($user_email) && !empty($user_email)){
        $user_email = filter_var($user_email, FILTER_SANITIZE_EMAIL);
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) != true){
            $formErrors[] = "You must enter valid email";
        }
    }else{
        $formErrors[] = "You must enter valid email";
    }


    // user password validation
    if (empty($user_password)){
        $formErrors[] = "You must enter a complex password";
    }
    if (strlen($user_password) < 8){
        $formErrors[] = "You must enter a complex password consists of 8 character, special character, or numbers at least ";
    }


    // if there is no errors
    if (empty($formErrors)){
        $user_name_count_stmt = "SELECT UserName FROM users WHERE UserName='$user_name'";
        $users_count_result   = mysqli_query($connection, $user_name_count_stmt);
        $user_name_count      = $users_count_result->num_rows;
        if ($user_name_count > 0) {
            $formErrors[] = "This User Name Is Exist, Try Another One";
        }else{
        // adding user
            $add_user_stmt = "INSERT INTO users(UserName,Password,Email,RegStatus,Date) 
                                  VALUES('$user_name','$user_password','$user_email', 0 ,now() )";
            $add_user_flag = mysqli_query($connection,$add_user_stmt);
            if (!$add_user_flag){
                $formErrors[] = "This User Can\'t Be Added";
            }
        }
    }
}
?>
<div class="container login-page">
    <!--header of login page-->
    <h3 class="text-center">
        <span id="login" class="selected">LogIn</span>
        <span> | </span>
        <span  id="signup">SignUp</span>
    </h3>
    <!--end of header of login page-->

    <!--Start login form-->
    <form class="login" method="post" action="login.php">
        <input class="form-control" type="text" name="username" placeholder="User Name" autocomplete="off" required>
        <input class="form-control" type="password" name="password" placeholder="password" autocomplete="new-password" required>
        <input type="submit" class="btn btn-primary btn-block" name="login" value="LogIn">
    </form>
    <!--End login form-->

    <!--sign up form-->
    <form class="signup" action="login.php" method="post">
        <input class="form-control" type="text" name="username" placeholder="User Name" autocomplete="off" pattern=".{3,}" title="Your User Name Must Be At Least 3 Chars" required>
        <input class="form-control" type="email" name="email" placeholder="Enter Valid Email" autocomplete required>
        <input class="form-control" type="password" name="password" placeholder="Enter Complex Password" autocomplete="new-password" minlength="8" required>
        <input type="submit" class="btn btn-info btn-block" name="signup" value="SignUp">
    </form>
    <!--end sign up form-->

    <div class="the-errors">
        <?php
            if (isset($formErrors)){
                if (empty($formErrors)){
                    successDisplay("You signed up successfully");
                }else{
                    errorDisplay($formErrors);
                }
            }

        ?>
    </div>
</div>
<?php
    include $temps . 'footer.php';
?>
