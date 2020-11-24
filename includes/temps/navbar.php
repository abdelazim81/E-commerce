        <!--login logic-->
<?php
    if (isset($_SESSION['userName'])){
        // if there is session
        $unactivatedUsers =  getUnactivatedUserCount($_SESSION['userName']);
        if ($unactivatedUsers == 1){
            // when user is not activated
           echo "you need to be activated";
        }
?>
<div class="container">
    <div class="upper-bar">
        <span class="right"><a class="right btn btn-danger" href="logout.php">LogOut</a></span>
    </div>
</div>
<?php
    }else{
        // if there is no session
?>
<div class="container">
        <div class="upper-bar">
            <span class="right"><a class="right btn btn-success" href="login.php">Login | SingUp</a></span>
        </div>
</div>
<?php
    }
?>


                <!--End login Logic-->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
   <div class="container">
       <a class="navbar-brand" href="index.php"><?php echo lang('home');?></a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
       </button>

       <div class="collapse navbar-collapse" id="navbarSupportedContent">
           <ul class="navbar-nav">
               <?php
                    $categories = getCategories();
                    while ($category = mysqli_fetch_assoc($categories)){
               ?>

               <li class="nav-item">
                   <a class="nav-link" href="categories.php?catID=<?php echo $category['ID'];?>&catName=<?php  echo str_replace(' ','-',$category['Name']);?>"><?php echo $category['Name'];?></a>
               </li>
               <?php } ?>
           </ul>

       </div>
   </div>
</nav>