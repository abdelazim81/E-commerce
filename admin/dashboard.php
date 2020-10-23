<?php
session_start();
if(isset($_SESSION['UserName'])){
    $pageTitle = 'Dashboard';
    include 'init.php';
    $LatestUsersLimit = 5;
    $LatestUsers =  getLatest('UserName','users','UserID',$LatestUsersLimit);
    ?>
    <!--html of dashboard-->
    <section class="home-stat text-center">
        <div class="container">
            <h1>Dashboard</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat st-members" >
                        Total Members
                        <span ><a href="members.php?do=manage"><?php echo getUsersCount('UserID','users');?></a></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-pending" >
                        Pending Members
                        <span ><a href="members.php?do=Pending"><?php echo getPendingUsersCount('UserID','users',0)?></a></span>
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
                        <i class="fas fa-users"></i> Latest <?php echo $LatestUsersLimit;?> Registered User
                    </div>
                    <div class="panel-body" >
                       <?php
                       while ($row = mysqli_fetch_assoc($LatestUsers)){
                           echo $row['UserName'] . '<br>';
                       }
                       ?>
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