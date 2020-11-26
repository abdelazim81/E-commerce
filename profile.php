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
