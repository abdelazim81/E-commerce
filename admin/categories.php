<?php
session_start();
if (isset($_SESSION['UserName'])){
    $pageTitle='Categories';
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
    if ($do == 'manage'){
        // manage Page HERE
        $selectCategories = "SELECT * FROM categories";
        $result           = mysqli_query($connection,$selectCategories);
        if (! $result){errorDisplay(array('Cannot Get All Categories'));}
        ?>
        <div class="container">
            <h1 class="text-center">Manage Categories</h1>
            <div class="panel-head mng-cat text-center">
                <i class="fas fa-sitemap"></i> Categories
            </div>
            <div class="panel-body categories">


                <?php
                while ($cats = mysqli_fetch_assoc($result)){
                    echo "<div class='cat'>";
                        echo "<h3>" . $cats['Name'] . "</h3>";
                        echo "<p>" . $cats['Description'] . "</p>";
                        if ($cats['visibility'] == 1){
                            echo "<span class='visibility'>" .  'Hidden'  . "</span>";
                        }
                        if ($cats['Allow_Comment'] == 1){
                            echo "<span class='commenting'>" .  'Comments Disabled'  . "</span>";
                        }
                        if ($cats['Allow_Ads'] == 1){
                            echo "<span class='Ads'>" .  'Ads Disabled'  . "</span>";
                        }
                    echo "</div>";
                }
                ?>


            </div>
            <a href="categories.php?do=Create" class=" btn btn-primary">Add New Category <i class="fas fa-plus"></i> </a>
        </div>
<?php
    }elseif ($do == 'Create'){
        // Start create Page
?>
        <div class="login-form text-center">
            <form  method="post" class="form" action="categories.php?do=Store">
                <h3 class="text-center">Create New Category</h3>
                <div class="form-group ">
                    <input type="text" class="form-control" name="name" placeholder="Enter Category Name!" required>
                </div>
                <div class="form-group">
                    <input  type="text" name="description"  class="form-control" placeholder="Enter Category Description Here!">
                </div>
                <div class="form-group">
                    <input  type="text" name="ordering"  class="form-control" placeholder="Enter Category ordering Here!">
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <label for="">Visibility</label>
                    </div>
                    <div class="col-sm-9">
                        <div>
                            <input type="radio" name="visibility" value="0" checked id="vis-yes">
                            <label for="vis-yes"> Yes</label>
                        </div>
                        <div>
                            <input type="radio" name="visibility" value="1"  id="vis-no">
                            <label for="vis-no"> No</label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <label for="">Allow commenting</label>
                    </div>
                    <div class="col-sm-9">
                        <div>
                            <input type="radio" name="commenting" value="0" checked id="com-yes">
                            <label for="com-yes"> Yes</label>
                        </div>
                        <div>
                            <input type="radio" name="commenting" value="1"  id="com-no">
                            <label for="com-no"> No</label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <label for="">Allow Ads</label>
                    </div>
                    <div class="col-sm-9">
                        <div>
                            <input type="radio" name="Ads" value="0" checked id="ads-yes">
                            <label for="vis-yes"> Yes</label>
                        </div>
                        <div>
                            <input type="radio" name="Ads" value="1"  id="ads-no">
                            <label for="ads-no"> No</label>
                        </div>
                    </div>
                </div>

                <button type="submit" name="createCategory" class="btn btn-primary">Add New Category</button>
            </form>
        </div>
<?php
    }elseif ($do == 'Store'){
        if (isset($_POST['createCategory'])){
            $name       = $_POST['name'];
            $Desc       = $_POST['description'];
            $Ordering   = $_POST['ordering'];
            $visibility = $_POST['visibility'];
            $commenting = $_POST['commenting'];
            $Ads        = $_POST['Ads'];
            if (empty($name)){
                errorDisplay(array('Name Of Category Must Not Be Empty'));
            }else{
                $insertCategoryQuery = "INSERT INTO `categories` (`Name`, `Description`, `Ordering`, `visibility`, `Allow_Comment`, `Allow_Ads`) VALUES ( '$name', '$Desc', '$Ordering', '$visibility', '$commenting', '$Ads')";
                $flag = mysqli_query($connection, $insertCategoryQuery);
                if(! $flag){
                    errorDisplay(array('Cannot Add New Category'));
                }
            }


        }
    }
    include $temps . 'footer.php';
}else{
    header('index.php');
}