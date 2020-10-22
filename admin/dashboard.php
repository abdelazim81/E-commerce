<?php
session_start();
if(isset($_SESSION['UserName'])){
    $pageTitle = 'Dashboard';
    include 'init.php';
    ?>
    <!--html of dashboard-->
    <section class="home-stat text-center">
        <div class="container">
            <h1>Dashboard</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat st-members" >
                        Total Members
                        <span ><a href="members.php?do=Pending"><?php echo getUsersCount('UserID','users');?></a></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-pending" >
                        Pending Members
                        <span >25</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-items" >
                        Total Items
                        <span >1500</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-comments" >
                        Total Comments
                        <span >3500</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="latest">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel-head text-center" >
                        <i class="fas fa-users"></i> Latest Registered User
                    </div>
                    <div class="panel-body" >
                        Bla Bla Bla
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel-head text-center" >
                        <i class="fas fa-tags"></i> Latest Items
                    </div>
                    <div class="panel-body" >
                        Bla Bla Bla
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
}else{
    header('Location: index.php');
}
include $temps . 'footer.php';