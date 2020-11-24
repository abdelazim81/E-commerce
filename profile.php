<?php
$pageTitle = 'Profile';
include 'init.php';
session_start();
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
include 'includes/temps/footer.php';
