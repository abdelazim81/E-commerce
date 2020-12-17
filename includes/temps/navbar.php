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
           <ul class="navbar-nav login-logic-area">
               <?php if (isset($_SESSION['userName'])){?>
                   <li class="nav-item">
                       <a class="btn btn-primary" href="newAd.php">New</a>
                   </li>
                   <li class="nav-item">
                       <a class="btn btn-info" href="profile.php">Profile</a>
                   </li>
                   <li class="nav-item">
                       <a class="btn btn-danger" href="logout.php">Logout</a>
                   </li>
              <?php }else{ ?>
               <li class="nav-item">
                   <a class="btn btn-success" href="login.php">Login/Signup</a>
               </li>
               <?php } ?>







           </ul>

       </div>
   </div>
</nav>