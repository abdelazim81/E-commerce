<?php
session_start();
if (isset($_SESSION['UserName'])){
    $pageTitle = 'Members';
    include 'init.php';
    $do = isset($_GET['do'])? $_GET['do'] : 'manage';
    if ($do == 'manage'){
        // start manage page
    }elseif ($do =='Edit'){
        //start Edit Page
?>
      <div class="edit-user-form" style="margin-left: -1770px;margin-top: 25px">
          <div class="container">
              <h1 class="text-center">Edit Page</h1>
              <form action="" class="form justify-content-center">
                  <div class="form-group ">
                      <div class="col-md-4">
                          <label for="UserName">UserName</label>
                      </div>
                      <div class="col-md-6">
                          <input type="text" name="UserName" class="form-control">
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-md-4">
                          <label for="Password">Password</label>
                      </div>
                      <div class="col-md-6">
                          <input type="password" name="Password" class="form-control">
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-md-4">
                          <label for="Email">Email</label>
                      </div>
                      <div class="col-md-6">
                          <input type="email" name="Email" class="form-control">
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-md-4">
                          <label for="FullName">FullName</label>
                      </div>
                      <div class="col-md-6">
                          <input type="text" name="FullName" class="form-control">
                      </div>
                  </div>
                  <div class="col-sm-6">
                      <button type="submit" name="editUser" class="btn btn-success btn-lg">Save <i class="fas fa-save"></i></button>
                  </div>

              </form>
          </div>
      </div>
<?php
    }

}else{
    header('Location: index.php');
}

include $temps . 'footer.php';