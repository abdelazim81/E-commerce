<div class="upper-bar">
    Upper Bar For Login And SignUp
</div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
   <div class="container">
       <a class="navbar-brand" href="dashboard.php"><?php echo lang('home');?></a>
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
                   <a class="nav-link" href="categories.php?catID=<?php echo $category['ID'];?>"><?php echo $category['Name'];?></a>
               </li>
               <?php } ?>
           </ul>

       </div>
   </div>
</nav>