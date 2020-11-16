<?php
$pageTitle = 'Login';
include 'init.php';
?>
<div class="container login-page">
    <!--header of login page-->
    <h3 class="text-center">
        <span data-class="login" class="selected">LogIn</span>
        <span> | </span>
        <span data-class="signup">SignUp</span>
    </h3>
    <!--end of header of login page-->

    <!--Start login form-->
    <form class="login">
        <input class="form-control" type="text" name="username" placeholder="User Name" autocomplete="off" required>
        <input class="form-control" type="password" name="password" placeholder="password" autocomplete="new-password" required>
        <input type="submit" class="btn btn-primary btn-block" name="login" value="LogIn">
    </form>
    <!--End login form-->

    <!--sign up form-->
    <form class="signup">
        <input class="form-control" type="text" name="username" placeholder="User Name" autocomplete="off" required>
        <input class="form-control" type="email" name="email" placeholder="Enter Valid Email" autocomplete required>
        <input class="form-control" type="password" name="password" placeholder="Enter Complex Password" autocomplete="new-password" required>
        <input type="submit" class="btn btn-info btn-block" name="signup" value="SignUp">
    </form>
    <!--end sign up form-->
</div>
<?php
    include $temps . 'footer.php';
?>
