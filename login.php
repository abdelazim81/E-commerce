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
    $user_password = $_POST['password'];
    $formErrors = array();
    // user name validation
    if (isset($_POST['username'])){
        $user_name = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        if (strlen($user_name)<3){
            $formErrors[] = "Your name must be 3 character at least";
        }
    }else{
        $formErrors[] = "You must enter your user name";
    }

    // user email validation
    if (isset($_POST['email']) && !empty($_POST['email'])){
        $user_name = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    }else{
        $formErrors[] = "You must enter valid email";
    }


    // user password validation
    if (empty($_POST['password'])){
        $formErrors[] = "You must enter a complex password";
    }
    if (strlen($_POST['password']) < 8){
        $formErrors[] = "You must enter a complex password consists of 8 character, special character, or numbers at least ";
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
        <input class="form-control" type="text" name="username" placeholder="User Name" autocomplete="off" >
        <input class="form-control" type="email" name="email" placeholder="Enter Valid Email" autocomplete >
        <input class="form-control" type="password" name="password" placeholder="Enter Complex Password" autocomplete="new-password" >
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
