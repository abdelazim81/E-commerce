<!--login logic-->
<?php
if ( isset($_SESSION['userName']) ){
    // if there is session
    $unactivatedUsers =  getUnactivatedUserCount($_SESSION['userName']);
    if ($unactivatedUsers == 1){
        // when user is not activated
    }
    ?>
    <div class="container">
        <div class="upper-bar">
            <span><?php echo ' Welcome ' . $_SESSION['userName'];?></span>
            <span><a class=" logout btn btn-danger" href="logout.php">LogOut</a></span>
            <span><a class="profile btn btn-info" href="profile.php">Profile</a></span>
        </div>
    </div>
    <?php
}else{
    // if there is no session
    ?>
    <div class="container">
        <div class="upper-bar">
            <span><a class="login-signup btn btn-success" href="login.php">Login | SingUp</a></span>
        </div>
    </div>
    <?php
}
?>


<!--End login Logic-->
