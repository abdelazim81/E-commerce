<?php
session_start();
if (isset($_SESSION['UserName'])){
    $pageTitle = 'Items';
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
    if ($do == 'manage'){
        // start manage page
        echo "<a href='items.php?do=Add' class='btn btn-primary'> Add New Item Page</a>";
    }elseif ($do == 'Add'){
        // start add page
        ?>
            <div class=" login-form text-center">
                <form  method="post" class="form" action="items.php?do=Store">
                    <h3 class="text-center">Add New Item</h3>
                    <div class="form-group ">
                        <input type="text" class="form-control" name="name" placeholder="Enter Item Name!"  >
                    </div>
                    <div class="form-group ">
                        <input type="text" class="form-control" name="description" placeholder="Enter Item Description!"  >
                    </div>
                    <div class="form-group">
                        <input type="text" value="" name="price"  class="form-control" placeholder="Enter Item Price!" >
                    </div>
                    <div class="form-group ">
                        <input type="text" class="form-control" name="country" placeholder="Enter Country Made!" >
                    </div>
                    <!-- SELECT BOX FOR STATUS-->
                    <div class="form-group ">
                        <label for="status"> Status</label>
                        <select name="status" id="status">
                            <option value="0">Select Status</option>
                            <option value="1">New</option>
                            <option value="1">Like New</option>
                            <option value="1">Used</option>
                            <option value="1">Very Old</option>
                        </select>
                    </div>
                    <!--SELECT BOX FOR MEMBERS-->
                    <div class="form-group ">
                        <label for="user"> User</label>
                        <select name="user" id="user">
                            <option value="0">Select User</option>
                            <?php
                            $selectUsers = "SELECT * FROM users";
                            $flag =mysqli_query($connection, $selectUsers);
                            if (! $flag){
                                errorDisplay(array("Cannot Get Users"));
                            }else{
                                while( $user = mysqli_fetch_assoc($flag)){

                                    echo "<option value='" . $user['UserID'] . "'> " . $user['UserName'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <!--SELECT BOX FOR CATEGORIES-->
                    <div class="form-group ">
                        <label for="categories">Categories</label>
                        <select name="categories" id="categories">
                            <option value="0">Select Category</option>
                            <?php
                            $selectUsers = "SELECT * FROM categories";
                            $flag =mysqli_query($connection, $selectUsers);
                            if (! $flag){
                                errorDisplay(array("Cannot Get Users"));
                            }else{
                                while( $cat = mysqli_fetch_assoc($flag)){

                                    echo "<option value='" . $cat['ID'] . "'> " . $cat['Name'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <button class="btn btn-warning" type="reset">Reset Data <i class="fas fa-redo"></i></button>
                    <button type="submit" name="addNewItem" class="btn btn-primary">Add Item <i class="fas fa-folder-plus"></i> </button>
                </form>
            </div>
        <?php
    }elseif ($do =="Store"){
        if (isset($_POST['addNewItem'])){
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $price = $_POST['price'];
            $country = $_POST['country'];
            $status = $_POST['status'];
            $user  = $_POST['user'];
            $category = $_POST['categories'];
            $errors_array = array();
            if (empty($name)){
                $errors_array[] = "Name Of The Item Cannot Be Empty Please Enter A Name";
            }
            if (empty($desc)){
                $errors_array[] = "Description Of The Item Cannot Be Empty Please Enter Descriptive Sentences";
            }
            if (empty($price)){
                $errors_array[] = "Price Of The Item Cannot Be Empty Please Enter The Price";
            }
            if (empty($country)){
                $errors_array[] = "The Country Of Item Cannot Be Empty Please Enter Where It Is From";
            }
            if ($status == 0){
                $errors_array[] = "Please Enter The Status Of The Item";
            }
            if ($user == 0){
                $errors_array[] = "Please Enter The Member Of The Item";
            }
            if ($category == 0){
                $errors_array[] = "Please Enter The Category Of The Item";
            }
            if (empty($errors_array)){
                $insertItemQuery = "INSERT INTO `items` (`Item_Name`, `Item_Desc`, `Item_Price`, `Item_Date`, `Item_Country`, `Item_Image`, `Item_Status`, `Item_Rating`, `Cat_ID`, `Member_ID`) VALUES ( '$name', '$desc', '$price', now(), '$country', NULL, '$status', NULL, '$category', '$user')";
                $flag = mysqli_query($connection,$insertItemQuery);
                if (! $flag){
                    errorDisplay(array('Cannot Insert New Items'));
                }else{
                    successDisplay('New Item Inserted Successfully');
                    header('refresh:5;url=items.php');
                    exit();
                }
            }else{
                errorDisplay($errors_array);
            }
        }else{
            errorDisplay(array("You Can\'t Get This Page Directly"));
            header('refresh:5;url=index.php');
            exit();
        }
    }
    include $temps . 'footer.php';
}else{
    header('Location: index.php');
}