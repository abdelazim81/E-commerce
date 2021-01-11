<?php
session_start();
if (isset($_SESSION['UserName'])){
    $pageTitle='Categories';
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
    if ($do == 'manage'){
        // manage Page HERE
        $sort = "DESC";
        $sort_array = array("ASC","DESC");
        if (isset($_GET['sort'] ) && in_array($_GET['sort'],$sort_array)){
            $sort = $_GET['sort'];
        }
        $selectCategories = "SELECT * FROM categories WHERE parent = 0 ORDER BY `Ordering` $sort";
        $result           = mysqli_query($connection,$selectCategories);
        if (! $result){errorDisplay(array('Cannot Get All Categories'));}
        ?>
        <div class="container">
            <h1 class="text-center">Manage Categories</h1>
            <div class="panel-head mng-cat text-center">
                <i class="fas fa-sitemap"></i> Categories
                <div class="ordering fa-pull-right">
                    Order:
                    <a class="<?php if ($sort=='ASC'){echo 'active';}?>" href="?sort=ASC">Asc</a> |
                    <a class="<?php if ($sort=='DESC'){echo 'active';}?>" href="?sort=Desc">Desc</a>
                </div>
            </div>
            <div class="panel-body categories">


                <?php
                // Display all categories

                while ($cats = mysqli_fetch_assoc($result)){
                    $parent = $cats['ID'];
                    $getSubCats = "SELECT * FROM categories WHERE parent ='$parent' ORDER BY `Ordering` $sort";
                    $subCats = mysqli_query($connection,$getSubCats);
                    if (! $subCats){
                        errorDisplay(array("Cannot get sub categories"));
                    }
                    echo "<div class='cat'>";
                    echo "<div class='hidden-button'>";
                    echo "<a href='categories.php?do=Edit&catID=" . $cats['ID'] . "' class='btn btn-warning'><i class='fas fa-edit'></i> Edit</a>";
                    echo "<a href='categories.php?do=Delete&catID=" . $cats['ID'] . "' class='confirm btn btn-danger'><i class='fas fa-window-close'></i> DELETE</a>";
                    echo "</div>";
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
                        if ($subCats->num_rows > 0){
                            echo "<h5> Sub Categories : </h5>";
                            echo "<ul class='list-unstyled'>";
                            while ($subCat = mysqli_fetch_assoc($subCats)){
                                echo "<li class='sub-cat'>" . "<a href='categories.php?do=Edit&catID=" . $subCat['ID'] . "' </a>" .  $subCat['Name'] . "<a href='categories.php?do=Delete&catID=" . $subCat['ID'] . "' class=' delete-sub confirm btn btn-danger'><i class='fas fa-window-close'></i></a>" . "</li>";
                            }
                            echo "</ul>";
                        }
                    echo "</div>";
                }
                ?>


            </div>
            <a href="categories.php?do=Create" class=" btn btn-primary text-center">Add New Category <i class="fas fa-plus"></i> </a>
        </div>
<?php
    }elseif ($do == 'Create'){
        // Start create Page
?>
        <div class="container text-center add-cat">
            <form  method="post" class="form" action="categories.php?do=Store">
                <h3 class="text-center">Create New Category</h3>
                <div class="form-group ">
                    <input type="text" class="form-control" name="name" placeholder="Enter Category Name!" required>
                </div>
                <div class="form-group">
                    <input  type="text" name="description"  class="form-control" placeholder="Enter Category Description Here!">
                </div>

                <!--START SUB CATEGORIES SELECT BOX-->
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-2">
                            <label for="parent">Parent</label>
                        </div>
                        <div class="col-sm-10">
                            <select name="parent" id="parent">
                                <option value="0">None</option>
                                <?php
                                //get all parent categories
                                $getCats = "select * from categories where parent=0";
                                $cats    = mysqli_query($connection,$getCats);
                                if (! $cats){
                                    errorDisplay(array("Cannot get categories"));
                                }
                                while($cat = mysqli_fetch_assoc($cats)){
                                    ?>
                                    <option value="<?php echo $cat['ID'];?>"><?php echo $cat['Name'];?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>
                <!--END SUB CATEGORIES SELECT BOX-->


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
            $parent     = $_POST['parent'];
            $Ordering   = $_POST['ordering'];
            $visibility = $_POST['visibility'];
            $commenting = $_POST['commenting'];
            $Ads        = $_POST['Ads'];
            if (empty($name)){
                errorDisplay(array('Name Of Category Must Not Be Empty'));
            }else{
                $insertCategoryQuery = "INSERT INTO `categories` (`Name`, `Description`, `parent`, `Ordering`, `visibility`, `Allow_Comment`, `Allow_Ads`) VALUES ( '$name', '$Desc', '$parent', '$Ordering', '$visibility', '$commenting', '$Ads')";
                $flag = mysqli_query($connection, $insertCategoryQuery);
                if(! $flag){
                    errorDisplay(array('Cannot Add New Category'));
                }
                successDisplay("New category is Added");
                successDisplay("You will be redirected to categories page after 5 seconds");
                header('refresh:5;url=categories.php');
            }


        }else{
            errorDisplay(array("You Can\'t Get This Page Directly"));
            header('refresh:5;url=index.php');
        }
    }elseif ($do == 'Edit'){
        // start edit page
        if (isset($_GET['catID'])){
            $catID = intval($_GET['catID']);
            $selectCategory = "SELECT * FROM categories WHERE ID = '$catID'";
            $result = mysqli_query($connection, $selectCategory);
            if (!$result){errorDisplay(array('Cannot get this category'));}
            while($row = mysqli_fetch_assoc($result)){
                ?>
            <div class="container text-center add-cat">
                <form  method="post" class="form" action="categories.php?do=Update">
                    <h3 class="text-center">Create New Category</h3>
                    <div class="form-group ">
                        <input type="hidden" name="ID" value="<?php echo $row['ID'];?>">
                        <input type="text" class="form-control" name="name" value="<?php echo $row['Name'];?>" required>
                    </div>
                    <div class="form-group">
                        <input  type="text" name="description"  class="form-control" value="<?php echo $row['Description'];?>">
                    </div>

                    <!--START SUB CATEGORIES SELECT BOX-->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="parent">Parent</label>
                            </div>
                            <div class="col-sm-10">
                                <select name="parent" id="parent">
                                    <option value="0">None</option>
                                    <?php
                                    //get all parent categories
                                    $getCats = "select * from categories where parent=0";
                                    $cats    = mysqli_query($connection,$getCats);
                                    if (! $cats){
                                        errorDisplay(array("Cannot get categories"));
                                    }
                                    while($cat = mysqli_fetch_assoc($cats)){

                                        ?>
                                        <option value="<?php echo $cat['ID'];?>"
                                            <?php
                                                    if ($row['parent'] == $cat['ID']) {
                                                        echo "SELECTED";
                                                    }
                                            ?>
                                        >
                                            <?php echo $cat['Name'];?>
                                        </option>

                                    <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--END SUB CATEGORIES SELECT BOX-->


                    <div class="form-group">
                        <input  type="text" name="ordering"  class="form-control" value="<?php echo $row['Ordering'];?>">
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="">Visibility</label>
                        </div>
                        <div class="col-sm-9">
                            <div>
                                <input type="radio" name="visibility" value="0" id="vis-yes" <?php if ($row['visibility'] == 0){ echo 'checked';}?>>
                                <label for="vis-yes"> Yes</label>
                            </div>
                            <div>
                                <input type="radio" name="visibility" value="1" id="vis-no" <?php if ($row['visibility'] == 1){ echo 'checked';}?>>
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
                                <input type="radio" name="commenting" value="0" <?php if ($row['Allow_Comment'] == 0){ echo 'checked';}?> id="com-yes">
                                <label for="com-yes"> Yes</label>
                            </div>
                            <div>
                                <input type="radio" name="commenting" value="1"  id="com-no" <?php if ($row['Allow_Comment'] == 1){ echo 'checked';}?>>
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
                                <input type="radio" name="Ads" value="0"  id="ads-yes" <?php if ($row['Allow_Ads'] == 0){ echo 'checked';}?>>
                                <label for="vis-yes"> Yes</label>
                            </div>
                            <div>
                                <input type="radio" name="Ads" value="1"  id="ads-no" <?php if ($row['Allow_Ads'] == 1){ echo 'checked';}?>>
                                <label for="ads-no"> No</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" name="updateCategory" class="btn btn-primary">Save <i class="fas fa-save"></i></button>
                </form>
            </div>

                <?php
            } // end of while loop for dispalying items to edit
            }
        }elseif ($do ==  'Update'){
        // start of update page
        if (isset($_POST['updateCategory'])){
            $ID = $_POST['ID'];
            $Name = $_POST['name'];
            $Description = $_POST['description'];
            $parent      = $_POST['parent'];
            $Ordering = $_POST['ordering'];
            $Visibility = $_POST['visibility'];
            $Allow_Comment = $_POST['commenting'];
            $Allow_Ads = $_POST['Ads'];
            $updateCategory = "UPDATE categories SET Name='$Name', Description='$Description', parent='$parent', Ordering='$Ordering',
                                   visibility='$Visibility', Allow_comment='$Allow_Comment',
                                   Allow_Ads='$Allow_Ads' WHERE ID='$ID' ";
            $result = mysqli_query($connection,$updateCategory);
            if (! $result){
                errorDisplay(array('Cannot update the category'));
            }else{
                successDisplay('Category Updated Successfully and you will be redirected to categories page');
                header('refresh:5;url=categories.php');
            }

        }else{
            errorDisplay(array("You Can\'t Get This Page Directly"));
            header('refresh:5;url=index.php');
        }
    }elseif ($do == 'Delete'){
        if (isset($_GET['catID'])){
            $ID = $_GET['catID'];
            $deleteCatQuery = "DELETE FROM categories WHERE ID='$ID'";
            $flag = mysqli_query($connection,$deleteCatQuery);
            if ($flag){
                successDisplay('DELETED and you will be redirected');
                header('refresh: 5;url=categories.php');
                exit();
            }else{
                $errors = array('Cannot Delete A Category');
                errorDisplay($errors);
                header('refresh: 5;url=categories.php');
                exit();
            }
        }else{
            errorDisplay(array("You Can\'t Get This Page Directly"));
            header('refresh:5;url=index.php');
        }
    }


    include $temps . 'footer.php';
}else{
    header('Location: index.php');
}