<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
   <div class="container">
       <a class="navbar-brand" href="#"><?php echo lang('home');?></a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
       </button>

       <div class="collapse navbar-collapse" id="navbarSupportedContent">
           <ul class="navbar-nav mr-auto">

               <li class="nav-item">
                   <a class="nav-link" href="#"><?php echo lang('categories');?></a>
               </li>
               <li class="nav-item">
                   <a class="nav-link" href="#"><?php echo lang('items');?></a>
               </li>
               <li class="nav-item">
                   <a class="nav-link" href="#"><?php echo lang('members');?></a>
               </li>
               <li class="nav-item">
                   <a class="nav-link" href="#"><?php echo lang('statistics');?></a>
               </li>
               <li class="nav-item">
                   <a class="nav-link" href="#"><?php echo lang('logs');?></a>
               </li>


           </ul>
           <ul class="navbar-nav">
               <li class="nav-item dropdown">
                   <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <?php
                       if (isset($_SESSION['UserName'])) {
                           echo $_SESSION['UserName'] . ' ';
                           echo "<i class='fas fa-user'></i>";
                       }else{
                           echo "<i class='fas fa-user'></i>";
                       }?>
                   </a>
                   <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                       <a class="dropdown-item" href="members.php?do=Edit&UserID=<?php echo $_SESSION['UserID']; ?>"><?php echo lang('editProfile');?></a>
                       <a class="dropdown-item" href="#"><?php echo lang('settings');?></a>
                       <div class="dropdown-divider"></div>
                       <a class="dropdown-item" href="logout.php"><?php echo lang('logout');?></a>
                   </div>
               </li>
           </ul>
       </div>
   </div>
</nav>