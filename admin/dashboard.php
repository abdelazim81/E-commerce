<?php
session_start();
if(isset($_SESSION['UserName'])){
    $pageTitle = 'Dashboard';
    include 'init.php';
    $LatestUsersLimit = 3;
    $LatestItemsLimit = 3;
    $LatestUsers =  getLatest('*','users','UserID',$LatestUsersLimit);
    $LatestItems =  getLatest('*','items','Item_ID',$LatestItemsLimit);
    ?>
    <!--html of dashboard-->
    <section class="home-stat text-center">
        <div class="container">
            <h1>Dashboard</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat st-members" >
                        <i class="fas fa-users icon"></i>
                        <div class="info">
                            Total Members
                            <span ><a href="members.php?do=manage"><?php echo getItemsCount('UserID','users');?></a></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-pending" >
                        <i class="fas fa-user-plus icon"></i>
                        <div class="info">
                            Pending Members
                            <span ><a href="members.php?do=Pending"><?php echo getPendingUsersCount('UserID','users',0)?></a></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-items" >
                        <i class="fas fa-tags icon"></i>
                        <div class="info">
                            Total Items
                            <span ><a href="items.php?do=manage"><?php echo getItemsCount('Item_ID','items');?></a></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-comments" >
                        <i class="fas fa-comment icon"></i>
                        <div class="info">
                            Total Comments
                            <span >3500</span>
                        </div>
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
                       echo '<ul class="list-unstyled">';
                       while ($row = mysqli_fetch_assoc($LatestUsers)){
                           ?>
                             <li>
                                 <?php echo $row['UserName'] ;?>

                                 <a href="members.php?do=Edit&UserID=<?php echo $row['UserID'];?>" class="btn btn-warning fa-pull-right">Update <i class="fas fa-user-edit"></i></a>
                            <?php
                            if ($row['RegStatus'] == 0){
                                echo "<a href='members.php?do=Activate&UserID=" . $row['UserID'] . "' class='btn btn-info fa-pull-right'>Activate<i class='fas fa-hand-pointer'></i></a>";
                            }
                            ?>

                             </li>

                           <?php
                       }
                       echo '</ul>';
                       ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel-head text-center" >
                        <i class="fas fa-tags"></i> Latest <?php echo $LatestItemsLimit;?> Items
                    </div>
                    <div class="panel-body" >
                        <?php
                        echo '<ul class="list-unstyled">';
                        while ($row = mysqli_fetch_assoc($LatestItems)){
                            ?>
                            <li>
                                <?php echo $row['Item_Name'] ;?>

                                <a href="items.php?do=Edit&ItemID=<?php echo $row['Item_ID'];?>" class="btn btn-warning fa-pull-right">Update <i class="fas fa-user-edit"></i></a>
                                <?php
                                if ($row['Approve'] == 0){
                                    echo "<a href='items.php?do=Approve&ItemID=" . $row['Item_ID'] . "' class='btn btn-info fa-pull-right'>Activate<i class='fas fa-hand-pointer'></i></a>";
                                }
                                ?>

                            </li>

                            <?php
                        }
                        echo '</ul>';
                        ?>
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